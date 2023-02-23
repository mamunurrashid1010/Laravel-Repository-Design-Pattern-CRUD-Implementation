<?php

use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

// Category
Route::group(['prefix'=>'category'],function (){
    Route::get('index',[CategoryController::class,'index'])->name('category.index');
    Route::get('create',[CategoryController::class,'create'])->name('category.create');
    Route::post('store',[CategoryController::class,'store'])->name('category.store');
    Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
    Route::post('update',[CategoryController::class,'update'])->name('category.update');
    Route::get('show/{id}',[CategoryController::class,'show'])->name('category.show');
    Route::post('delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
});
