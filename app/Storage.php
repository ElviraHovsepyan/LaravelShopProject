<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    public $timestamps = false;

    public function Product(){
        return $this->belongsTo('App\Product','product_id');
    }
}
