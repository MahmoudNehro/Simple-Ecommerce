<?php

use App\Http\Controllers\Api\Authentication\AuthenticationController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthenticationController::class, 'store'])->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/logout', [AuthenticationController::class, 'destroy'])->name('logout');
    Route::apiResource('/carts/cart-items', CartController::class)->except(['show', 'create']);
    Route::post('/orders', OrderController::class)->name('orders.store');
});

Route::apiResource('/products', ProductController::class)->only(['index', 'show']);
