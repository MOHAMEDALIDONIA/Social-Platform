<?php

namespace App\Http\Controllers\Mvc;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view(){
       
         $posts = Post::with(['user','comments','likes','images'])->latest()->paginate(10);
        return view('welcome',compact('posts'));
    }
    public function search(Request $request){
        if ($request->search) {
            $searchUsers = User::search($request)->where('id','!=',auth('web')->user()->id)->paginate(20);
                                return view('users.search',compact('searchUsers'));
        } else {
            return redirect()->back()->with(['message'=>'something error !']);
        }
        

    }
}
