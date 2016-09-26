<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;
use App\Http\Requests\CategoryRequest;

class CategoryController extends JoshController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the blog category
        $categories = Category::all();
        // Show the page
        return View('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category($request->all());
~
        if ($category->save()) {
            return redirect('admin/category')->with('success', trans('category/message.success.create'));
        } else {
            return Redirect::route('admin/category')->withInput()->with('error', trans('category/message.error.create'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($category->update($request->all())) {
            return redirect('admin/category')->with('success', trans('category/message.success.update'));
        } else {
            return Redirect::route('admin/category')->withInput()->with('error', trans('category/message.error.update'));
        }
    }

    /**
     * Remove blog.
     *
     * @param $website
     * @return Response
     */
    public function getModalDelete(Category $category)
    {
        $model = 'category';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('delete/category', ['id' => $category->id]);
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('category/message.error.delete', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return redirect('admin/category')->with('success', trans('category/message.success.delete'));
        } else {
            return Redirect::route('admin/category')->withInput()->with('error', trans('category/message.error.delete'));
        }
    }

}
