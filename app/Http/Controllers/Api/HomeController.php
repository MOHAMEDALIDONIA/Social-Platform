<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\traits\apiTraits;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use apiTraits;
    public function view(){
        $posts = Post::with(['user','comments','likes','images'])->latest()->paginate(10);
        return $this->ReturnData('data',$posts,'Show Home Page');
    }
}
