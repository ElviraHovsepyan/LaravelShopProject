<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SubscribeController extends Controller
{
    public function subscribe(Request $request){
        $email = $request->email;
        $rules = [
            'email' => 'required|email|unique:subscribers,email',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return json_encode($errors->all());
        } else {
            $subscriber = new Subscriber;
            $subscriber->user_id = Auth::user()->id;
            $subscriber->email = $email;
            $subscriber->save();
            return json_encode('You have subscribed to news');
        }
    }

}
