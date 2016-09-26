<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class e_com_block__c extends Model
{
	protected $table = 'attigo__e_com_block__c';
  	 public $timestamps = false;

  	 public function images(){
  	 	$dt=date('Y-m-d H:i:s');
        return $this->hasMany('App\e_com_block_image__c','attigo__e_com_block__c','sfid')
        ->where('attigo__image_enabled__c',true)
        ->where(function($query) use ($dt){
              $query->where('attigo__image_active_from__c','<=',$dt)
             ->orwhereNull('attigo__image_active_from__c');
            
             })
         ->where(function($query) use ($dt){
              $query->where('attigo__image_active_to__c','>=',$dt)
             ->orwhereNull('attigo__image_active_to__c');
            
             })
        //->where('image_active_from__c','<=',$dt)
        //->where('image_active_to__c','>=',$dt)
        ->orderBy('attigo__image_order__c');
    }

}
