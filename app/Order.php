<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Redirect;

class Order extends Model
{
	protected $table = 'order';
  	 public $timestamps = false;

  	 protected $fillable = ['contractid', 'shippingcountry', 'shippinglatitude', 'statuscode','status','shippinglongitude','sfid','shippingstate','pricebook2id','shippingcity','shippingstreet','totalamount','shippingpostalcode','accountid','name','effectivedate','customerauthorizedbyid','attigo__e_commerce_order__c','attigo__ecommerce_order_contact__c','billingcountry', 'billinglatitude','billinglongitude','billingstate','billingcity','billingstreet','billingpostalcode','attigo__temporary_shipping_adress__c','attigo__vat__c','attigo__ecom_externalid_c__c','ordernumber','attigo__e_com_order_process_status__c','attigo__e_com_shipment__c','attigo__e_com_payment_type__c','attigo__e_com_order_method__c'];
    public function account(){
        return $this->belongsTo('App\Account','sfid','accountid');
    }

    public function orderitem(){
        return $this->hasMany('App\Orderitem','orderid','sfid');
    }
    public static function listbyemail($email,$orderid=null){
        //echo $orderid;exit;
    	$contact=Contact::where('email',$email)->first();
        //$account=Account::where('sfid',$contact->accountid)->first();
        if(!$contact){
            // Log the user out
        Sentinel::logout();

        // Redirect to the users page
        return Redirect::to('login')->with('error', 'No Account Found!');
        }

        if($orderid){
            return Order::where('accountid',$contact->accountid)->where('attigo__e_commerce_order__c',true)
            ->where('id',$orderid)
            ->with('orderitem')->get();
        }

    	return Order::where('accountid',$contact->accountid)->where('attigo__e_commerce_order__c',true)->with('orderitem')
       // ->orderby('id','DESC')
        ->get();
        
    }
}
