<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Lamure Egypt
|--------------------------------------------------------------------------
|
| All routes return JSON. No authentication middleware is applied here
| for development simplicity; add auth:sanctum in production.
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/products/{id}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'index']);
Route::post('/products/{id}/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'store']);

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::patch('/orders/{id}', [OrderController::class, 'updateStatus']);

Route::get('/users', [UserController::class, 'index']);
Route::patch('/users/{id}', [UserController::class, 'update']);
Route::get('/users/{id}/addresses', [\App\Http\Controllers\Api\AddressController::class, 'index']);
Route::post('/users/{id}/addresses', [\App\Http\Controllers\Api\AddressController::class, 'store']);
Route::put('/addresses/{id}', [\App\Http\Controllers\Api\AddressController::class, 'update']);
Route::delete('/addresses/{id}', [\App\Http\Controllers\Api\AddressController::class, 'destroy']);

Route::get('/admin/stats', [AdminController::class, 'stats']);
Route::get('/admin/sales-chart', [AdminController::class, 'salesChart']);
