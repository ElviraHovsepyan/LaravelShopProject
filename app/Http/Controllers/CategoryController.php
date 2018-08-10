<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Subcat;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id){
        $subcat = Subcat::with('Products')->find($id);
        $products = $subcat->products->take(3);
        return view('products')->withProducts($products);
    }

    public function category($id){
        $products = Product::whereHas('Subcat', function ($query) use ($id){
            $query->where('cat_id', $id);
        })->take(3)->get();
        return view('products')->withProducts($products);
    }
}




