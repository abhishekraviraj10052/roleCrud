<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::view('/', 'auth.login')->name('view-login-form');
   
Route::post('login',[UserController::class,'login'])->name('login');

Route::group(['prefix'=>'user'],function(){
    Route::get('dashboard',[UserController::class,'dashboard'])->name('dashboard');
    Route::get('manage/{id?}',[UserController::class,'show_user_form'])->name('user-create');
    Route::get('delete/{id?}',[UserController::class,'delete'])->name('user-delete');
    Route::get('search',[UserController::class,'search_sort'])->name('user-search');
    Route::get('logout',[UserController::class,'logout'])->name('user-logout');
    Route::post('insert',[UserController::class,'insert'])->name('user-insert');
    Route::post('update',[UserController::class,'update'])->name('user-update');

});




