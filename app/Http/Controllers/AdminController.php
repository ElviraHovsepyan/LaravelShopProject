<?php

namespace App\Http\Controllers;

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
}



