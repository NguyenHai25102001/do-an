<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Web\CartController;
use \App\Http\Controllers\Web\PayController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('variant-size', [ProductController::class, 'variantSize']);
Route::post('variant-color', [ProductController::class, 'variantColor']);
Route::post('get-children-c2', [CategoryController::class, 'getChildrenC2']);
Route::post('get-children-c3', [CategoryController::class, 'getChildrenC3']);
Route::prefix('cart')->group(function (){
    Route::get('get_cart', [CartController::class, 'getCart']);
    Route::post('add-product', [CartController::class, 'addProduct']);
    Route::post('delete', [CartController::class, 'delete']);
    Route::post('change-quantity', [CartController::class, 'changeQuantity']);
});
Route::post('get_review_product', [\App\Http\Controllers\Web\ProductController::class, 'getReviewProduct']);
Route::get('get-pay', [PayController::class, 'getPay']);
Route::post('fee_ship_order', [PayController::class, 'feeShip']);
