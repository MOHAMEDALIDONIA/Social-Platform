<?php

namespace App\Http\Controllers\Mvc;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view(){
       
         $posts = Post::with(['user','comments','likes','images'])->latest()->paginate(10);
        return view('welcome',compact('posts'));
    }
}
