<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::apiResource('products', ProductController::class);

Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{order}/confirm', [OrderController::class, 'confirm']);
Route::put('orders/{order}/cancel', [OrderController::class, 'cancel']);

Route::get('logs', [LogController::class, 'index']);
