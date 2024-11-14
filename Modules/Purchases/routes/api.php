<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Purchases\App\Http\Controllers\PurchasesController;
/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::prefix('v1')->name('api.')->group(function () {
    Route::get('purchases/contact_search',[PurchasesController::class,'contact_search'])->name('purchases.contact_search');
    Route::get('purchases/product_search',[PurchasesController::class,'product_search'])->name('purchases.product_search');
});
