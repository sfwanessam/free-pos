<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\App\Http\Controllers\CategoryController;
use Modules\Catalog\App\Http\Controllers\ProductController;

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

Route::group(['prefix'=>'catalog','as'=>'catalog.'], function(){
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
});