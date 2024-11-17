<?php

namespace App\Http\Controllers\Mvc;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view(){
         $today = Carbon::now()->format('Y-m-d');
         $posts = Post::latest()->get();
        return view('welcome',compact('posts'));
    }
}
