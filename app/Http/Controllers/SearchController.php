<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $key = $request->search;
        $products = Product::where("name","LIKE","%$key%")->take(10)->get();
        if($products){
            return json_encode($products);
        }
    }
    public function searchAll(Request $request){
        $key = $request->searchName;
        if($key){
            $products = Product::where("name","LIKE","%$key%")->take(3)->get();
            if(!empty($products)){
                return view('products',['products'=>$products,'key'=>$key]);
            }
        } else{
            return view('products');
        }
    }
}





