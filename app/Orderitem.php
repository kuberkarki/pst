<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
	 protected $table = 'orderitem'; 
	public $timestamps = false;
	protected $fillable = ['sfid', 'quantity', 'listprice', 'orderid','description','unitprice','pricebookentryid','attigo__product_vat__c','attigo__product_vat_pct__c','attigo__product_discount__c'];
    public function order(){
        return $this->belongsTo('App\Order','sfid','orderid');
    }
}
