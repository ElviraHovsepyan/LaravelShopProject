<?php

namespace App\Http\Controllers;

use App\Subcat;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id){

        $subcat = Subcat::with('Products')->find($id);
        $products = $subcat->products;

        return view('categories')->withProducts($products);
    }

}
