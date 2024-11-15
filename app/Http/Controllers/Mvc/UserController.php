<?php

namespace App\Http\Controllers\mvc;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function GetSuggestedConnections(){
      $SuggestedConnections  = User::whereNot('id',auth()->user()->id)->get();
        return view('users.suggestedconnections' ,compact('SuggestedConnections'));
    }
    public function GetFriendRequests(){

        return view('users.friendrequests');
    }
}
