<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productsdetail extends Model
{
    //
    public function product(){
        return $this->hasOne('App\Product','sfid','product_sfid');
    }
}
