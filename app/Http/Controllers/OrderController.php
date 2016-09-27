<?php

namespace App\Http\Controllers;

use App\Order;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Redirect;
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
use App\Contact;
use App\Contract;
use App\shipment_rule__c;
use App\Orderitem;
use App\Account;
use App\e_com_discount__c;
use App\e_com_coupon__c;
use App\e_com_rule_criteria__c;
use App\e_com_discount_action__c;
use App\Couponuser;
use Cloudder;
use App\e_com_payment__c;
use App\SF_settings;

class OrderController extends JoshController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $ordersraw = Order::where('attigo__e_com_order_process_status__c','New')->orderBy('createddate')->get();

        $orders=array();

        foreach($ordersraw as $order){
             $contact=Contact::where('sfid',$order->customerauthorizedbyid)->first();
             $account=Account::where('sfid',$contact->accountid)->first();


            $summary=array();
            $shipping_cost=0;
            foreach($order->orderitem as $orderitem){
                 //print_r($orderitem);exit;
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();

                if($pricebookentry->product->name=='Shipping cost'){
                    $shipping_cost =$orderitem->unitprice+$orderitem->attigo__product_vat__c;
                }
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->unitprice,'vat'=>$orderitem->attigo__product_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c,'language'=>$orderitem->description,'product_code'=>$pricebookentry->product->productcode);
                
                
            }
           // print_r($summary);
            $order->shipping_cost=$shipping_cost;
            $order->summary=$summary;
            $order->contact=$contact;
             $order->account=$account;
            if(isset($contact->email))
                $order->email=$contact->email;
            else
                $order->email="user";

            $orders[]=$order;

        }
        return View('admin.Orders.index', compact('orders'));
    }
    public function open($id)
    {
            $order=Order::where('id',$id)->first(); 
        //var_dump($order->orderitem);exit;

            $contact=Contact::where('sfid',$order->customerauthorizedbyid)->first();


            $summary=array();
            foreach($order->orderitem as $orderitem){
                 //print_r($orderitem);exit;
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->listprice,'vat'=>$orderitem->attigo__product_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c);
                
                
            }
           // print_r($summary);
            $order->summary=$summary;
            if(isset($contact->email))
                $order->email=$contact->email;
            else
                $order->email="user";
           
        //var_dump($order);exit;
           //echo Session::get('orderid');
           return View('admin.Orders.detail')->with('orders',$order);
       // echo $orderid;
    }
    public function deliver($id){
        
       $order=Order::find($id);

        try {
            


            $order->attigo__e_com_order_process_status__c='Delivered';


            

           
           
           
            

            // Was the product updated?
            if ($order->save()) {
                // Prepare the success message
                //$success = Lang::get('products/message.success.update');

                // Redirect to the user page
                return Redirect::route('admin.order')->with('success', "Order Delivered");
            }

            // Prepare the error message
            //$error = Lang::get('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            //$error = Lang::get('users/message.user_not_found', compact('user'));
            // Redirect to the Product management page
            return Redirect::route('admin.order.index')->with('error', "Failed");
        }

        // Redirect to the user page
        return Redirect::route('admin.order.edit', $order)->withInput()->with('error', $error);
    }

    public function invoiceindex(){
        $ordersraw = Order::where('attigo__e_com_order_process_status__c','Delivered')->get();

        $orders=array();

        foreach($ordersraw as $order){
             $contact=Contact::where('sfid',$order->customerauthorizedbyid)->first();
             $account=Account::where('sfid',$contact->accountid)->first();


            $summary=array();
            $shipping_cost=0;
            foreach($order->orderitem as $orderitem){
                 //print_r($orderitem);exit;
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;
                if($pricebookentry->product->name=='Shipping cost'){
                    $shipping_cost =$orderitem->unitprice+$orderitem->attigo__product_vat__c;
                }
                $summary[]=array('product_id'=>$pricebookentry->product->id,
                    'product_name'=>$pricebookentry->product->name,
                    'quantity'=>$orderitem->quantity,
                    'listprice'=>$orderitem->unitprice,
                    'vat'=>$orderitem->attigo__product_vat__c,
                    'vat_pc'=>$orderitem->attigo__product_vat_pct__c,
                    'language'=>$orderitem->description,
                    'product_code'=>$pricebookentry->product->productcode);
                
                
            }
           // print_r($summary);
            $order->shipping_cost=$shipping_cost;
            $order->summary=$summary;
            $order->contact=$contact;
             $order->account=$account;
            if(isset($contact->email))
                $order->email=$contact->email;
            else
                $order->email="user";

            $orders[]=$order;

        }
        return View('admin.Orders.invoiceindex', compact('orders'));
    }

    public function invoice($id){
        
       $order=Order::find($id);

        try {
            


            $order->attigo__e_com_order_process_status__c='Invoiced';


            

           
           
           
            

            // Was the product updated?
            if ($order->save()) {
                // Prepare the success message
                //$success = Lang::get('products/message.success.update');

                // Redirect to the user page
                return Redirect::route('admin.order.quickinvoice')->with('success', "Order Invoiced");
            }

            // Prepare the error message
            //$error = Lang::get('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            //$error = Lang::get('users/message.user_not_found', compact('user'));
            // Redirect to the Product management page
            return Redirect::route('admin.order.quickinvoice')->with('error', "Failed");
        }

        // Redirect to the user page
        return Redirect::route('admin.order.edit', $order)->withInput()->with('error', $error);
    }

    

    public function detail($id)
    {
        $user = Sentinel::getUser();
        $contact=Contact::where('email',$user->email)->first();
        // Grab all the blog category
        //$order=Order::where('customerauthorizedbyid',$contact->sfid)->where('e_commerce_order__c',true)
            //->where('sfid',$id)
            //->with('orderitem')->get();

        $order=Order::listbyemail($user->email,$id);

        //dd($order);
        

        if(!count($order)){
            return View('404');
        }

        $summary=array();
        $shipping_cost=0;
            foreach($order[0]->orderitem as $orderitem){
                 //print_r($orderitem);exit;
                $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                //var_dump($pricebookentry->product->name);
                //echo $orderitem->quantity;

                if($pricebookentry->product->name=='Shipping cost'){
                    $shipping_cost =$orderitem->unitprice+$orderitem->attigo__product_vat__c;
                }
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->unitprice,'vat'=>$orderitem->attigo__product_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c,'language'=>$orderitem->description,'product_code'=>$pricebookentry->product->productcode);
                
                
            }

            //dd($summary);
           // print_r($summary);
            $order[0]->shipping_cost=$shipping_cost;
            $order[0]->summary=$summary;
            $account=Account::where('sfid',$contact->accountid)->first();

            $order[0]->contact=$contact;
            $order[0]->account=$account;
            $order[0]->email=$user->email;

            //dd($order[0]->summary);
        // Show the page
        return View('order.detail')->with('orders',$order[0]);
    }

    public function cart(Request $request)
    {

        $show_backorder=false;

        if ($request->isMethod('post')) {
            if ($request->get('id') && $request->get('update_language')) {
               // echo $request->get('id')
                    $rowId = Cart::search(array('id' => $request->get('id')));
                    $item = Cart::get($rowId[0]);

                    Cart::update($rowId[0], ['options'=>['sellanguage'=>$request->get('language')]]);
                }else{

                    $user = Sentinel::getUser();
                    $contact=Contact::where('email',$user->email)->with('account')->first();
                     //$contract=Contract::where('accountid',$contact->account->sfid)->first();
                     $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
                     $pricebookid=$contract->pricebook2id;

                        $product_id = $request->get('product_id');


                        $product = Product::where('id',$product_id)->with('productsdetails')->first();

                        //var_dump($product);exit;
                       /* $shipment=array();
                        $shipment=shipment_rule__c::where('active__c',1)->get();
                        var_dump($shipment);exit;*/


                    $price=Pricebookentry::
                    where('product2id',$product->sfid)
                    ->where('pricebook2id',$pricebookid)
                    ->where('isactive',1)
                    ->first();
                    $qty=(int)$request->get('qty');
                    if($qty>0)
                        ;
                    else
                        $qty=1;

                    $sellanguage='';
                    if($request->get('language'))
                        $sellanguage=$request->get('language');
                    else{
                       $languages= explode(';',$product->attigo__language__c);
                       if(count($languages)){
                            $sellanguage=$languages[0];
                       }
                    }


                    

                       $rowId = Cart::search(array('id' => $product_id.":".$sellanguage));
                        $item = Cart::get($rowId[0]);

                    if($item)
                        $increase=$item->qty;
                    else
                        $increase=0;

                  


            $selprice=$price->unitprice;

            $pricearr=array($price->attigo_tier_1_price__c,$price->attigo_tier_2_price__c,$price->attigo_tier_3_price__c,$price->attigo_tier_4_price__c,$price->attigo_tier_5_price__c);

           // print_r($pricearr);exit;
            $i=0;

            foreach(explode(';',$product->attigo__tier_pricing_levels__c) as $pr){
                if($qty+$increase>=$pr){
                    $selprice=$pricearr[$i]?$pricearr[$i]:$price->unitprice;
                }
                $i++;
                                   
            }

             
            //
            //var_dump($product);exit;
             if($item)
               Cart::update($rowId[0], ['price'=>$selprice,'qty'=>$qty+$increase,'options'=>['sellanguage'=>$sellanguage]]);
            else{
                if(isset($product->productsdetails->thumbnail))
                    $image=Cloudder::show($product->productsdetails->thumbnail,array("width"=>75, "height"=>null, "crop"=>"fill", "fetch_format"=>"auto", "type"=>"upload"));
                elseif(!$product->attigo__external_product_image__c)
                    $image=asset('/assets/img/thebox/500x500.png');
                else
                    $image=$product->external_product_image__c;

                    Cart::add(array('id' => $product_id.':'.$sellanguage, 'name' => $product->name, 'qty' => $qty, 
                        'price' => $selprice, 
                        'options' => [
                        'image' => $image,
                        'sellanguage'=>$sellanguage,
                        'originalunitprice'=>$price->unitprice,
                        'originalid'=>$product_id,
                        'categories'=>$product->attigo__web_categories__c,
                        'productcode'=>$product->productcode
                        ]
                        ));
                }

                 }
            }

         //increment the quantity
        if ($request->get('product_id') && ($request->get('increment')) == 1){
                $user = Sentinel::getUser();
                $contact=Contact::where('email',$user->email)->with('account')->first();
                 //$contract=Contract::where('accountid',$contact->account->sfid)->first();
                 $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
                 $pricebookid=$contract->pricebook2id;

                $product_id = $request->get('product_id');
                $product = Product::find(explode(':',$product_id)[0]);

                $price=Pricebookentry::
                where('product2id',$product->sfid)
                ->where('pricebook2id',$pricebookid)
                ->where('isactive',1)
                ->first();
                $selprice=$price->unitprice;

                $rowId = Cart::search(array('id' => $request->get('product_id')));
                $item = Cart::get($rowId[0]);
                $pricearr=array($price->attigo_tier_1_price__c,$price->attigo_tier_2_price__c,$price->attigo_tier_3_price__c,$price->attigo_tier_4_price__c,$price->attigo_tier_5_price__c);

           // print_r($pricearr);exit;
                $i=0;

                foreach(explode(';',$product->attigo_tier_pricing_levels__c) as $pr){
                    if($item->qty+1>=$pr){
                        $selprice=$pricearr[$i]?$pricearr[$i]:$price->unitprice;
                    }
                    $i++;
                }
             
                Cart::update($rowId[0], ['price'=>$selprice,'qty'=>$item->qty+1]);
                return redirect()->route('cart')
            ->with('success', 'Cart Updated');
            //Cart::update($rowId[0], $item->qty + 1);
        }

        //decrease the quantity
        if ($request->get('product_id') && ($request->get('decrease')) == 1) {
            $user = Sentinel::getUser();
                $contact=Contact::where('email',$user->email)->with('account')->first();
                 //$contract=Contract::where('accountid',$contact->account->sfid)->first();
                 $contract=Contract::where('accountid',$contact->account->sfid)->with('pricebook')->first();
                 $pricebookid=$contract->pricebook2id;

                    $product_id = $request->get('product_id');
                     $product = Product::find(explode(':',$product_id)[0]);

                $price=Pricebookentry::
                where('product2id',$product->sfid)
                ->where('pricebook2id',$pricebookid)
                ->where('isactive',1)
                ->first();



            $selprice=$price->unitprice;
            $rowId = Cart::search(array('id' => $request->get('product_id')));
            $item = Cart::get($rowId[0]);
            $pricearr=array();


            $pricearr=array($price->attigo_tier_1_price__c,$price->attigo_tier_2_price__c,$price->attigo_tier_3_price__c,$price->attigo_tier_4_price__c,$price->attigo_tier_5_price__c);
           // print_r($pricearr);exit;
            $i=0;

            foreach(explode(';',$product->attigo__tier_pricing_levels__c) as $pr){
                if($item->qty-1>=$pr){
                    $selprice=$pricearr[$i]?$pricearr[$i]:$price->unitprice;
                }
                $i++;
                                   
            }

            if($item->qty==1){
               Cart::remove($rowId[0]); 
               return redirect()->route('cart');
            }
            
            Cart::update($rowId[0], ['price'=>$selprice,'qty'=>$item->qty-1]);
            return redirect()->route('cart')
            ->with('success', 'Cart Updated');

            //Cart::update($rowId[0], $item->qty - 1);
        }

        if ($request->get('product_id') && ($request->get('remove')) == 1) {
            $rowId = Cart::search(array('id' => $request->get('product_id')));
            Cart::remove($rowId[0]);

            $items=cart::content();
            foreach($items as $item){
                if(strpos($item->id, ':free_discount') !== false){
                   $rowId = Cart::search(array('id' => $item->id));
                 Cart::remove($rowId[0]);
                }
            }
            return redirect()->route('cart');
        }

        $discount_amount=$this->calculate_discount();

        $cart = Cart::content();
        $carts=array();
        $products_weight=0;
        $large_shipment=0;
        $total_item=0;
        $shipments=shipment_rule__c::where('attigo__active__c',1)->get();
        $backorder_products=array();

        $sfsettings=$this->sfsettings;
        foreach ($cart as $car) {
            /*$language=Product::get($car->id);
           $car->languages=$language;
           $carts[]=$car;*/
           $product=Product::find(explode(':',$car->id)[0]);
            $car->languagestext=$product->attigo__language__c;
            $car->languages=explode(';',$product->attigo__language__c);
            $products_weight=$products_weight+$product->attigo__weight_kg__c*$car->qty;
            if($product->attigo__large_special_shipment__c==1)
                $large_shipment=1;
             $total_item=$total_item+$car->qty;
            

            if($product->attigo__available_qty__c<$car->qty){
                $show_backorder=true;
                $backorder_products[]=$car->options->originalid;
            }


                $carts[]=$car;


        }

        //print_r($backorder_products);exit;

         $shipmentoptions=array();

        //echo $products_weight;exit;


        foreach($shipments as $shipment){
                //echo $shipment->weight_from_kg__c;exit;
                if($products_weight>=$shipment->attigo__weight_from_kg__c && $products_weight <= $shipment->attigo__weight_to_kg__c){
                    if($large_shipment==1 && $shipment->attigo__can_handle_large_object__c==1)
                        $shipmentoptions[]=$shipment;
                    if($large_shipment==0 && $shipment->attigo__can_handle_large_object__c==0)
                        $shipmentoptions[]=$shipment;
                }
            }

        //print_r($$hipmentoptions);
       
        
            ////////////////////////////////////////////////////////////////



        return view('cart', array('cart' => $carts,'shipmentoptions'=>$shipmentoptions,'sfsettings'=>$this->sfsettings,'show_backorder'=>$show_backorder,'total_item'=>$total_item, 'title' => 'Welcome', 'description' => '', 'page' => 'home', 'coupon'=> Session::get('coupon'),'discount_amount'=>$discount_amount,'backorder_products'=>$backorder_products));
    }

    public function getOrder(REQUEST $request)
    {

        $user = Sentinel::getUser();
        $countries = $this->countries;
        $carts=Cart::content();
        $contact=Contact::with('account')->where('email',$user->email)->first();
        $sfsettings=$this->sfsettings;
        $show_backorder=false;
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


            if($product->attigo__available_qty__c<$car->qty){
                $show_backorder=true;
            }
            
           
            $cart[]=$car;
        }
        $shipmentoptions=array();

        //echo $products_weight;exit;


        foreach($shipments as $shipment){
                //echo $shipment->weight_from_kg__c;exit;
                if($products_weight>=$shipment->attigo__weight_from_kg__c && $products_weight <= $shipment->attigo__weight_to_kg__c){
                    if($large_shipment==1 && $shipment->attigo__can_handle_large_object__c==1)
                        $shipmentoptions[]=$shipment;
                    if($large_shipment==0 && $shipment->attigo__can_handle_large_object__c==0)
                        $shipmentoptions[]=$shipment;
                }
            }


    //payment options
            //$paymentoptions=e_com_payment__c::get();
            $account=Account::where('sfid',$contact->accountid)->first();
            $paymentoptions=e_com_payment__c::where('attigo__available_for_all_accounts__c','1')->orWhere('attigo__e_com_account_group__c',$account->attigo__e_com_account_group__c)->get();

           // dd($paymentoptions);


       // var_dump($cart[0]->shipmentoptions[0]->shipment_price__c);exit;
        $coupon=Session::get('coupon');
        $discount_amount=$this->calculate_discount();
        return view('order',compact('paymentoptions'))
             ->with('carts',$cart)
             ->with('user',$user)
             ->with('countries',$countries)
             ->with('shipmentoptions',$shipmentoptions)
             ->with('total_item',$total_item)
             ->with('selectedshipment',$request->input('shipment'))
             ->with('show_backorder',$show_backorder)
             ->with('sfsettings',$sfsettings)
             ->with('coupon',$coupon)
             ->with('discount_amount',$discount_amount)
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
        

        $discount_amount=$this->calculate_discount(true);

        $itemdiscount= Session::get('itemdiscount');
        Session::forget('itemdiscount');

        $total_no_of_cart_item=0;

        foreach($carts as $item){
            if(strpos($item->id, ':free_discount') === false){
                $total_no_of_cart_item++;
            }

            $product='';//$product.' , '.$item->name.' [id: '.$item->id.' , Qty: '.$item->qty.']';
            $product=Product::find($item->options->originalid);
            $order_vat +=(floatval($product->attigo__vat__c)*floatval($item->price)/100)*floatval($item->qty);

        }
        //echo $total_number_of_cart_item;exit;
        

        $shippingproduct=Product::where('productcode','Shipping')->first();
        $shipping_vat=0;
        //echo $product->name;exit;
        if($shippingproduct->attigo__vat__c){
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
            'externalid__c'=>$orderid,
           'pricebook2id'=>$pricebookid,
            'totalamount'=>floatval($amount),
            'name'=>'',
            'effectivedate'=>date('Y-m-d'),
            'customerauthorizedbyid'=>$contact->sfid,
            'attigo__ecommerce_order_contact__c'=>$contact->sfid,
            'attigo__e_commerce_order__c'=>true,
            'attigo__temporary_shipping_adress__c'=>$attigo__temporary_shipping_address__c,
            'attigo__vat__c'=>$order_vat,
            //'ecom_externalid_c__c'=>$orderid,
            'attigo__e_com_order_process_status__c'=>'New',
            'attigo__e_com_shipment__c'=>$request->input('shippingdescription'),
            'attigo__e_com_payment_type__c'=>$request->input('attigo__e_com_payment_type__c'),
            'attigo__e_com_order_method__c'=>$request->input('attigo__e_com_order_method__c'),
            //'sfid'=>$orderid,
            //'ordernumber'=>$orderid
        ]);



        $order=Order::find($orderinsert->id);
        $start_time = time();
        $timeout=0;

        while(!$order->sfid && !$timeout){
            
            $order=Order::find($orderinsert->id);
            if ((time() - $start_time) > 20) {
                $order->delete();
                $timeout=1;
                
            }
        }
        if($timeout){
             return redirect()->route('cart')
            ->with('error', 'Something went wrong while taking your order.Please try again!!');
            exit;
        }
        $start_time = time();

        /*while(!$order->ecom_externalid_c__c && !$timeout){
            
            $order=Order::find($orderinsert->id);
            if ((time() - $start_time) > 30) {
                $order->delete();
                $timeout=1;
                
            }
        }
        if($timeout){
             return redirect()->route('cart')
            ->with('error', 'Something went wrong while taking your order.Please try again!!');
            exit;
        }*/
       //echo  $opportunityid;
        foreach($carts as $item){
            $getid=explode(':',$item->id);
            $product=Product::find($getid[0]);
            $price=Pricebookentry::where('product2id',$product->sfid)->where('pricebook2id',$pricebookid)->first();
            if(!count($price)){
                $price->sfid=null;
            }


        $discount_amount=null;

        if(strpos($item->id, ':free_discount') !== false){
            $discount_amount=0;
            foreach($itemdiscount as $dis){
                if($dis['item']=='product'){
                    if($dis['itemid']==$product->productcode || $dis['itemid']=='[ANY]'){
                        $discount_amount +=$dis['amount'];
                    }
                }
                if($dis['item']=='Cart Discount'){
                    $discount_amount +=$dis['amount']/$total_no_of_cart_item;
                }
                if($dis['item']=='category'){
                    $product_categories=explode(';',$item->options->categories);

                     if(in_array($dis['itemid'],$product_categories) || $dis['itemid']=='[ANY]'){
                            $discount_amount +=$dis['amount'];
                            break;
                     }
                }
            }
         }


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
            'product_vat__c'=>$vat,
            //'vat__c'=>$vat,
            'attigo__product_vat_pct__c'=>$product->attigo__vat__c,
            'attigo__product_discount__c'=>$discount_amount
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

        
        Session::forget('coupon');

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
                $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->listprice,'vat'=>$orderitem->atproduct_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c);
                
                
            }
           // print_r($summary);
            $order[0]->summary=$summary;
           
        //var_dump($order);exit;
           //echo Session::get('orderid');
           return View::make('confirmation')->with('message', $message)->with('orders',$order[0]);
       // echo $orderid;

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

    private  function calculate_discount($returnaction=false){
        //echo $returnaction;exit;
        $coupon=Session::get('coupon');
        $cart_total=Cart::total();
        if(!$coupon)
            return 0;

        $user = Sentinel::getUser();

       //$countcouponused=Couponuser::count($user->id,$coupon);


        $discounts=e_com_discount__c::where('isdeleted',0)
            ->where('attigo__active__c',1)
            ->where('attigo__start_date__c', '<=', Carbon::now()->format('Y-m-d'))
            ->where('attigo__end_date__c', '>=', Carbon::now()->format('Y-m-d'))
            ->whereRaw('attigo__max_usage_number_of_times__c > attigo__total_number_of_uses__c')
            ->where(function($query) use ($coupon){
                               $query->where('attigo__specific_coupon__c',$coupon)
                               ->orWhereNull('attigo__specific_coupon__c')
                               ;

                             })
                       
            ->orderBy('attigo__priority__c')
            ->get();

        $discount_amount=0;

        foreach($discounts as $discount){
            $discount_this=0;

            $lists=e_com_coupon__c::where('attigo__e_com_discount__c',$discount->sfid)->where('attigo__coupon_code__c',$coupon)->get();

           

            if(!count($lists) && $discount->attigo__specific_coupon__c!=$coupon)
                continue;



             $rules=e_com_rule_criteria__c::where('attigo__e_com_discount__c',$discount->sfid)->get();



            //check rules
            $apply_rule=false;
            if(!count($rules))
                $apply_rule=true;
            foreach($rules as $rule){
               $apply_this_rule=$this->apply_rule($rule); 
               
               
               if( $discount->attigo__rule_criteria_type__c=='ALL'){
                $apply_rule=true;
                 if($apply_this_rule==false){
                    $apply_rule=false;
                    break;

                 }
               }

               if( $discount->attigo__rule_criteria_type__c=='ANY'){
                $apply_rule=false;
                 if($apply_this_rule==true){
                    $apply_rule=true;
                    break;

                 }
               }
            }

           
            ///echo $apply_rule;exit;
           

            /* if(isset($rule->min_cart_subtotal__c) && $this->hascategory())
                        $apply_rule=true;*/


            if($apply_rule){
                
                $actions=e_com_discount_action__c::where('attigo__e_com_discount__c',$discount->sfid)->get();

                //print_r($actions);exit;

                

                //check direct amount or percentage
               /* if($discount->discount_type_or_value__c=='Fixed value'){
                    $discount_type='fixed';
                }else{
                    $discount_type='Precentage';
                }*/

                /*if($discount->specific_coupon__c){
                    if($discount_type=='fixed')
                        $discount_this=$discount->discount_value__c;
                    else{
                        $discount_this=$discount->discount_value__c*$discount_in_total/100;
                    }  
                }
                else*/
                    //echo $discount->total_number_of_uses__c;exit;

                 $discount_this=$this->calculate_action_amount($actions,$returnaction);
            
                    if($returnaction){

                        //$newtotalusages=$discount->total_number_of_uses__c+1;
                       $updatetotalosage= e_com_discount__c::find($discount->id);

                       //print_r($updatetotalosage->total_number_of_uses__c);exit;
                       $updatetotalosage->attigo__total_number_of_uses__c=$discount->attigo__total_number_of_uses__c+1;
                       $updatetotalosage->save();

                    }

                /*if($discount->specific_coupon__c){
                    if($discount_type=='fixed')
                        $discount_this=$discount->discount_value__c;
                    else{
                        $discount_this=$discount->discount_value__c*$discount_in_total/100;
                    }  
                }elseif($discount->coupons_from_list__c){
                    
                    foreach($lists as $list){
                        $discount_this += $discount_action_amount=$this->calculate_action_amount($actions);
                            //$discount_this +=$discount->discount_value__c;
                       
                                   
                        
                    }
                }*/

                $discount_amount +=$discount_this;

                if($discount->attigo__stop_further_rules_from_processing__c)
                    break;
            }

        }

        return $discount_amount;
    }

    private  function hascategory($category_id){
        //echo $category_id;exit;

        if($category_id=='[ANY]')
            return true;

        foreach(Cart::content() as $cart){
            //var_dump($cart->options);exit;
            $product_categories=explode(';',$cart->options->categories);
          //print_r($cart);exit;
               if(in_array($category_id,$product_categories))
                return $cart->subtotal;
                        

           }
        
        return false;

    }

    private  function hasproduct($product_id){
        //echo $product_id;exit;

        if($product_id=='[ANY]')
            return true;

        foreach(Cart::content() as $cart){
           
            if($product_id==$cart->options->productcode){
                //echo $cart->qty;exit;
             return $cart->subtotal;
            }
                        

           }
        
        return false;

    }

    private function apply_rule($rule){
        $cart_total=Cart::total();
        
                $apply_rule=false;
                
                        if(isset($rule->attigo__min_cart_subtotal__c)){

                            if($rule->attigo__min_cart_subtotal__c>$cart_total){
                                $apply_min_cart=false;
                            }
                            else
                                $apply_min_cart=true;



                        }else{
                            $apply_min_cart=true;
                        }

                        if(isset($rule->attigo__products_from_category_ids__c)){
                            //todo check categories ids for false condition
                            if($rule->attigo__products_from_category_ids__c=='[ANY]'){
                                $apply_rule_category=true;
                            }elseif($this->hascategory($rule->attigo__products_from_category_ids__c)){
                                $apply_rule_category=true;

                            }else{
                                $apply_rule_category=false;
                            }

                            
                            
                        }else{
                             $apply_rule_category=true;
                        }
                        if(isset($rule->attigo__sku_product_code__c)){
                            
                            //$apply_rule_product_code=true;
                            if($this->hasproduct($rule->attigo__sku_product_code__c)){
                                $apply_rule_product_code=true;

                            }else{
                                $apply_rule_product_code=false;
                            }
                        }else{
                            $apply_rule_product_code=true;
                        }



                        if(isset($rule->attigo__product_family__c)){
                            //todo check family for false
                            $apply_rule_family=true;

                        }else{
                            $apply_rule_family=true;
                        }
                        if(isset($rule->attigo__min_number_of_items_in_cart__c)){
                            //todo check min number of items in cart
                            $total_item=0;
                            foreach(Cart::content() as $car){
                                $total_item +=$car->qty;

                            }

                            

                            if($rule->attigo__min_number_of_items_n_cart__c<=$total_item){
                                $apply_rule_min_items=true;

                            }else{
                                $apply_rule_min_items=false;
                            }
                        }else{
                            $apply_rule_min_items=true;
                        }



                        //echo "--".$apply_min_cart."--";

                        if($apply_min_cart && $apply_rule_category && $apply_rule_product_code && $apply_rule_family && $apply_rule_min_items){
                           
                           
                                $apply_rule=true;
                            }else{
                              
                                $apply_rule=false;
                               return $apply_rule;
                            }


                    return $apply_rule;

               
    }

    private function calculate_action_amount($actions,$returnaction=null){

        
        $discount_in_total=0;
        if(!count($actions)){
            return 0;
        }




        $discount_in_total=0;
        $itemdiscountarray=array();
        foreach($actions as $action){

                    $itemdiscount=array();

                    if($action->attigo__discount_type_or_value__c=='Cart Discount'){


                        $itemdiscount['item']='Cart Discount';
                        $itemdiscount['itemid']=$action->attigo__value_id_sku__c;
                        
                        if($action->attigo__discount_type_or_value__c=='Cart Discount'){
                            $discount_in_total +=$action->attigo__discount_value__c;
                            $itemdiscount['amount']=$action->attigo__discount_value__c;
                           }
                           if($action->attigo__discount_type_or_value__c=='% Discount'){
                            $discount_in_total +=Cart::total()*$action->attigo__discount_value__c/100;
                            $itemdiscount['amount']=Cart::total()*$action->attigo__discount_value__c/100;
                           }
                    }
           
                    elseif($action->attigo__action_item__c=='SKU/Product code'){
                       
                        $discount_in_total +=0;

                        $hasproduct=$this->hasproduct($action->attigo__value_id_sku__c);

                       // echo $action->discount_type_or_value__c;

                        if($hasproduct){
                             $itemdiscount['item']='product';
                             $itemdiscount['itemid']=$action->attigo__value_id_sku__c;
                            
                           if($action->attigo__discount_type_or_value__c=='Fixed value'){
                            $discount_in_total +=$action->attigo__discount_value__c;
                            $itemdiscount['amount']=$action->attigo__discount_value__c;
                           }
                           if($action->attigo__discount_type_or_value__c=='% Discount'){
                            $discount_in_total +=$hasproduct*$action->attigo__discount_value__c/100;
                            $itemdiscount['amount']=$hasproduct*$action->attigo__discount_value__c/100;
                           }

                           if($action->attigo__discount_type_or_value__c=='Free Item'){
                             $product=Product::where('productcode',$action->attigo__value_id_sku__c)->first();

                            if($product){
                                $rowId = Cart::search(array('id' => $product->id.":free_discount"));
                                $freeitem = Cart::get($rowId[0]);

                                $itemdiscount['amount']=0;



                               if(!$freeitem)

                                Cart::add(array('id' => $product->id.':free_discount', 'name' => "(free) ".$product->name, 'qty' => 1, 
                                    'price' => 0, 
                                    'options' => [
                                    'image' => $product->attigo__external_product_image__c,
                                    'sellanguage'=>'',
                                    'originalunitprice'=>'',
                                    'originalid'=>$product->id,
                                    'categories'=>$product->attigo__web_categories__c,
                                    'productcode'=>$product->productcode
                                    ]
                                    ));
                                $discount_in_total +=0;
                                $free_item=true;
                            }
                           }

                        }else
                            $discount_in_total +=0;

                    }elseif($action->attigo__action_item__c=='Category'){
                        //echo "hhh";exit;
                        
                         $hascategory=$this->hascategory($action->attigo__value_id_sku__c);

                         
                        

                        if($hascategory){
                           //print_r($action->discount_type_or_value__c);exit;
                            $itemdiscount['item']='category';
                            $itemdiscount['itemid']=$action->attigo__value_id_sku__c;
                            $itemdiscount['itemtype']=$action->attigo__action_item_type__c;
                           if($action->attigo__discount_type_or_value__c=='Fixed Value'){


                            $discount_in_total +=$action->attigo__discount_value__c;
                            $itemdiscount['amount']=$action->attigo__discount_value__c;
                           }
                           if($action->attigo__discount_type_or_value__c=='% Discount'){
                             $discount_in_total +=$hascategory*$action->attigo__discount_value__c/100;
                             $itemdiscount['amount']=$hascategory*$action->attigo__discount_value__c/100;
                           }

                           if($action->attigo__discount_type_or_value__c=='Free Item'){
                            $discount_in_total +=0;
                           }

                        }else
                            $discount_in_total +=0;
                    }


                if($itemdiscount)
                $itemdiscountarray[]=$itemdiscount;
                }

                //echo $discount_in_total;exit;
                //
               // print_r($itemdiscountarray);exit;
                if($returnaction)
                 Session::set('itemdiscount', $itemdiscountarray);

                return $discount_in_total;
    }


}
