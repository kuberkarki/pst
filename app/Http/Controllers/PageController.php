<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Page;

class PageController extends JoshController
{
    
    /**
     * Show the pages.
     *
     * @access public
     * @return Response
     */
    public function index()
    {
    	$pages = Page::orderBy("order_by", "ASC")
    	->paginate(config('sitesettings.pagination.limit'));
    	 
    	$totalPages = Page::count();
    	 
    	return view('admin.page.index', [
    			'pages' => $pages,
    			'totalPages' => $totalPages
    	]);
    }
    
    /**
     * Show the form for creating a new page
     *
     * @access public
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.page.create');
    }
    
    /**
     * Store a newly created page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    			'name' => 'required'
    	]);
    
    	if ($validator->fails())
    	{
    		return redirect()
    		->back()
    		->withInput()
    		->withErrors($validator);
    	}
    	 
    	$page = Page::create([
    			'name' => $request->input('name'),
    			'slug' => str_slug($request->input('name'), "-"),
    			'content' => $request->input('content')
    	]);
    	 
    	return redirect('/admin/page/create')
    	->with('success', 'Page created successfully.');
    }
    
    /**
     * Show the page form for editing
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
    	if(is_null($page = Page::find($id)))
    	{
    		return redirect('admin/pages')
    		->with('error', 'Page not found.');
    	}
    	
    	return view('admin.page.edit', [
    		'page' => $page
    	]);
    }
    
    /**
     * Update the page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {
    	$validator = Validator::make($request->all(), [
    			'name' => 'required'
    	]);
    	
    	if ($validator->fails())
    	{
    		return redirect()
    		->back()
    		->withInput()
    		->withErrors($validator);
    	}
    	
    	if(is_null($page = Page::find($id)))
    	{
    		return redirect('admin/pages')
    		->with('error', 'Page not found.');
    	}
    	
    	$page->name = $request->input('name');
    	$page->slug = str_slug($request->input('name'), "-");
    	$page->content = $request->input('content');
    	$page->save();
    	
    	return redirect()
    	->back()
    	->with('success', 'Page edited successfully.');
    }
    
    /**
     * Perform page action - destroy
     *
     * @access public
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDo(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    			'page_id' => 'required|integer',
    			'action_type' => 'required|in:destroy',
    			'redirect_url' => 'required|url',
    	]);
    
    	$validator->after(function($validator) use ($request) {
    		$page = Page::find($request->input('page_id'));
    		 
    		if (is_null($page))
    		{
    			$validator
    			->errors()
    			->add('page_id', 'Page does not exists.');
    		}
    	});
    		 
    		if ($validator->fails())
    		{
    			return redirect($request->input('redirect_url'))
    			->withInput()
    			->withErrors($validator);
    		}
    		 
    		$returnVal = $this->_doAction($request);
    		 
    		return redirect($request->input('redirect_url'))
    		->with($returnVal["messageType"], $returnVal["message"]);
    }
    
    /**
     * Perform page action - destroy
     *
     * @access private
     * @param Request $request
     * @return multitype:string
     */
    private function _doAction(Request $request)
    {
    	$page = Page::find($request->input('page_id'));
    
    	$messageType = 'error';
    	$message = 'Action could not be performed. Please try again.';
    
    	if('destroy' == $request->input('action_type'))
    	{
    		if($page->delete())
    		{
    			$messageType = 'success';
    			$message = 'Page is successfully deleted.';
    		}
    	}
    
    	return [
    			"messageType" => $messageType,
    			"message" => $message
    	];
    }
    
    /**
     * Save page order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveOrder(Request $request)
    {
    	$messages = [
    			'integer' => 'Ordering must be an integer.',
    	];
    	
    	$validator = Validator::make($request->all(), [
    			'ordering.*' => 'integer'
    	], $messages);
    
    	if ($validator->fails())
    	{
    		return redirect()
    		->back()
    		->withInput()
    		->withErrors($validator);
    	}
    	
    	if($request->input('ordering') && 
    	count($request->input('ordering')))
    	{
    		foreach($request->input('ordering') as $pageId => $orderBy)
    		{
    			if( !is_null($page = Page::find($pageId)))
    			{
    				$page->order_by = $orderBy;
    				$page->save();
    			}
    		}
    	}
    
    	return redirect('/admin/pages')
    	->with('success', 'Page order saved successfully.');
    }
}
