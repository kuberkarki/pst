<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class e_com_block_image__c extends Model
{
	protected $table = 'attigo__e_com_block_image__c';
  	 public $timestamps = false;

  	function block(){
  		return $this->belongsTo('App\e_com_block__c','sfid','attigo__e_com_block__c');
  	}

}
