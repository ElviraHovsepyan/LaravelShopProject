<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Subcat;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id,$scroll = false){
        $number = 6;
        if($scroll){
            $number = $number + (3 * $scroll);
        }
        $subcat = Subcat::with('Products')->find($id);
        $products = $subcat->products->take($number);
        return view('products')->withProducts($products);
    }

    public function category($id,$scroll = false){
        $number = 6;
        if($scroll){
            $number = $number + (3 * $scroll);
        }
        $products = Product::whereHas('Subcat', function ($query) use ($id){
            $query->where('cat_id', $id);
        })->take($number)->get();
        return view('products')->withProducts($products);
    }
}

