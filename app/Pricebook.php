<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricebook extends Model
{
    //
    public $timestamps = false;
    protected $table = 'pricebook2';
    public function pricebookentry(){
    	return $this->belongsTo('App\Pricebookentry','sfid','pricebook2id');
    }
}
