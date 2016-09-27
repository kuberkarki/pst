<?php

namespace App\Http\Controllers;

use Activation;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use File;
use Hash;
use Illuminate\Http\Request;
use Lang;
use Mail;
use Redirect;
use Reminder;
use Sentinel;
use URL;
use View;
use Input;
use Validator;
use Session;
use Carbon\Carbon;

use Cart;
use App\Product;
use App\Pricebookentry;
use App\Purchase;
use App\Contact;
use App\Contract;
use App\Account;
use App\Opportunity;
use App\Opportunitylineitem;
use App\Order;
use App\Orderitem;
use App\shipment_rule__c;
use App\e_com_discount__c;
use App\e_com_coupon__c;
use App\e_com_rule_criteria__c;
use App\e_com_category__c;
use App\e_com_block__c;
use Cloudder;



class FrontEndController extends JoshController
{

    /*
     * $user_activation set to false makes the user activation via user registered email
     * and set to true makes user activated while creation
     */
    private $user_activation = true;

    public function mainpage($slug){
           // $setting=SF_settings::where('name','eXpress main settings')->first();


            $attigo__home_top_links__c=explode(';',$this->sfsettings->attigo__home_top_links__c);

            $attigo__footer_links__c=explode(';',$this->sfsettings->attigo__footer_links__c);

            $main_menu=array();
            for($i=0;$i<count($attigo__home_top_links__c);$i=$i+2){

                if($slug==str_slug($attigo__home_top_links__c[$i])){
                     $category_id=$attigo__home_top_links__c[$i+1];
                     //$selected_category['name']=$home_top_links__c[$i];
                }
                
            }
            
            if(!isset($category_id)){

                //dd($footer_links__c);

                for($i=0;$i<count($attigo__footer_links__c);$i=$i+2){

                    if($slug==str_slug($attigo__footer_links__c[$i])){
                         $category_id=$attigo__footer_links__c[$i+1];
                         //$selected_category['name']=$home_top_links__c[$i];
                    }
                    
                }
                

                 if(!isset($category_id))
                    $selected_category=e_com_category__c::find($slug);
                else
                    $selected_category=e_com_category__c::find($category_id);

                
            }else{
                $selected_category=e_com_category__c::find($category_id);
            }

        if(!isset($selected_category))
                return Redirect::to(404); 

        //echo $selected_category->category_type__c;exit;

        if( $selected_category->attigo__category_type__c=='content - layout 1')
            return view('content-layout1',compact('selected_category'));

        if( $selected_category->attigo__category_type__c=='content - layout 2')
            return view('content-layout2',compact('selected_category'));



            // Grab all the users
        
        if(!Sentinel::check()){
            return Redirect::to('login'); 

        }

        $current_category=$selected_category->id;
        $user = Sentinel::getUser();
        $contact=Contact::where('email',$user->email)->with('account')->first();
        //$contract=Contract::where('accountid',$contact->account->sfid)->first();
        $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();

        //var_dump($contract);exit;
        $categories=e_com_category__c::where('attigo__active__c','1')->where('attigo__include_in_main_menue__c','1')->orderby('id')->get();
 
        //var_dump($categories[0]);exit;

       


       //echo $current_category;exit;

        //var_dump($contract->pricebook2id);exit;

        $attigo__product_access_level__c=$contact->attigo__product_access_level__c;


        if($attigo__product_access_level__c){
            //echo "here";exit;

            switch ($attigo__product_access_level__c) {
                case 'Level 1':
                    $level=1;
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1');

                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                           
                    break;
                case 'Level 2':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 3':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 4':

                    $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3')
                             ->orWhere('attigo__product_access_level__c','=','Level 4');
                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                
                default:
                    //not to show if product level is not set
                     $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->get();
                    break;
            }
        }
        else{
            //echo "hereere";exit;
             $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->get();
        }

       

        //var_dump($prods);exit;
       /* if($contact->account===NULL){
            $pricebookid='01s58000001vXOaAAM';
        }else if(!$contact->account->pricebook__c){
             $pricebookid='01s58000001vXOaAAM'; 
         }else{
             $pricebookid=$contact->account->pricebook__c;
         }*/
       //echo $pricebookid;exit;
        $i=0;
        $products=array();
        foreach ($prods as $prod) {
            $price=Pricebookentry::
            where('product2id',$prod->sfid)
            ->where('pricebook2id',$contract->pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->get();

            if(isset($price[0])){
                $products[$i]=$prod;           
                $products[$i]->standardprice=$price[0]->unitprice?$price[0]->unitprice:NULL;
                $i++;
            }
        }

            return view('products',compact('products','categories','selected_category'));

    }

    public function index(){
       /* $url = 'https://en.gravatar.com/' . md5( strtolower( trim( $this->email ) ) ) . '.php';
        if($this->get_http_response_code($url) == "200"){
            $str = file_get_contents($url);
            $profile = unserialize($str);
            if ( is_array( $profile ) && isset( $profile['entry'] ) ){
                $this->first_name = $profile['entry'][0]['name']['givenName'];
                $this->last_name = $profile['entry'][0]['name']['familyName'];
                $this->vanity_url = $profile['entry'][0]['preferredUsername'];
                $this->bio_long = $profile['entry'][0]['aboutMe'];
            }
        }*/

        
        $carts=Cart::content();
        // Grab all the users
        
        $user = Sentinel::getUser();
        $contact=Contact::where('email',$user->email)->with('account')->first();
        if($contact==NULL){
            Sentinel::logout();
           return Redirect::route('login');
            exit;
        }
        $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();

        //$categories=e_com_category__c::where('attigo__active__c','1')->orderby('id')->get();
       // $current_category=$categories[0]->id;
        $attigo__product_access_level__c=$contact->attigo__product_access_level__c;
        $current_category=99;
        if($attigo__product_access_level__c){
            //echo "here";exit;

            switch ($attigo__product_access_level__c) {
                case 'Level 1':
                    $level=1;
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1');

                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                           
                    break;
                case 'Level 2':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 3':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 4':

                    $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3')
                             ->orWhere('attigo__product_access_level__c','=','Level 4');
                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->attigo__display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                
                default:
                    //not to show if product level is not set
                     $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->with('productsdetails')->get();
                    break;
            }
        }
        else{
            //echo "hereere";exit;
             $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->get();
        }

        $i=0;
        $products=array();
        foreach ($prods as $prod) {
            $price=Pricebookentry::
            where('product2id',$prod->sfid)
            ->where('pricebook2id',$contract->pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->get();

            if(isset($price[0])){
                $products[$i]=$prod;           
                $products[$i]->standardprice=$price[0]->unitprice?$price[0]->unitprice:NULL;
                $i++;
            }
        }
        $blocks=array();
        $blocks1_raw=e_com_block__c::where('attigo__block_position__c','1')->first();
        $blocks1=array();
        $i=0;
        $b=1;
        if(count($blocks1_raw))
        foreach($blocks1_raw->images()->get() as $im){
            if (filter_var($im->attigo__background_image_or_color__c, FILTER_VALIDATE_URL)) { 
                      $blocks1[$i]['bg']="background-image:url(".$im->attigo__background_image_or_color__c.");";
                }else{
                     $blocks1[$i]['bg']="background-color:".$im->attigo__background_image_or_color__c.";";
                }

                $blocks1[$i]['caption']=$im->attigo__caption__c;//'Smart Watches';
                $blocks1[$i]['caption_color']=$im->attigo__caption_color__c;
                $blocks1[$i]['caption_description']=$im->attigo__caption_description__c;
                $blocks1[$i]['link_button_text']=$im->attigo__link_button_text__c;
                $blocks1[$i]['link']=$im->link__c;
                $blocks1[$i]['foreground_image']=$im->attigo__foreground_image_url__c;
                $blocks1[$i]['image_postion']=$pos=$im->foreground_image_position__c;

                if(strpos($pos,'right')>0)
                    $blocks1[$i]['caption_postion']='left';
                else
                    $blocks1[$i]['caption_postion']="right";


                $i++;

        }
        $blocks[$b]=$blocks1;
    //blocks 2, 3, 4, 5, 6
        for($j=2;$j<=6;$j++){
            ///block $i
            $blocks_raw=e_com_block__c::where('attigo__block_position__c',$j)->first();
            $blocks2=array();
            $i=0;
            $b++;
            if(count($blocks_raw))
            foreach($blocks_raw->images()->get()->take(1) as $im){
                if (filter_var($im->attigo__background_image_or_color__c, FILTER_VALIDATE_URL)) { 
                          $blocks[$j][$i]['bg']="background-image:url(".$im->attigo__background_image_or_color__c.");";
                    }else{
                         $blocks[$j][$i]['bg']="background-color:".$im->attigo__background_image_or_color__c.";";
                    }

                    $blocks[$j][$i]['caption']=$im->attigo__caption__c;//'Smart Watches';
                    $blocks[$j][$i]['caption_color']=$im->attigo__caption_color__c;
                    $blocks[$j][$i]['caption_description']=$im->attigo__caption_description__c;
                    $blocks[$j][$i]['link_button_text']=$im->attigo__link_button_text__c;
                    $blocks[$j][$i]['link']=$im->link__c;
                    $blocks[$j][$i]['foreground_image']=$im->attigo__foreground_image_url__c;
                    $blocks[$j][$i]['image_postion']=$pos=$im->attigo__foreground_image_position__c;

                    if(strpos($pos,'right')>0)
                        $blocks[$j][$i]['caption_postion']='left';
                    else
                        $blocks[$j][$i]['caption_postion']="right";

                if($pos=='top-left')
                        $blocks[$j][$i]['image_postion']='top: 10px; left: -20px; width: 120px;';
                elseif($pos=='top-right')
                        $blocks[$j][$i]['image_postion']='top: 10px; right: -2px; width: 120px;';
                elseif($pos=='bottom-left')
                        $blocks[$j][$i]['image_postion']='bottom: 0px; left: -32px; width: 120px;';
                else
                        $blocks[$j][$i]['image_postion']='bottom: 0px; right: 0px; width: 120px;';


                    $i++;

            }
        }

        //tabs
        $marketing=explode(';',$this->sfsettings->attigo__home_marketing_categories__c);
        $tabs_categories=array();
        for($i=0;$i<count($marketing);$i=$i+2){
            if($i==0)
                $tabs_categories[$i]['class']='active';
            else
                $tabs_categories[$i]['class']='';
            $tabs_categories[$i]['id']=$marketing[$i+1];
            $tabs_categories[$i]['name']=$marketing[$i];
            $tabs_categories[$i]['products']=$this->productsByCategoryId($marketing[$i+1],$attigo__product_access_level__c,$contract->pricebook2id);
        }

        //tabs
        $slide_products_category=explode(';',$this->sfsettings->attigo__home_product_slider__c);
       
            
            
            $slide_products['title']=$slide_products_category[0];
            $slide_products['products']=$this->productsByCategoryId($slide_products_category[1],$attigo__product_access_level__c,$contract->pricebook2id);
        



        return View('index',compact('blocks','tabs_categories','slide_products'))
        ->with('carts',$carts)->with('featuredproducts',$products);
    }

    public function search($q,$ajax=null){
        $level_products=array();
        $q=strtolower($q);
        if(Sentinel::check()){
            $cu=Sentinel::getUser();
            $contact=Contact::where('email',$cu->email)->with('account')->first();
            //dd($contact);
            $attigo__product_access_level__c=$contact->attigo__product_access_level__c;
            $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
            //$queryarray['q']=$q;
            //$queryarray['attigo__product_access_level__c'];

            $prods = Product::where(function($query) use ($q){
                            //$query->where('name','like',"%$q%")
                            //$query->where('name like ',array($q))
                        $query->whereRaw( 'LOWER(name) like ?', array("%$q%"));
                          // $query->where( 'name', 'ilike', "%$q%" );
                                     /*->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%")*/
                        })
                     ->where(function($query) use($attigo__product_access_level__c){
                        if($attigo__product_access_level__c=='Level 1')
                            $query->where('attigo__product_access_level__c','=','Level 1');
                        elseif($attigo__product_access_level__c=='Level 2'){
                             $query->where('attigo__product_access_level__c','=','Level 1');
                             $query->orWhere('attigo__product_access_level__c','=','Level 2');
                        }
                        elseif($attigo__product_access_level__c=='Level 3'){
                             $query->where('attigo__product_access_level__c','=','Level 1');
                             $query->orWhere('attigo__product_access_level__c','=','Level 2');
                             $query->orWhere('attigo__product_access_level__c','=','Level 3');
                        }
                        elseif($attigo__product_access_level__c=='Level 4'){
                             $query->where('attigo__product_access_level__c','=','Level 1');
                             $query->orWhere('attigo__product_access_level__c','=','Level 2');
                             $query->orWhere('attigo__product_access_level__c','=','Level 3');
                             $query->orWhere('attigo__product_access_level__c','=','Level 4');
                        }
                         
                    })
                  ->where('attigo__available_for_e_commerce__c','1')
                  ->where(function($query){
                    if($this->sfsettings->display_out_of_stock_products__c==false){
                        $query->where('attigo__available_qty__c','>',0);

                    }
                    })->with('productsdetails')
                    ->get();


             $level_products=$prods;
        

       // print_r($level_products);exit;

        $array=array();
        foreach($level_products as $product){
            if(isset($product->productsdetails->thumbnail))
                $image= Cloudder::show($product->productsdetails->thumbnail,array("width"=>50, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"));//$product->productsdetails->thumbnail;
            elseif($product->attigo__external_product_image__c)
                $image=$product->attigo__external_product_image__c;
            else
                $image=asset('/assets/img/thebox/500x500.png');
            $price=Pricebookentry::
            where('product2id',$product->sfid)
            ->where('pricebook2id',$contract->pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->get();

            if(isset($price[0])){
                $array[]=array($product->name,$product->id,$image);
            }
            
        }

        if($ajax)
            return json_encode($array);
        else{

        if(count($level_products)==1){
            return Redirect::route('product',$level_products[0]->id);
        }

            $products=array();
            $i=0;
        
        foreach ($level_products as $prod) {
            $price=Pricebookentry::
            where('product2id',$prod->sfid)
            ->where('pricebook2id',$contract->pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->get();

            if(isset($price[0])){
                $products[$i]=$prod;           
                $products[$i]->standardprice=$price[0]->unitprice?$price[0]->unitprice:NULL;
                $i++;
            }
        }



            return view('search')->with('q',$q)->with('products',$products);
        }
        }
        return false;
    }
    public function clearcart(){
        Cart::destroy();
        return redirect()->route('cart')
             ->with('successful', 'cart cleared!');
    }

    public function applycoupon(Request $request){
        Session::set('coupon', $request->get('coupon'));
        return Redirect::route("cart")->with('success', 'coupon applied');
        
    }
    public function removecoupon(Request $request){
        Session::forget('coupon');
        $items=cart::content();
            foreach($items as $item){
                if(strpos($item->id, ':free_discount') !== false){
                   $rowId = Cart::search(array('id' => $item->id));
                 Cart::remove($rowId[0]);
                }
            }
        return Redirect::route("cart")->with('success', 'coupon removed');
        
    }

    

    public function getOrder(REQUEST $request)
    {
        $user = Sentinel::getUser();
        $countries = $this->countries;
        $carts=Cart::content();
        $contact=Contact::with('account')->where('email',$user->email)->first();
        //print_r($contact[0]);exit;
        $cart=array();
        $shipments=shipment_rule__c::where('attigo__active__c',1)->get();
        $products_weight=0;
        $large_shipment=0;
        $total_item=0;
        foreach ($carts as $car) {
            /*$language=Product::get($car->id);
           $car->languages=$language;
           $carts[]=$car;*/
           $product=Product::find(explode(':',$car->id)[0]);
           //var_dump($product->weight_kg__c);exit;
            $car->languagestext=$product->attigo__language__c;
            $car->languages=explode(';',$product->attigo__language__c);
            

            $products_weight=$products_weight+$product->attigo__weight_kg__c*$car->qty;

            if($product->attigo__large_special_shipment__c==1)
                $large_shipment=1;

            $total_item=$total_item+$car->qty;


            
            
           
            $cart[]=$car;
        }
        $shipmentoptions=array();

        //echo $products_weight;exit;


        foreach($shipments as $shipment){
                //echo $shipment->attigo__weight_from_kg__c;exit;
                if($products_weight>=$shipment->attigo__weight_from_kg__c && $products_weight <= $shipment->attigo__weight_to_kg__c){
                    if($large_shipment==1 && $shipment->attigo__can_handle_large_object__c==1)
                        $shipmentoptions[]=$shipment;
                    if($large_shipment==0 && $shipment->attigo__can_handle_large_object__c==0)
                        $shipmentoptions[]=$shipment;
                }
            }

       // var_dump($cart[0]->shipmentoptions[0]->shipment_price__c);exit;

        //echo $request->input('shipment');exit;
        return view('order')
             ->with('carts',$cart)
             ->with('user',$user)
             ->with('countries',$countries)
             ->with('shipmentoptions',$shipmentoptions)
             ->with('total_item',$total_item)
             ->with('selectedshipment',$request->input('shipment'))
             ->with('contact',$contact);
    }

    public function postOrder(Request $request)
    {



        $shippingamount=$request->input('shippingtotal');

        if($shippingamount<=0){
            return redirect()->route('cart')
            ->with('error', 'No Shipping Options for your order. Can\'t add to order!!');
        }

        $carts=Cart::content();
        $amount=Cart::total();

        $user = Sentinel::getUser();
        // Checking is product valid
        // 
        $product='';
        $order_vat=0;
        foreach($carts as $item){
            $product='';//$product.' , '.$item->name.' [id: '.$item->id.' , Qty: '.$item->qty.']';
            $product=Product::find($item->options->originalid);
            $order_vat +=(floatval($product->vat__c)*floatval($item->price)/100)*floatval($item->qty);
        }
        

        $shippingproduct=Product::where('productcode','Shipping')->first();
        $shipping_vat=0;
        //echo $product->name;exit;
        if($shippingproduct->vat__c){
            $shipping_vat=($shippingamount*$shippingproduct->attigo__vat__c)/100;
            $order_vat +=$shipping_vat;

        }
        //echo $order_vat;exit;
       // echo $order_vat;exit;
        if(!count($carts))
                return redirect()->route('order')
                    ->withErrors('Product not valid!')
                    ->withInput();

        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $shipping_address = $request->input('shipping_street').','.$request->input('shipping_city').','.$request->input('shipping_city').','.$request->input('shipping_country');

       // var_dump($user->toArray());exit;

       $transaction_id=rand(0,99999999).time();

       //get pricebook2id
        $contact=Contact::where('email',$user->email)->with('account')->first();
        $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
             $pricebookid=$contract->pricebook2id;


        // Create purchase record in the database
        // Purchase::create([
        //     'user_id' => $user->id,
        //     'product' => $product,
        //     'amount' => $amount,
        //     'transaction_id' => $transaction_id,
        //     'shipping_address'=>$shipping_address,
        // ]);

        //$opportunityid=substr($this->randomKey(18),0,18);

        /*$opport=Opportunity::create([
            'iswon' => 1,
            'stagename' => 'Closed Won',
            'probability' => floatval(100),
            'name' => $product,
            'accountid'=>$contact->account->sfid,
            //'sfid'=>$opportunityid,
            'externalid__c'=>$opportunityid,
           'pricebook2id'=>$pricebookid,
            'amount'=>floatval($amount),
            'closedate'=>date('Y-m-d'),
            //'isdeleted'=>0,
            //'createddate'=>date('Y-m-d H:i:s'),
        ]);*/

        if($request->input('attigo__temporary_shipping_address__c')){
            $shippingcountry = $request->input('shipping_country');
            $shippingstate = $request->input('shipping_state');
            $shippingpostalcode = $request->input('shipping_postalcode');
            $shippingstreet= $request->input('shipping_street');
            $shippingcity= $request->input('shipping_city');
            $shippinglongitude = null;
            $shippinglatitude = null;
            $attigo__temporary_shipping_address__c='1';
            
        }else{
            $shippingcountry = $contact->account->shippingcountry;
            $shippingstate = $contact->account->shippingstate;
            $shippingcity = $contact->account->shippingcity;
            $shippingpostalcode = $contact->account->shippingpostalcode;
            $shippingstreet= $contact->account->shippingstreet;
            $shippinglongitude = $contact->account->shippinglongitude;
            $shippinglatitude = $contact->account->shippinglatitude;
            $attigo__temporary_shipping_address__c='0';
        }
        $orderid=substr($this->randomKey(18),0,18).time();
        $orderinsert=Order::create([
            'contractid'=>$contract->sfid,
            'shippingcountry' => $shippingcountry,
            'shippingstate' => $shippingstate,
            'shippingpostalcode' => $shippingpostalcode,
            'shippingstreet' => $shippingstreet,
            'shippingcity' => $shippingcity,
            'shippinglongitude' => $shippinglongitude,
            'shippinglatitude' => $shippinglatitude,
            
            'billingcountry' => $contact->account->shippingcountry,
            'billingstate' => $contact->account->shippingstate,
            'billingcity' => $contact->account->shippingcity,
            'billingpostalcode' => $contact->account->shippingpostalcode,
            'billingstreet' => $contact->account->shippingstreet,
            'billinglongitude' => $contact->account->shippinglongitude,
            'billinglatitude' => $contact->account->shippinglatitude,
            'statuscode' => 'D',
            'status' => 'Draft',//floatval(100),
            //'name' => $product,
            'accountid'=>$contact->account->sfid,
            //'sfid'=>$opportunityid,
            'attigo__externalid__c'=>$orderid,
           'pricebook2id'=>$pricebookid,
            'totalamount'=>floatval($amount),
            'name'=>'',
            'effectivedate'=>date('Y-m-d'),
            'customerauthorizedbyid'=>$contact->sfid,
            'attigo__ecommerce_order_contact__c'=>$contact->sfid,
            'attigo__e_commerce_order__c'=>true,
            'attigo__temporary_shipping_adress__c'=>$attigo_attigo__temporary_shipping_address__c,
            'attigo__vat__c'=>$order_vat,
            'attigo__ecom_externalid_c__c'=>$orderid,
            //'sfid'=>$orderid
        ]);



        $order=Order::find($orderinsert->id);
        $start_time = time();
        $timeout=0;

        while(!$order->ordernumber && !$timeout){
            
            $order=Order::find($orderinsert->id);
            if ((time() - $start_time) > 30) {
                $order->delete();
                unset($order);
                $timeout=1;
                
            }
        }
        if($timeout){
             return redirect()->route('cart')
            ->with('error', 'Something went wrong while taking your order.Please try again!!');
            exit;
        }
       //echo  $opportunityid;
        foreach($carts as $item){
            $getid=explode(':',$item->id);
            $product=Product::find($getid[0]);
            //echo $product->name;exit;
            $price=Pricebookentry::where('product2id',$product->sfid)->where('pricebook2id',$pricebookid)->first();
            //var_dump($price->sfid);exit;
           /*var_dump($product->price[0]->sfid);exit;
             var_dump($item);exit;*/

            if(!count($price)){
                $price->sfid=null;
            }

            /*Opportunitylineitem::create([
            'unitprice' => floatval($item->price),
            'productcode' => $product->productcode,
            'product2id' => $product->sfid,
            'pricebookentryid' => $price->sfid,
            //'totalprice'=>floatval($item->subtotal),
            'name'=>$product->name,
            'quantity'=>floatval($item->qty),
            //'sfid'=>substr($this->randomKey(18),0,18),
            'opportunityid'=>$opportunity->sfid,
            'opportunity__externalid__c'=>$opportunityid,
            //'createddate'=>date('Y-m-d H:i:s'),
        ]);*/

        $vat=(floatval($product->attigo__vat__c)*floatval($item->price)/100)*floatval($item->qty);
        Orderitem::create([
            'unitprice' => floatval($item->price),
            'listprice' => floatval($item->price),
            'productcode' => $product->productcode,
            //'product2id' => $product->sfid,
            'pricebookentryid' => $price->sfid,
            //'totalprice'=>floatval($item->subtotal),
            //'name'=>$product->name,
            'quantity'=>floatval($item->qty),
            //'sfid'=>substr($this->randomKey(18),0,18),
            'orderid'=>$order->sfid,
            'attigo__order__externalid__c'=>$orderid,
            'description'=>$item->options->sellanguage,
            'attigo__product_vat__c'=>$vat,
            //'vat__c'=>$vat,
            'attigo__product_vat_pct__c'=>$product->attigo__vat__c
            //'createddate'=>date('Y-m-d H:i:s'),
        ]);

        }

        $shippingamount=$request->input('shippingtotal');

        if($shippingamount>0){
            $product=Product::where('productcode','Shipping')->first();
            //echo $product->name;exit;
            $price=Pricebookentry::where('product2id',$product->sfid)->where('pricebook2id',$pricebookid)->first();


            Orderitem::create([
            'unitprice' => floatval($shippingamount),
            'listprice' => floatval($shippingamount),
            'productcode' => $product->productcode,
            //'product2id' => $product->sfid,
            'pricebookentryid' => $price->sfid,
            //'totalprice'=>floatval($item->subtotal),
            //'name'=>$product->name,
            'quantity'=>1,
            //'sfid'=>substr($this->randomKey(18),0,18),
            'orderid'=>$order->sfid,
            'attigo__order__externalid__c'=>$orderid,
            'description'=>$request->input('shippingdescription'),
            'attigo__product_vat__c'=>$shipping_vat,
            //'vat__c'=>$vat,
            'attigo__product_vat_pct__c'=>$shippingproduct->attigo__vat__c
            //'createddate'=>date('Y-m-d H:i:s'),
        ]);

        }

        


       // exit;
        Cart::destroy();

        
        

        return redirect()->route('confirmation')
            ->with('success', 'Your purchase was successful!')
            ->with('orderid',$order->id);
    }

    public function confirmation(){
        $user = Sentinel::getUser();
        $order_id=Session::get('orderid');
        if(!$order_id){
            return redirect()->route('products')
            ->with('error', 'Something went wrong!');
        }
        $message='';
        if(Session::get('successful')){
            $message="Your Purchase was successful !";
        }
        if(Session::get('error')){
            $message="Your Purchase was unsuccessful !";
        }

        $order=Order::listbyemail($user->email,$order_id); 
        //var_dump($order[0]->or,deritem);exit;


            $summary=array();
            foreach($order[0]->orderitem as $orderitem){
                 //print_r($orderitem);exit;
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->listprice,'vat'=>$orderitem->attigo__product_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c);
                
                
            }
           // print_r($summary);
            $order[0]->summary=$summary;
           
        //var_dump($order);exit;
           //echo Session::get('orderid');
           return View::make('confirmation')->with('message', $message)->with('orders',$order[0]);
       // echo $orderid;

    }

    /*
    * Corn call for Contacts Sync
     */
    public function synccontact(){
        $lastuser=User::orderBy('created_at','DESC')->first();
        print_r($lastuser->created_at->format('Y-m-d H:i:s'));
        $contacts=Contact::where('createddate','>',$lastuser->created_at->format('Y-m-d H:i:s'))->where('attigo__express_portal_access__c','Y')->get();

       // print_r($contacts);
        foreach($contacts as $contact){
            //check whether use should be activated by default or not
            $activate = true;//$request->get('activate') ? true : false;
            $usrarr['email']=$contact->email;
            $usrarr['password']='password';
             $usrarr['first_name']=$contact->firstname;
             $usrarr['last_name']=$contact->lastname;
            // Register the user
            $user = Sentinel::register($usrarr, $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleById(2);
            if ($role) {
                $role->users()->attach($user);
            }
            //check for activation and send activation mail if not activated by default
            if (!$activate) { 
                // Data to be used on the email view
                $data = array(
                    'user' => $user,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                );

                // Send the activation code through email
                Mail::send('emails.register-activate', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject('Welcome ' . $user->first_name);
                });
            }
               echo "<br/>".$contact->email." Done";
           
      
        }
        echo "Done";
    }

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin()
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }

        // Show the login page
        return View::make('login');
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postLogin(Request $request)
    {

        try {
            // Try to log the user in
            if (Sentinel::authenticate($request->only('email', 'password'), $request->get('remember', 0))) {
                return Redirect::route("home")->with('success', Lang::get('auth/message.login.success'));
            } else {
                return Redirect::to('login')->with('error', 'Username or password is incorrect.');
                //return Redirect::back()->withInput()->withErrors($validator);
            }

        } catch (UserNotFoundException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
        } catch (NotActivatedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
        } catch (UserSuspendedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_suspended'));
        } catch (UserBannedException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_banned'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->messageBag->add('email', Lang::get('auth/message.account_suspended', compact('delay')));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * get user details and display
     */
    public function myAccount(User $user)
    {

        $user = Sentinel::getUser();
        $countries = $this->countries;
        $raworders=Order::listbyemail($user->email);
        $orders=array();
       
        foreach($raworders as $raworder){
             $summary=array();
            if(!isset($raworder->orderitem)){
                Sentinel::logout();
                 return Redirect::to('login')->with('error', 'No Account Found!');
            }
            foreach($raworder->orderitem as $orderitem){
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity);
                
                
            }
           // print_r($summary);
            $raworder->summary=$summary;
            $orders[]=$raworder;
        }
        //var_dump($orders);exit;

        return View::make('user_account', compact('user', 'countries','orders'));
    }

    /**
     * update user details and display
     * @param Request $request
     * @param User $user
     * @return Return Redirect
     */
    public function update(Request $request, User $user)
    {

        $user = Sentinel::getUser();

        //update values
        $user->first_name = $user->first_name;//$request->get('first_name');
        $user->last_name = $user->last_name;//$request->get('last_name');
        $user->email = $user->email;//$request->get('email');
        //$user->dob = $request->get('dob');
        // $user->bio = $request->get('bio');
        // $user->gender = $request->get('gender');
        // $user->country = $request->get('country');
        // $user->state = $request->get('state');
        // $user->city = $request->get('city');
        // $user->address = $request->get('address');
        // $user->postal = $request->get('postal');

        unset($user->details);


        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }
        // is new image uploaded?
        // if ($file = $request->file('pic')) {
        //     $fileName = $file->getClientOriginalName();
        //     $extension = $file->getClientOriginalExtension() ?: 'png';
        //     $folderName = '/uploads/users/';
        //     $destinationPath = public_path() . $folderName;
        //     $safeName = str_random(10) . '.' . $extension;
        //     $file->move($destinationPath, $safeName);

        //     //delete old pic if exists
        //     if (File::exists(public_path() . $folderName . $user->pic)) {
        //         File::delete(public_path() . $folderName . $user->pic);
        //     }

        //     //save new file path into db
        //     $user->pic = $safeName;

        // }

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $success = Lang::get('users/message.success.update');

            // Redirect to the user page
            return Redirect::route('my-account')->with('success', $success);
        }

        // Prepare the error message
        $error = Lang::get('users/message.error.update');


        // Redirect to the user page
        return Redirect::route('my-account')->withInput()->with('error', $error);


    }

    /**
     * Account Register.
     *
     * @return View
     */
    public function getRegister()
    {
        // Show the page
        return View::make('register');
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postRegister(UserRequest $request)
    {
        $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable

        try {
            // Register the user
            $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password', 'gender']), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleByName('User');
            $role->users()->attach($user);

            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view
                $data = array(
                    'user' => $user,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                );

                // Send the activation code through email
                Mail::send('emails.register-activate', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject('Welcome ' . $user->first_name);
                });

                //Redirect to login page
                return Redirect::to("login")->with('success', Lang::get('auth/message.signup.success'));
            }
            // login user automatically
            Sentinel::login($user, false);

            // Redirect to the home page with success menu
            return Redirect::route("my-account")->with('success', Lang::get('auth/message.signup.success'));
            //return View::make('user_account')->with('success', Lang::get('auth/message.signup.success'));

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', Lang::get('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     *
     */
    public function getActivate($userId, $activationCode)
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }

        $user = Sentinel::findById($userId);

        if (Activation::complete($user, $activationCode)) {
            // Activation was successfull
            return Redirect::route('login')->with('success', Lang::get('auth/message.activate.success'));
        } else {
            // Activation not found or not completed.
            $error = Lang::get('auth/message.activate.error');
            return Redirect::route('login')->with('error', $error);
        }
    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page
        return View::make('forgotpwd');

    }

    /**
     * Forgot password form processing page.
     * @param Request $request
     * @return Redirect
     */
    public function postForgotPassword(Request $request)
    {
        try {
            // Get the user password recovery code
            //$user = Sentinel::FindByLogin($request->get('email'));
            $user = Sentinel::findByCredentials(['email' => $request->email]);
            if (!$user) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
            }

            $activation = Activation::completed($user);
            if (!$activation) {
                return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_activated'));
            }

            $reminder = Reminder::exists($user) ?: Reminder::create($user);
            // Data to be used on the email view
            $settings=$this->sfsettings;//SF_settings::where('name','eXpress main settings')->first();

            $msg=$settings->attigo__content_for_password_reset_mail__c;
            $msg=str_replace("\n","<br>",$msg);
            $msg=str_replace('%user',$user->first_name.' '.$user->last_name,$msg);
            $msg=str_replace('%psswd_link',URL::route('forgot-password-confirm', [$user->id, $reminder->code]),$msg);
            $msg=str_replace('%Store_name',$settings->attigo__store_name__c,$msg);

            


            // Data to be used on the email view
            $data = array(
                'user' => $user,
                //'forgotPasswordUrl' => URL::route('forgot-password-confirm', $user->getResetPasswordCode()),
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', [$user->id, $reminder->code]),
                'settings'=>$settings,
                'content'=>$msg
            );

            $sender=array('address' => $settings->attigo__transactional_email_sender__c, 'name' => $settings->attigo__store_name__c);


            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user,$sender) {
                $m->from($sender['address'],$sender['name']);
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
            });
        } catch (UserNotFoundException $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.


        }

