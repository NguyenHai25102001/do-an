<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Web\NewsController;
use \App\Http\Controllers\Web\HomeController;
use \App\Http\Controllers\Web\ProductController;
use \App\Http\Controllers\Web\CartController;
use \App\Http\Controllers\Controller;
use \App\Http\Controllers\Web\PayController;

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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('danh-muc/{status}',[ProductController::class, 'category']);
Route::get('danh-muc/{status}/{name}',[ProductController::class, 'productCate']);
Route::get('danh-muc/{status}/{name}/{slug}',[ProductController::class, 'productCateDetail']);
Route::post('bo-loc', [ProductController::class,'filter'])->name('filter');
Route::get('tim-kiem', [ProductController::class,'search'])->name('search');
Route::get('san-pham/{slug}',[ProductController::class, 'detailProduct'])->name('detailProduct');
Route::post('danh-gia', [ProductController::class,'storeReview'])->name('review');
Route::get('thanh-toan',[PayController::class,'pay'])->name('pay');
Route::post('tao-don', [PayController::class, 'createOrderUser'])->name('create-order');
Route::get('thanh-toan/thanh-cong',[PayController::class,'successOrderVnPay'])->name('pay');
Route::get('tra-cuu-don-hang', [HomeController::class,'checkOrder'])->name('check-order');
Route::post('chi-tiet-don-hang', [HomeController::class,'detailOrder'])->name('detail-order');
Route::get('tin-tuc/{status}', [NewsController::class, 'news']);
Route::get('chi-tiet-tin-tuc/{slug}', [NewsController::class, 'detailNew']);
Route::get('gioi-thieu/{slug}', [NewsController::class, 'introduce'])->name('introduce');
Route::get('get_district/{province_id}', [Controller::class,'getDistrict']);
Route::get('get_ward/{district_id}', [Controller::class,'getWard']);
