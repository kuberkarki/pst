<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'product', 'amount', 'transaction_id','shipping_address'];
}
