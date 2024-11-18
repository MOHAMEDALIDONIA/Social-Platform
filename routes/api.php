<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Middleware\CheckUserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::delete('/logout', [AuthController::class, 'logout']);
       //------- Start Home Page ------- //
          Route::get('/', [HomeController::class,'view']);
       //------- End Home Page ------- //
     //------- Start User actions ------- //
 Route::prefix('/Users')->controller(UserController::class)->group(function(){
    Route::get('/SuggestedConnections','GetSuggestedConnections');
    Route::get('/friend-requests','GetFriendRequests');
    Route::post('/send-friend-request','SendFriendRequest');
    Route::post('/accept-friend-request','AcceptFriendRequest');
    Route::delete('/reject-friend-request','RejectFriendRequest');
 });
//------- End User actions ------- //
//------- Start User Profile ------- //
Route::get('profile/edit/{id}',[ProfileController::class,'edit']);
Route::post('changepassword',[ProfileController::class,'ChangePassword']);
Route::apiResource('profiles',ProfileController::class);
//------- End User Profile ------- //

//------- Start Post ------- //
Route::get('post/edit/{id}',[PostController::class,'edit']);
Route::delete('post-image/delete/{id}',[PostController::class,'destoryPostImage']);
Route::post('/post-comment/{id}',[PostController::class,'CreateComment']);
Route::post('/post-like/{id}',[PostController::class,'likePost']);
Route::get('/post-users-likes/{id}',[PostController::class,'PostLikes']);
Route::apiResource('posts',PostController::class);
//------- End Post ------- //
});


Route::middleware(['CheckUserAuthenticated'])->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

    



