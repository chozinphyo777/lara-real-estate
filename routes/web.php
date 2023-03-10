<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[PostController::class,'create']);

Route::get('post/create',[PostController::class,'create'])->name('post_create');

Route::post('post/store',[PostController::class,'store'])->name('post_store');

// Route::get('post/delete/{id}',[PostController::class,'delete'])->name('post_delete');
Route::delete('post/delete/{id}',[PostController::class,'delete'])->name('post_delete');

Route::get('post/detail/{id}',[PostController::class,'detail'])->name('post_detail');

Route::get('post/edit/{id}',[PostController::class,'edit'])->name('post_edit');

Route::post('post/update',[PostController::class,'update'])->name('post_update');