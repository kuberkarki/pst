<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use File;
use Illuminate\Support\Facades\Request;
use App\Product;
use App\Pricebookentry;
use Redirect;
use Cloudder;
use Sentinel;
use App\Contact;
use App\Account;
use App\Contract;
use App\e_com_category__c;
use App\productsdetail;

class ProductController extends JoshController {

     /**
     * Show a list of all the users.
     *`
     * @return View
     */
    public function index()
    {

         // Cloudder::upload('http://upload.wikimedia.org/wikipedia/commons/0/0c/Scarlett_Johansson_Césars_2014.jpg');
         //        $pic=Cloudder::getPublicId();

         //        $img=Cloudder::show($pic);
         //        echo $img;exit;
        // Grab all the users
        $products = Product::with('productsdetails')->get();

       


        //$price = Product::with('price')->get();
        //print_r($products);exit;

       // var_dump(json_decode($price,true);exit;

        $i=0;
        foreach ($products as $prod) {
            $price=Pricebookentry::
            where('product2id',$prod->sfid)
            ->where('usestandardprice',1)
            ->where('isactive',1)
            ->take(1)
            ->get();
            $products[$i]=$prod;           

            if(count($price) && isset($price[0]->unitprice))
            $products[$i]->standardprice=$price[0]->unitprice?$price[0]->unitprice:NULL;
            $i++;
        }

       

        // Show the page
        return View('admin.Products.index', compact('products'));
    }

     public function products($current_category=null)
    {
        // Grab all the users
        
        $user = Sentinel::getUser();
        $contact=Contact::where('email',$user->email)->with('account')->first();
        //$contract=Contract::where('accountid',$contact->account->sfid)->first();
        $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();

        //var_dump($contract);exit;
        $categories=e_com_category__c::where('attigo__active__c','1')->orderby('id')->get();

        //var_dump($categories[0]);exit;

        if($current_category===null)
            $current_category=$categories[0]->id;


        $selected_category=e_com_category__c::find($current_category);

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

       

        // Show the page
        return View('products', compact('products','categories','selected_category'));
    }

     /**
     * User update.
     *
     * @param  int $id
     * @return View
     */
    public function edit($id = null)
    {
       $product=Product::find($id);
        // Show the page
        return View('admin/Products/edit', compact('product'));
    }

    public function detail($id=null){
        $product=Product::where('id',$id)->with('productsdetails')->first();
        $user = Sentinel::getUser();
        $contact=Contact::where('email',$user->email)->with('account')->first();
        //$contract=Contract::where('accountid',$contact->account->sfid)->first();
        $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
        $price=Pricebookentry::
            where('product2id',$product->sfid)
            ->where('pricebook2id',$contract->pricebook2id)
            ->where('isactive',1)
            ->take(1)
            ->first();

        $product->standardprice=isset($price->unitprice)?$price->unitprice:null;
        $product->prices=$price;
    //dd($price);
        //echo $price->tier2_to_5__c;exit;
        $product->pricesarr=array($price->attigo_tier_1_price__c,$price->attigo_tier_2_price__c,$price->attigo_tier_3_price__c,$price->attigo_tier_4_price__c,$price->attigo_tier_5_price__c);
       /* $product->pricesarr[]=$price->tier2_to_5__c;
        $product->pricesarr[]=$price->tier6_to_10__c;
        $product->pricesarr[]=$price->tier11_to_25__c;
        $product->pricesarr[]=$price->tier25_49__c;
        $product->pricesarr[]=$price->tier50_199__c;*/
        $product->languages=explode(';',$product->attigo__language__c);

        $sfsettings=$this->sfsettings;


        return View('detail', compact('product','sfsettings'));

    }

    /**
     * Product update form processing page.
     *
     * @param  product $product
     * @param ProductRequest $request
     * @return Redirect
     */
    public function update($productid,FileUploadRequest $request)
    {

       $product=Product::find($productid);

        try {
            


            // is new image uploaded?
            if ($file = $request->file('file')) {
                /*$extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/uploads/products/';
                $destinationPath = public_path() . $folderName;
                $safeName = str_random(10) . '.' . $extension;
                $file->move($destinationPath, $safeName);
                //delete old pic if exists
                if (File::exists(public_path() . $folderName . $product->pic)) {
                    File::delete(public_path() . $folderName . $product->pic);
                }
*/
                Cloudder::upload($file);
                $pic=Cloudder::getPublicId();

                $img=Cloudder::show($pic);

                //print_r($img);exit;

                //echo $pic;exit;

                //save new file path into db
                $product->attigo__external_product_image__c = $img;

            }

            //save record
            $product->save();

            

           
           
           
            

            // Was the product updated?
            if ($product->save()) {
                // Prepare the success message
                //$success = Lang::get('products/message.success.update');

                // Redirect to the user page
                return Redirect::route('admin.product.edit', $product)->with('success', "Product Updated");
            }

            // Prepare the error message
            //$error = Lang::get('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            //$error = Lang::get('users/message.user_not_found', compact('user'));
            // Redirect to the Product management page
            return Redirect::route('admin.product.index')->with('error', "Failed");
        }

        // Redirect to the user page
        return Redirect::route('admin.products.edit', $product)->withInput()->with('error', $error);
    }

    /**
     * Product update form processing page.
     *
     * @param  product $product
     * @param ProductRequest $request
     * @return Redirect
     */
    public function generatethumb($productid)
    {

       $product=Product::find($productid);

        try {
            


            // is new image uploaded?
            if ($product->attigo__external_product_image__c) {
                /*$extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/uploads/products/';
                $destinationPath = public_path() . $folderName;
                $safeName = str_random(10) . '.' . $extension;
                $file->move($destinationPath, $safeName);
                //delete old pic if exists
                if (File::exists(public_path() . $folderName . $product->pic)) {
                    File::delete(public_path() . $folderName . $product->pic);
                }
*/
                Cloudder::upload($product->attigo__external_product_image__c);
                $pic=Cloudder::getPublicId();

                $result=Cloudder::getResult();
               // var_dump($result);exit;

                $img=Cloudder::show($pic);

                //print_r($img);exit;

                //echo $pic;exit;

                //save new file path into db
                $productdetails=productsdetail::where('product_sfid',$product->sfid)->first();
                if($productdetails==null)
                    $productdetails=new productsdetail();
                else{
                    Cloudder::destroyImage($productdetails->thumbnail);
                }
                $productdetails->product_sfid = $product->sfid;
                 $productdetails->product_id = 0;
                $productdetails->thumbnail = $pic;
                $productdetails->save();

            }

            //save record
            

            

           
           
           
            

            // Was the product updated?
            if ($product->save()) {
                // Prepare the success message
                //$success = Lang::get('products/message.success.update');

                // Redirect to the user page
                return Redirect::route('admin.product', $product)->with('success', "Thumbnail Generated");
            }

            // Prepare the error message
            //$error = Lang::get('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            //$error = Lang::get('users/message.user_not_found', compact('user'));
            // Redirect to the Product management page
            return Redirect::route('admin.product')->with('error', "Failed");
        }

        // Redirect to the user page
        return Redirect::route('admin.products', $product)->withInput()->with('error', $error);
    }


}
