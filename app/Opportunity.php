<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
	protected $table = 'opportunity';
  	 public $timestamps = false;

  	 protected $fillable = ['iswon', 'stagename', 'probability', 'name','accountid','sfid','amount','closedate','isdeleted','createddate'];
    public function account(){
        return $this->belongsTo('App\Account','sfid','accountid');
    }

    public function opportunitylineitem(){
        return $this->hasMany('App\Opportunitylineitem','opportunityid','sfid');
    }
}
