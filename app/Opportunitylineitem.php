<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunitylineitem extends Model
{
	 protected $table = 'opportunitylineitem'; 
	public $timestamps = false;
	protected $fillable = ['unitprice', 'productcode', 'product2id', 'pricebookentryid','totalprice','name','quantity','sfid','opportunityid','createddate'];
    public function opportunity(){
        return $this->belongsTo('App\Opportunity','sfid','opportunityid');
    }
}