        //  Redirect to the forgot password
        return Redirect::to(URL::previous())->with('success', Lang::get('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($userId, $passwordResetCode = null)
    {
        if (!$user = Sentinel::findById($userId)) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }
        $user = Sentinel::findById($userId);

       

        if($reminder = Reminder::exists($user))
        {
            if($passwordResetCode == $reminder->code)
            {
                return View::make('forgotpwd-confirm', compact(['userId', 'passwordResetCode']));
            }
            else{
                return 'code does not match';
            }
        }
        else
        {
            return 'does not exists';
        }


        // Show the page
     //   return View::make('forgotpwd-confirm', compact(['userId', 'passwordResetCode']));
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(Request $request, $userId, $passwordResetCode = null)
    {

        $user = Sentinel::findById($userId);
        if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('login')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('login')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
    }

    /**
     * Contact form processing.
     * @param Request $request
     * @return Redirect
     */
    public function postContact(Request $request)
    {

        // Data to be used on the email view
        $data = array(
            'contact-name' => $request->get('contact-name'),
            'contact-email' => $request->get('contact-email'),
            'contact-msg' => $request->get('contact-msg'),
        );

        // Send the activation code through email
        Mail::send('emails.contact', compact('data'), function ($m) use ($data) {
            $m->from($data['contact-email'], $data['contact-name']);
            $m->to('email@domain.com', @trans('general.site_name'));
            $m->subject('Received a mail from ' . $data['contact-name']);

        });

        //Redirect to contact page
        return Redirect::to("contact")->with('success', Lang::get('auth/message.contact.success'));
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
       // echo "here";exit;
        // Log the user out
        Sentinel::logout();

        // Redirect to the users page
        return Redirect::to('login')->with('success', 'You have successfully logged out!');
    }

     private static function randomKey($size) {
           // echo $size;exit;
            do {
                 $key = openssl_random_pseudo_bytes ( $size , $strongEnough );
            } while( !$strongEnough );
            $key = str_replace( '+', '', base64_encode($key) );
            $key = str_replace( '/', '', $key );
            $key = str_replace( '=', '', $key );

           // $key=substr($key,0,18);

           // echo $key;exit;

            return base64_encode($key);
    }

    private function productsByCategoryId($current_category,$attigo__product_access_level__c,$pricebook2id){
        //$current_category=99;
        if($attigo__product_access_level__c){
            //echo "here";exit;

            switch ($attigo__product_access_level__c) {
                case 'Level 1':
                    $level=1;
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1');

                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                           
                    break;
                case 'Level 2':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 3':
                     $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3');
                             }) 
                         ->where('attigo__available_for_e_commerce__c','1')
                         ->where(function($query){
                            if($this->sfsettings->display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                case 'Level 4':

                    $prods = Product::where(function($query) use ($current_category){
                            $query->where('attigo__web_categories__c','like',"%;$current_category")
                                     ->orWhere('attigo__web_categories__c','like',"$current_category;%")
                                     ->orWhere('attigo__web_categories__c','=',"$current_category")
                                 ->orWhere('attigo__web_categories__c','like',"%;$current_category;%");
                             })
                         ->where(function($query){
                               $query->where('attigo__product_access_level__c','=','Level 1')
                             ->orWhere('attigo__product_access_level__c','=','Level 2')
                             ->orWhere('attigo__product_access_level__c','=','Level 3')
                             ->orWhere('attigo__product_access_level__c','=','Level 4');
                             })
                          ->where('attigo__available_for_e_commerce__c','1')
                          ->where(function($query){
                            if($this->sfsettings->display_out_of_stock_products__c==false){
                                $query->where('attigo__available_qty__c','>',0);

                            }
                        })->with('productsdetails')
                         ->get();
                    break;
                
                default:
                    //not to show if product level is not set
                     $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->with('productsdetails')->get();
                    break;
            }
        }
        else{
            //echo "hereere";exit;
             $prods = Product::where('attigo__product_access_level__c','=','NOLEVEL')->get();
        }

        $i=0;
        $products=array();
        foreach ($prods as $prod) {
            $price=Pricebookentry::
            where('product2id',$prod->sfid)
            ->where('pricebook2id',$pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->get();

            if(isset($price[0])){
                $products[$i]=$prod;           
                $products[$i]->standardprice=$price[0]->unitprice?$price[0]->unitprice:NULL;
                $i++;
            }
        }

        return $products;
    }


}
