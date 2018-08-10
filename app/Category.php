<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function Subcat(){

        return $this->hasMany('App\Subcat','cat_id','id')->select(['id','subcat_name','cat_id']);
    }
}


