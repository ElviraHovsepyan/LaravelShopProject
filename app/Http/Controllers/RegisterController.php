<?php

namespace App\Http\Controllers;

use App\Promocode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function show(Request $request)
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|max:10|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:20|min:4'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return view('register')->withErrors($errors);
        }
        $name = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $password = Hash::make($password);
        $user->password = $password;
        $user->save();
        $id = $user->id;
        Auth::loginUsingId($id);
        return redirect()->route('products');
    }

    public function login(Request $request){
        if(isset($request->hiddenInput)){
            $promocode = $request->hiddenInput;
            $checkPr = Promocode::where('promocode',$promocode)->first();
            if(!empty($checkPr)){
                $promocode_id = $checkPr->id;
            }
        }
        $name = $request->username;
        $check = User::where('name',$name)->first();
        if($check != null){
            $hashedPassword = $check->password;
            $userId = $check->id;
            $password = $request->password;
            if(Hash::check($password, $hashedPassword)){
                if($check->block == 1){
                    $error = 'Your account has been blocked';
                    return view('register')->withError($error);
                } else {
                    Auth::loginUsingId($userId);
                    if($check->promocode_id == '' && isset($promocode_id)){
                        $time = Carbon::now()->toDateTimeString();
                        $check->promocode_id = $promocode_id;
                        $check->start_date = $time;
                        $check->save();
                    }
                    return redirect()->route('products');
                }
            }
        } else {
            return redirect()->route('products');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('products');
    }
}






