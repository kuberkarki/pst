<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $table = 'account';
	public $timestamps = false;
    public function contact(){
        return $this->hasOne('App\Contact','accountid','sfid');
    }

    public function opportunity(){
        return $this->hasMany('App\Opportunity','accountid','sfid');
    }
}
