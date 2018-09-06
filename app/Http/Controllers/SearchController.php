<?php

namespace App\Http\Controllers;

use App\Http\Services\Service;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $discount = Service::getDiscount();
        $key = $request->search;
        $products = Product::where("name","LIKE","%$key%")->take(10)->get();
        if($products){
            foreach($products as $product){
                $product->price = ($product->price)-($product->price)*$discount;
            }
            return json_encode($products);
        }
    }
    public function searchAll(Request $request){
        $discount = Service::getDiscount();
        $key = $request->searchName;
        if($key){
            $products = Product::where("name","LIKE","%$key%")->take(3)->get();
            if(!empty($products)){
                return view('products',['products'=>$products,'key'=>$key,'discount'=>$discount]);
            }
        } else{
            return view('products');
        }
    }
}





