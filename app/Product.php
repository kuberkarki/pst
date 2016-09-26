<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product2';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $fillable = ['attigo__external_product_image__c'];
    /**
    * To allow soft deletes
    */
    //use SoftDeletes;

    //protected $dates = ['deleted_at'];

    public function price(){
        return $this->hasMany('App\Pricebookentry','product2id','sfid');
    }

    public function pricewithstandard(){
        return $this->hasMany('App\Pricebookentry','product2id','sfid')->where('usestandardprice','1');
    }

    public function productsdetails(){
        return $this->hasOne('App\productsdetail','product_sfid','sfid');
    }

    /*public function category()
    {
        return $this->belongsTo('App\Category','id','category_id');
    }

    public function Product_category()
    {
        return $this->belongsTo('App\Product_category');
    }*/
}