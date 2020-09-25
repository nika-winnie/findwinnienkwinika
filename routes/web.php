<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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
//Route::group(['middleware'=>['frontlogin']],function(){
    // Users Account Page
    Route::match(['get','post'],'account',[UsersController::class, 'account']);

    // Users Login/Register Page
    Route::get('/login-register',[UsersController::class, 'userLoginRegister']);

    // Users Register Form Submit
    Route::post('/user-register',[UsersController::class, 'register']);
    // Admin Users Route
    Route::get('/admin/view-users',[UsersController::class, 'viewUsers']);
//});
    // Check User Current Password
//Route::get('/admin', 'AdminController@login');
Route::match(['get','post'], '/admin', [AdminController::class, 'login']);
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/settings', [AdminController::class, 'settings']);
    Route::get('/admin/check-pwd',[AdminController::class, 'chkPassword']);
    Route::match(['get', 'post'],'/admin/update-pwd',[AdminController::class, 'updatePassword']);

    // Admin Categories Routes
    Route::match(['get', 'post'], '/admin/add-category',[CategoryController::class,'addCategory']);
    Route::match(['get', 'post'], '/admin/edit-category/{id}',[CategoryController::class,'editCategory']);
    Route::match(['get', 'post'], '/admin/delete-category/{id}',[CategoryController::class,'deleteCategory']);
    Route::get('/admin/view-categories',[CategoryController::class,'viewCategories']);

    // Admin Products Routes
    Route::match(['get','post'],'/admin/add-product',[ProductsController::class,'addProduct']);
    Route::match(['get','post'],'/admin/edit-product/{id}',[ProductsController::class,'editProduct']);
    Route::get('/admin/delete-product/{id}',[ProductsController::class,'deleteProduct']);
    Route::get('/admin/view-products',[ProductsController::class,'viewProducts']);
    Route::get('/admin/delete-product-image/{id}',[ProductsController::class,'deleteProductImage']);

    Route::match(['get', 'post'], '/admin/add-images/{id}',[ProductsController::class,'addImages']);
    Route::get('/admin/delete-alt-image/{id}',[ProductsController::class,'deleteProductAltImage']);
});

Route::get('/logout', [AdminController::class, 'logout']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
