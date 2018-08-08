<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    //
    public function token(){

        if(Auth::user()->token){
            echo Auth::user()->token;
        } else {
            $random = str_random(20);
            echo $random;
            Auth::user()->token = $random;
            Auth::user()->save();
        }
    }

    public function getProducts(Request $request){
        $response = [];
        $token = $request->header('token');
        $check = User::where('token',$token)->first();
        if($check){
            $products = Product::all();
            $response = [
                'products' => $products,
                'success' => true
            ];
        } else {
            $response = [
                'message' => 'Token is required',
                'success' => false
            ];
        }
        return json_encode($response);
    }


    public function getProduct(Request $request, $id){
        $responce = [];

        $token = $request->header('token');
        $check = User::where('token',$token)->first();

        if(!$check){
            $response = [
                'message' => 'Correct Token is required',
                'success' => false
            ];
        } else if(!$id){                     ////// ?????????????
            $response = [
                'message' => 'Product id is required',
                'success' => false
            ];
        } else {
            $product = Product::find($id);
            $response = [
                'product' => $product,
                'success' => true
            ];
        }
        return json_encode($response);
    }


    public function addProduct(Request $request){

        $responce = [];
        $token = $request->header('token');
        $check = User::where('token',$token)->first();
        if(!$check){
            $response = [
                'message' => 'Correct Token is required',
                'success' => false
            ];
        } else {
            $rules = [
                'name'=>'required|max:16',
                'price'=>'required|max:14',
                'info'=>'required|max:200',
                'pic'=>'image'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors();

                $response = [
                    'message' => $errors,
                    'success' => false
                ];

            } else {
                $name = $request->input('name');
                $info = $request->input('info');
                $price = $request->input('price');
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

                $response = [
                    'success' => true
                ];
            }
        }

        return json_encode($response);
    }



    public function editProduct(Request $request, $id){

        $responce = [];
        $token = $request->header('token');
        $check = User::where('token',$token)->first();
        if(!$check){
            $response = [
                'message' => 'Correct Token is required',
                'success' => false
            ];
        } else if(!$id){

            $response = [
                'message' => 'Product id is required',
                'success' => false
            ];
        }
        else {

            $rules = [
                'name'=>'required|max:16',
                'price'=>'required|max:14',
                'info'=>'required|max:200',
                'pic'=>'image|size:500'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors();

                $response = [
                    'message' => $errors,
                    'success' => false
                ];

            } else {

                $name = $request->input('name');
                $info = $request->input('info');
                $price = $request->input('price');

                if(!empty($request->file('pic'))){
                    $pic = $request->file('pic');
                    $pic->move('themes/images/prPics', $pic->getClientOriginalName());
                    $pic =  $pic->getClientOriginalName();
                    $pic = explode('.',$pic);
                    $pic = $pic[0];
                } else {
                    $pic = Product::find($id)->pic;
                }


                $pic->move('themes/images/prPics', $pic->getClientOriginalName());
                $pic =  $pic->getClientOriginalName();
                $pic = explode('.',$pic);
                $pic = $pic[0];
                $product = Product::find($id);
                if(!$product){

                }
                $product->name = $name;
                $product->info = $info;
                $product->price = $price;
                $product->pic = $pic;
                $product->save();

                $response = [
                    'success' => true
                ];
            }
        }
        return json_encode($response);
    }

    public function deleteProduct(Request $request, $id){

        $responce = [];

        $token = $request->header('token');
        $check = User::where('token',$token)->first();

        if(!$check){
            $response = [
                'message' => 'Correct Token is required',
                'success' => false
            ];
        } else if(!$id){
            $response = [
                'message' => 'Product id is required',
                'success' => false
            ];
        } else {
            $product = Product::find($id);
            $product->delete();
            $response = [
                'success' => true
            ];
        }
        return json_encode($response);

    }
}


