<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {

    //Categories
    Route::group(['prefix' => 'category'], function () {
        Route::get('', [CategoryController::class, 'index']); //Retrieved all categories
        Route::get('find/{id}', [CategoryController::class, 'show']); //Retrieved specific categories
        Route::post('store', [CategoryController::class, 'store']); //Create New Category
        Route::put('{id}', [CategoryController::class, 'update']); //Update Specific Category
        Route::delete('{id}', [CategoryController::class, 'destroy']); //Update Specific Category
    });

    //Products
    Route::group(['prefix' => 'product'], function () {
        Route::get('', [ProductController::class, 'index']); //Retrieved all Products
        Route::get('find/{id}', [ProductController::class, 'show']); //Retrieved specific Product
        Route::post('store', [ProductController::class, 'store']); //Create New Product
        Route::put('{id}', [ProductController::class, 'update']); //Update Specific Product
        Route::delete('{id}', [ProductController::class, 'destroy']); //Delete Specific Product
    });

    //orders
    Route::group(['prefix' => 'order'], function () {
        Route::get('', [OrderController::class, 'index']); //Retrieved all Products
        Route::get('find/{id}', [OrderController::class, 'show']); //Retrieved specific Product
        Route::post('store', [OrderController::class, 'store']); //Create New Product
        // Route::put('{id}', [ProductController::class, 'update']); //Update Specific Product
        // Route::delete('{id}', [ProductController::class, 'destroy']); //Delete Specific Product
    });   



});
