<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $table = 'contract';
	public $timestamps = false;

	public function pricebook(){
		return $this->hasMany('App\Pricebook','sfid','pricebook2id')->where('attigo__pricebook_for_e_commerce__c','true');
	}
    
}
