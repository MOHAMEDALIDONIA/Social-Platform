<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\traits\savephoto;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use savephoto;
    public function test(){
      $users= User::all();
       foreach($users as $user){
          $user->update([
            'image'=>'users\uploads\userprofile.jpg	'
          ]);
       }
        // $post = Post::findOrFail($post_id);
        //   $usersLiked =  $post->likes()->select('id','user_id')->with(['user'=>function($q){
        //      $q->select('id','name','image');
        //   }]);
        //  return $usersLiked->get()->pluck('user');               
    }
}
