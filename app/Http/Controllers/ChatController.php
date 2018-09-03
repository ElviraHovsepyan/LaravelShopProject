<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request){
       $userId =  $request->userId;
       if($userId==1){
           $messages = Message::with('User')->get();
       } else {
           $messages = Message::where('user_id',$userId)->orWhere('sender_id',$userId)->get();
       }
       return json_encode($messages);
    }

    public function getUser(Request $request){
        $id = $request->id;
        $user = User::find($id);
        return json_encode($user);
    }
}
