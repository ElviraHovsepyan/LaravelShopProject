<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcat extends Model
{
    //
    protected $table = 'subcat';

    public function Products(){
        return $this->belongsToMany('App\Product','subcat_product','subcat_id','product_id')->select(['products.id','products.name','products.price','products.pic']);
    }

    public function Category(){
        return $this->belongsTo('App\Category','cat_id');
    }

}
