<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    public function product()
    {
        return $this->hasMany('App\Product');
    }

    public function category()
    {
        return $this->hasMany('App\Category');
    }
}
