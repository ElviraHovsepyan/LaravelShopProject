<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcat;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductsController extends Controller
{
    public function show($scroll = false){
        $number = 6;
        if($scroll){
            $number = $number + (3 * $scroll);
        }
        $products = Product::take($number)->get();
        return view('products',['products'=>$products]);
    }

    public function scroll(Request $request){
        $num = $request->number;
        $page = $request->page;
        $id = $request->id;
        if($request->key){
            $key = $request->key;
        }
        if($page=='category'){
            $products = Product::getCategoryProducts($id, $num);
        } else if($page=='subCategory'){
            $products = Product::whereHas('Subcat',function ($query) use ($id){
                $query->where('subcat.id', $id);
            })->take(3)->offset($num)->get();
        } else if($page=='searchAll') {
            $products = Product::where("name","LIKE","%$key%")->take(3)->offset($num)->get();
        } else {
            $products = Product::take(3)->offset($num)->get();
        }
        $products = json_encode($products);
        return $products;
    }

    public function showAdd(){
        return view('addNewItem');
    }

    public function addNew(Request $request){
        $rules = [
            'name'=>'required|max:30',
            'price'=>'required|max:10',
            'info'=>'required|max:200',
            'pic'=>'image'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('addNewItem')->withErrors($errors);
        }
        $all = $request->all();
        $name = $all['name'];
        $price = $all['price'];
        $info = $all['info'];
        $pic = $request->file('pic');
        $pic->move('themes/images/prPics', $pic->getClientOriginalName());
        $pic =  $pic->getClientOriginalName();
        $pic = explode('.',$pic);
        $pic = $pic[0];
        $product = new Product;
        $product->name = $name;
        $product->info = $info;
        $product->price = $price;
        $product->pic = $pic;
        $product->save();
        return json_encode('success');
    }

    public function updateView($uId){
        $arr = Product::find($uId);
        $name = $arr->name;
        $info = $arr->info;
        $price = $arr->price;
        return view('updateView',['name'=>$name,'info'=>$info,'price'=>$price,'id'=>$uId]);
    }

    public function update(Request $request, $id){
        $rules = [
            'name'=>'required|max:30',
            'price'=>'required|max:10',
            'info'=>'required|max:200',
            'pic'=>'image'
        ];
        $validator = Validator::make($request->all(), $rules);
        $arr = Product::find($id);
        $name = $arr->name;
        $info = $arr->info;
        $price = $arr->price;
        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('updateView',['name'=>$name,'info'=>$info,'price'=>$price,'id'=>$id])->withErrors($errors);
        }
        $all = $request->all();
        $name = $all['name'];
        $price = $all['price'];
        $info = $all['info'];
        $pic = $request->file('pic');
        if(!empty($request->file('pic'))){
            $pic = $request->file('pic');
            $pic->move('themes/images/prPics', $pic->getClientOriginalName());
            $pic =  $pic->getClientOriginalName();
            $pic = explode('.',$pic);
            $pic = $pic[0];
        } else {
            $pic = Product::find($id)->pic;
        }
        $product = Product::find($id);
        $product->name = $name;
        $product->info = $info;
        $product->price = $price;
        $product->pic = $pic;
        $product->save();
        return json_encode('success');
        }
    }



