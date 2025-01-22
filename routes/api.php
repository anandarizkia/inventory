<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::prefix('v1')->group(function () {

    Route::resource('category', CategoryController::class);

    Route::resource('product', ProductController::class);

    Route::resource('supplier', SupplierController::class);

    Route::resource('transaction', TransactionController::class);

    Route::get('/test', function () {
        return view('welcome');
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('users', [UserController::class, 'index']); 
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('usersupdate/{id}', [UserController::class, 'update']);
Route::post('addnew', [UserController::class, 'store']);
Route::delete('usersdelete/{id}', [UserController::class, 'destroy']);
