<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    

    protected $dates = ['deleted_at'];

    protected $table = 'categories';

    protected $guarded = ['id']; 

    // public function product()
    // {
    //     return $this->hasMany('App\Product','id','family');
    // }
    // 
     public function product()
    {
    	$products=Product_category::where('category_id',$this->id)->get();
    	return $products;
        //return $this->belongsTo('App\Product_category','product_id','id');
    }
}
