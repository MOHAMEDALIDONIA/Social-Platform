<?php

namespace App\Http\Controllers\mvc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function GetSuggestedConnections(){

        return view('users.suggestedconnections');
    }
    public function GetFriendRequests(){
        return view('users.friendrequests');
    }
}
