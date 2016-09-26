<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricebookentry extends Model
{
    //
    public $timestamps = false;
    protected $table = 'pricebookentry';
    public function product(){
    	return $this->belongsTo('App\Product','product2id','sfid');
    }
}
