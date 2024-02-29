<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

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

// AUTH ROUTES
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/refresh-token', [UserAuthController::class, 'refreshToken']);
Route::middleware('auth:sanctum')->post('logout', [UserAuthController::class, 'logout']);

// PRODUCT TYPES ROUTES 
Route::middleware('auth:sanctum')->get('product-types', [ProductTypeController::class, 'getAll']);
Route::middleware('auth:sanctum')->post('product-types', [ProductTypeController::class, 'create']);
Route::middleware('auth:sanctum')->put('product-types/{id}', [ProductTypeController::class, 'update']);
Route::middleware('auth:sanctum')->delete('product-types/{id}', [ProductTypeController::class, 'delete']);

// PRODUCTS ROUTES
Route::middleware('auth:sanctum')->get('products', [ProductController::class, 'getAll']);
Route::middleware('auth:sanctum')->post('products', [ProductController::class, 'create']);
Route::middleware('auth:sanctum')->put('products/{product}', [ProductController::class, 'update']);
Route::middleware('auth:sanctum')->delete('products/{product}', [ProductController::class, 'delete']);
