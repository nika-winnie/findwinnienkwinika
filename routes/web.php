<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

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
});

Route::get('/logout', [AdminController::class, 'logout']);

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
