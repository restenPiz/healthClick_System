<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/pharmacies', [PharmacyController::class, 'index']);
Route::get('/categories', [ApiController::class, 'category']);
//*Payment Route
Route::post('/payment', [ApiController::class, 'payment']);
