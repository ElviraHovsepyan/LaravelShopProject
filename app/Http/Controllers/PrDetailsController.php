<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcat;
use App\Product;

use Illuminate\Http\Request;

class PrDetailsController extends Controller
{

    public function show($id){

        $pr = Product::find($id);
        if($pr != null){
            return view('productDetails')->withPr($pr);
//                ->withCats($cats);
        } else {
            abort(404);
        }

    }

    public function deleteItem($prId){
        $item = Product::find($prId);
        $item->delete();
//        Product::onlyTrashed()->restore();
        return redirect('/');

    }


}
