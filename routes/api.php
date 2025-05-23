<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
//*Fetch products using a category_id
Route::get('/products/category/{id}', [ApiController::class, 'ProductCategory']);
Route::get('/categories', [ApiController::class, 'category']);
//*Pharmacy Route
Route::get('/pharmacies', [PharmacyController::class, 'index']);
//*Payment Route
Route::post('/payment', [ApiController::class, 'payment']);
//*Sales Route
Route::get('/sales/{id}', [ApiController::class, 'sale']);
//*Delivery Route
Route::post('/deliveries', [ApiController::class, 'delivery']);
//*Delivery Route - Get the sales
Route::get('/delivery/{sale_id}', [ApiController::class, 'getDeliveryBySale']);
//*Auth
Route::post('/sync-firebase-uid', [ApiController::class, 'syncFirebaseUid']);

//*Stripe payment
Route::post('/stripe/create-checkout-session', [StripeController::class, 'createCheckoutSession']);
Route::post('/stripe/confirm-payment', [StripeController::class, 'confirmPayment']);

Route::get('/user-by-firebase/{uid}', function ($uid) {
    $user = User::where('firebase_uid', $uid)->first();

    if ($user) {
        return response()->json(['user_id' => $user->id]);
    }

    return response()->json(['message' => 'User not found'], 404);
});
