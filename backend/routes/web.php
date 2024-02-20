<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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
Route::delete('/category/{id}', [CategoryController::class, 'deleteById']);
Route::put('/category/{id}', [CategoryController::class, 'update']);