<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/category', [CategoryController::class, 'create']);
Route::get('/category/{id}', [CategoryController::class, 'getItemById']);
Route::get('/category', [CategoryController::class, 'getAllItems']);
Route::delete('/category/{id}', [CategoryController::class, 'delete']);
Route::put('/category/{id}', [CategoryController::class, 'update']);

Route::post('/product', [ProductController::class, 'create']);
Route::get('/product/{id}', [ProductController::class, 'getItemById']);
Route::get('/product', [ProductController::class, 'getAllItems']);
Route::delete('/product/{id}', [ProductController::class, 'delete']);
Route::put('/product/{id}', [ProductController::class, 'update']);

Route::get('/stock', [StockController::class, 'getStock']);

Route::post('/user', [UserController::class, 'create']);

Route::get('images/{imageName}', [ImageController::class, 'show']);