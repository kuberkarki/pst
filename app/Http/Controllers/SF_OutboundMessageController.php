<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Lang;
use Redirect;
use Sentinel;
use View;
use Hash;
use URL;
use Input;
use Validator;
use Session;

use App\Product;
use App\productsdetail;


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
use Cloudder;
use App\User;
use App\SF_settings;


class SF_OutboundMessageController extends Controller
{
     public function saveApiData()
    {
//         $client = new Client();
//         $res = $client->request('GET', 'http://api.nordicnetproducts.se/CompanyInformationService.svc/XML/user/api1212100/passwd/7snpkPuWB4/lang-code/SVE/data-option/1?company-name=efterhj', [
//             'form_params' => [
//                 // 'client_id' => 'test_id',
//                 // 'secret' => 'test_secret',
//             ]
//         ]);
//  $res->getBody();
// //         $result= $res->getBody();
// //         dd($res);

//         //$SF_xml = simplexml_load_string($res->getBody());exit;
             
//         $notificationId = $res->children('text')->Body;
//         echo notificationId;

// $get = file_get_contents('http://api.nordicnetproducts.se/CompanyInformationService.svc/XML/user/api1212100/passwd/7snpkPuWB4/lang-code/SVE/data-option/1?company-name=efterhj');
// $arr = simplexml_load_string($get,'SimpleXMLElement', LIBXML_NOWARNING0);
// print_r($arr);
}
    
    /**
     * Get outbound msg organization id
     * 
     * @access private
     * @return string
     */
    private function _getOutboundMsgOrganizationId()
    {
    	$organizationId = '00D58000000ZuOh';
    	
    	return $organizationId;
    }

    /**
     * Get Sales force outbound message
     * Parse xml and insert ordernumber
     * 
     * @access public
     * @param Request $request
     * @return void
     */
    public function postOutboundMsgOrdernumber(Request $request)
    {
    	$content = $request->getContent();
    	
    	ob_start();
    	echo "This is outbound message when there is order created in SF.";
    	echo "\n\n";
    	echo $content;
    	$cont = ob_get_contents();
    	ob_end_clean();
    	
    	Mail::send('emails.dev', ['msg' => $cont], function ($message) {
    		$message->to('karki.kuber@gmail.com')->subject('debug');
    	});
       
    	
    	if($content)
    	{
    		$SF_xml = simplexml_load_string($content);
    		 
    		$notificationId = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->Id;
    		$sfOrder_sfid = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->Id;

    		$ordernumber = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->OrderNumber;
            $createddate = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->CreatedDate;
    		//$ecom_externalid_c__c = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->ecom_externalID_c__c;
        
    		
    		if($sfOrder_sfid && $ordernumber)
    		{
    			$order = Order::where("sfid", $sfOrder_sfid)->first();
                $order->attigo__ecom_externalid_c__c =$ordernumber;
                $order->createddate=$createddate;
                $order->save();


                $ordermail=Order::where('sfid',$order->sfid)->with('orderitem')->get();

                

           

            $summary=array();
            $shipping_cost=0;
                foreach($ordermail[0]->orderitem as $orderitem){
                     //print_r($orderitem);exit;
                    $pricebookentry=Pricebookentry::where('sfid',$orderitem->pricebookentryid)->with('product')->first();
                    //var_dump($pricebookentry->product->name);
                    //echo $orderitem->quantity;
                   /* $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->listprice,'vat'=>$orderitem->product_vat__c,'vat_pc'=>$orderitem->product_vat_pct__c);*/

                    if($pricebookentry->product->name=='Shipping cost'){
                    $shipping_cost =$orderitem->unitprice+$orderitem->attigo__product_vat__c;
                    }
                    $summary[]=array('product_id'=>$pricebookentry->product->id,'product_name'=>$pricebookentry->product->name,'quantity'=>$orderitem->quantity,'listprice'=>$orderitem->unitprice,'vat'=>$orderitem->attigo__product_vat__c,'vat_pc'=>$orderitem->attigo__product_vat_pct__c,'language'=>$orderitem->description,'product_code'=>$pricebookentry->product->productcode);
                    
                    
                }
           // print_r($summary);
            $ordermail[0]->shipping_cost=$shipping_cost;
            $ordermail[0]->summary=$summary;

            $settings=SF_settings::where('name','eXpress main settings')->first();

            $contact=Contact::where('sfid',$order->customerauthorizedbyid)->first();
            $user=User::where('email',$contact->email)->first();


//dd($user);

            $ordernumber=$order->ordernumber?$order->ordernumber:$order->attigo__ecom_externalid_c__c;

                $subject=str_replace('%%ordernumer%%',$ordernumber,$settings->attigo__new_order_mail_subject__c);
                $sender=['address' => $settings->attigo__transactional_email_sender__c, 'name' => $settings->attigo__store_name__c];
            



            Mail::send('emails.order-confirmation',array('user'=>$user,'orders'=>$ordermail[0],'settings'=>$settings), function ($m) use ($user,$subject,$sender) {
                    $m->from($sender['address'],$sender['name']);
                    
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject($subject);
                });
    			
    		
    			
                $this->_respondToOutBoundMsg();
    		}
    	}
    }

     /**
     * Get Sales force outbound message
     * Parse xml and upload image to cloudinary ordernumber
     * 
     * @access public
     * @param Request $request
     * @return void
     */
    public function saveImageToCloudinary(Request $request)
    {

        $content = $request->getContent();
        
        /*ob_start();
        echo "This is outbound message when product is created or updated in SF.";
        echo "\n\n";
        echo $content;
        $cont = ob_get_contents();
        ob_end_clean();*/
        
        Mail::send('emails.dev', ['msg' => $content], function ($message) {
            $message->to('karki.kuber@gmail.com')->subject('debug product added');
        });
       
        
        if($content)
        {
            $SF_xml = simplexml_load_string($content);
             
           // $notificationId = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->Id;
            $product_sfid = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->Id;

            $image = $SF_xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children('http://soap.sforce.com/2005/09/outbound')->notifications->Notification->sObject->children('urn:sobject.enterprise.soap.sforce.com')->External_product_image__c;
            
       
            
            if($product_sfid && $image)
            {

                Cloudder::upload($image);
                $pic=Cloudder::getPublicId();

                //$result=Cloudder::getResult();
               // var_dump($result);exit;

                //$img=Cloudder::show($pic);

                //print_r($img);exit;

                //echo $pic;exit;

                //save new file path into db
                $productdetails=productsdetail::where('product_sfid',$product_sfid)->first();
                if($productdetails==null)
                    $productdetails=new productsdetail();
                else{
                    Cloudder::destroyImage($productdetails->thumbnail);
                }
                $productdetails->product_sfid = $product_sfid;
                $productdetails->product_id = 0;
                $productdetails->thumbnail = $pic;
                $productdetails->save();
               
                
                $this->_respondToOutBoundMsg();
            }
        }
    }
    
    private function _respondToOutBoundMsg()
    {
    	print '<?xml version="1.0" encoding="UTF-8"?>
    				<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    				<soapenv:Body>
    				<notifications xmlns="http://soap.sforce.com/2005/09/outbound">
    				<Ack>true</Ack>
    				</notifications>
    				</soapenv:Body>
    				</soapenv:Envelope>';
    }
    
    
}
