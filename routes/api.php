<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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
     //------- Start User actions ------- //
 Route::prefix('/Users')->controller(UserController::class)->group(function(){
    Route::get('/SuggestedConnections','GetSuggestedConnections');
    Route::get('/friend-requests','GetFriendRequests');
    Route::post('/send-friend-request','SendFriendRequest');
    Route::post('/accept-friend-request','AcceptFriendRequest');
    Route::delete('/reject-friend-request','RejectFriendRequest');
 });
//------- End User actions ------- //
});


Route::middleware(['CheckUserAuthenticated'])->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

    



