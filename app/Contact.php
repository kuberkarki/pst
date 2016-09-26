<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $table = 'contact';
	public $timestamps = false;
    public function account(){
        return $this->hasOne('App\Account','sfid','accountid');
    }
}
