<?php

use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CurrencyConverterController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

    Route::post('auth/access-token',[AccessTokenController::class,'store'])->middleware('guest:sanctum');
    Route::get('localLanguage',[AccessTokenController::class,'localLanguage'])->middleware('guest:sanctum');
    Route::delete('auth/access-token{token?}',[AccessTokenController::class,'destroy'])->middleware('auth:sanctum');
    Route::post('/convert', [CurrencyConverterController::class, 'convert']);
    Route::get('product',[ProductsController::class,'index'])->middleware('auth:sanctum');

    Route::get('login/google', [SocialLoginController::class, 'redirect']);
    Route::post('google_login', [SocialLoginController::class, 'google_login']);
    Route::get('login/google/callback', [SocialLoginController::class, 'callback']);

    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::post('/create-customer', [StripePaymentController::class, 'createCustomer']);
    Route::post('/charge', [StripePaymentController::class, 'charge'])->name('charge');

    Route::put('delivery/{delivery}/track', [DeliveryController::class, 'update']);
    Route::get('delivery/{id}/track', [DeliveryController::class, 'show']);
    Route::get('/get-coordinates', [DeliveryController::class, 'getCoordinates']);




});
