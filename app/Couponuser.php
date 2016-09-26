<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Couponuser extends Model
{
    //
   public function used($userid,$couponid){
    	return $this::where('userid',$userid)->where('couponid',$couponid)->get()->count();
    }
}
