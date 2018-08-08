<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        $key = $request->search;

        $products = Product::where("name","LIKE","$key%")->get();

        if($products){
            foreach($products as $product){
                echo $product->name;
                echo '/';
                echo $product->id;
                echo '+';
            }
        } else {
            echo "No Results";
        }
    }
}
