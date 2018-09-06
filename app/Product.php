<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
 use SoftDeletes;
 protected $dates = ['deleted_at'];
 protected $fillable = ['name','info','pic','price'];


 public function Subcat(){
     return $this->belongsToMany('App\Subcat', 'subcat_product','product_id','subcat_id');
 }

 public static function getCategoryProducts($id, $num){
     return Product::with('Storage')->whereHas('Subcat', function ($query) use ($id){
         $query->where('cat_id', $id);
     })->take(3)->offset($num)->get();
 }

 public function Storage(){
     return $this->hasOne('App\Storage');
 }

}


