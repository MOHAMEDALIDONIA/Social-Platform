<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\traits\savephoto;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test',[App\Http\Controllers\TestController::class,'test']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
 //------- Start User Profile ------- //
 Route::prefix('/profile')->controller(App\Http\Controllers\Mvc\ProfileController::class)->group(function(){
    Route::get('/{id}','index')->name('profile.view');
    Route::get('edit/{id}','edit')->name('profile.edit');
    Route::put('update/{id}','update')->name('profile.update');
    Route::post('changepassword','ChangePassword')->name('change.password');
 });
//------- End User Profile ------- //
 

 
});

require __DIR__.'/auth.php';
