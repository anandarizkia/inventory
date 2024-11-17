<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TransactionController;

Route::prefix('v1')->group(function () {

    Route::resource('category', CategoryController::class);

    Route::resource('product', ProductController::class);

    Route::resource('supplier', SupplierController::class);

    Route::resource('transaction', TransactionController::class);

    Route::get('/test', function () {
        return view('welcome');
    });
});
