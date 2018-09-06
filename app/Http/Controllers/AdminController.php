<?php

namespace App\Http\Controllers;

use App\Promocode;
use App\Storage;
use App\User;
use Illuminate\Http\Request;

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
}



