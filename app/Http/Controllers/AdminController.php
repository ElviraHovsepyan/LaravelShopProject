<?php

namespace App\Http\Controllers;

use App\Product;
use App\Promocode;
use App\Purchase;
use App\Storage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function admin(){
        $allUsers = User::all();
        return view('admin')->withUsers($allUsers);
    }

    public function block(Request $request){
        $id = $request->id;
        $user = User::find($id);
        $user->block = 1;
        $user->save();
    }

    public function unBlock(Request $request){
        $id = $request->id;
        $user = User::find($id);
        $user->block = 0;
        $user->save();
    }

    public function promocodes(){
        $promocodes = Promocode::all();
        return view('promocodes',['promocodes'=>$promocodes]);
    }

    public function editPromocodes(Request $request){
        $name = $request->name;
        $active = $request->active;
        $discount = $request->discount;
        $period = $request->period;

        $promocode = Promocode::where('promocode',$name)->first();
        if($promocode==null){
            $promocode = new Promocode;
        }
        $promocode->promocode = $name;
        $promocode->is_active = $active;
        $promocode->discount = $discount;
        $promocode->period_months = $period;
        $promocode->save();
        return json_encode('success');
    }

    public function storage(){
        $storage = Storage::with('Product')->get();
        return view('storage',['storage'=>$storage]);
    }

    public function setQuantity(Request $request){
        $id = $request->id;
        $quantity = $request->quantity;
        $storage = Storage::find($id);
        $storage->quantity = $quantity;
        $storage->save();
        return 'success';
    }

    public function sale(){
        return view('pieChart');
    }

    public function getBestSales(Request $request){
        $key1 = $request->key1;
        if($key1==1){
            $start = Carbon::now()->startOfMonth()->subMonth()->toDateTimeString();
        } else {
            $start = Carbon::now()->startOfMonth()->subMonths(4)->toDateTimeString();
        }
        $end = Carbon::now()->endOfMonth()->subMonth()->toDateTimeString();
        $count = [];
        for($i=1;$i<77;$i++){
            $a = 0;
            $products = Purchase::whereBetween('created_at',[$start,$end])->where('el_id',$i)->get();
            foreach($products as $product){
                $a += $product->quantity;
            }
            if($a>=5) {
                $count[$product->el_name] = $a;
            }
        }
        $arr = [];
        for($j=0; $j<5; $j++ ){
            $max_value = max($count);
            $key = array_search ($max_value, $count);
            $arr[$key]=$max_value;
            unset($count[$key]);
        }
        return json_encode($arr);
    }
}



