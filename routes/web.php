<?php

use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Route;
use App\traits\savephoto;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/test',function ()  {
   $post =Post::with('images')->where('id',71)->first();
   return $post->images->image ; 
   $postimages = PostImage::where('post_id',$post->id)->get();
   foreach($postimages as $image){
        echo $image->image;
   }
  
   // if (File::exists(public_path('storage/users/uploads/post/1731962845images (2).jpeg'))) {
   //    File::delete(public_path('storage/users/uploads/post/1731962845images (2).jpeg'));
   // }
   return 'success';
});


Route::middleware('auth')->group(function () {
      //------- Start Home Page ------- //
      Route::get('/', [App\Http\Controllers\Mvc\HomeController::class,'view'])->name('home.page');
      Route::get('/search', [App\Http\Controllers\Mvc\HomeController::class,'search'])->name('searh.users');
   //------- End Home Page ------- //
   //------- Start User Profile ------- //
   Route::prefix('/profile')->controller(App\Http\Controllers\Mvc\ProfileController::class)->group(function(){
      Route::get('/{id}','index')->name('profile.view');
      Route::get('edit/{id}','edit')->name('profile.edit');
      Route::put('update/{id}','update')->name('profile.update');
      Route::post('changepassword','ChangePassword')->name('change.password');
   });
   //------- End User Profile ------- //

   //------- Start User actions ------- //
   Route::prefix('/Users')->controller(App\Http\Controllers\Mvc\UserController::class)->group(function(){
      Route::get('/SuggestedConnections','GetSuggestedConnections')->name('suggest.connections');
      Route::get('/friend-requests','GetFriendRequests')->name('friend.requests');
      Route::post('/send-friend-request','SendFriendRequest')->name('send.friend.request');
      Route::post('/accept-friend-request','AcceptFriendRequest')->name('accept.friend.request');
      Route::delete('/reject-friend-request','RejectFriendRequest')->name('reject.friend.request');
   });
   //------- End User actions ------- //
   
   //------- Start Posts ------- //
   Route::prefix('/Posts')->controller(App\Http\Controllers\Mvc\PostController::class)->group(function(){
      Route::Post('/store','store')->name('store.post');
      Route::get('edit/{id}','edit')->name('post.edit');
      Route::put('update/{id}','update')->name('post.update');
      Route::get('/destory/{id}','destory')->name('delete.post');
      Route::get('post-image/delete/{id}','destoryPostImage')->name('delete.post.image');
      Route::post('/post-comment/{id}','CreateComment')->name('post.comment');
      Route::post('/post-like/{id}','likePost')->name('user.like.post');
      Route::get('/post-users-likes/{id}','PostLikes')->name('post.likes');

   });
   //------- End posts ------- //
 
});

require __DIR__.'/auth.php';
