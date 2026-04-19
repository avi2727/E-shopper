<?php

use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\UsersController;
use App\HTTP\Controllers\LoginController;
use App\HTTP\Controllers\ProductController;
use App\Http\Controllers\UserController;

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
 Route::get('users', [UserController::class, 'index']);
 Route::post('users', [UserController::class, 'store']);
 Route::delete('users/{id}', [UserController::class, 'destroy']);
 Route::post('users/{id}', [UserController::class, 'update']);
//  login route 
Route::group(['middleware' => ['web']], function () {
    Route::post('login',[LoginController::class,'login']);
    Route::post('logout', [LoginController::class, 'logout']);
});
//signup
Route::post('signup',[LoginController::class,'signup']);
//product 
Route::post('addproduct',[ProductController::class,'addProduct']);
Route::get('product',[ProductController::class,'getdata']);
Route::delete('deleteproduct/{id}',[ProductController::class,'deletedata']);
Route::post('updateproduct/{id}',[ProductController::class,'updatedata']);
Route::get('fetch-product-details/{id}',[ProductController::class,'fetchproductdetails']);
Route::get('trendy-product',[ProductController::class,'getTrendydata']);
Route::get('just-arrived-product',[ProductController::class,'getjustarriveddata']);
Route::get('fetch-product-categorywise/{category}',[ProductController::class,'fetchProductCategoryWise']);
Route::get('product-count',[ProductController::class,'countProduct']);
Route::post('fetch-product-filter-wise',[ProductController::class,'fetchProductFilterWise']);
Route::post('add-to-cart',[ProductController::class,'addToCart']);
Route::get('fetch-cart-details/{userId}',[ProductController::class,'fetchCartDetails']);
Route::post('update-cart-details',[ProductController::class,'updateToCart']);
//Route::get('user-session',[LoginController::class,'getUserSession']);
Route::get('autosignin/{token}', [LoginController::class, 'autoSignIn']);
Route::post('insert-cart-details',[ProductController::class,'updateToCartforlogin']);
Route::post('remove-cart-details',[ProductController::class,'removeCartDetails']);
Route::post('checkoutItems-details',[ProductController::class,'checkoutFormdata']);
