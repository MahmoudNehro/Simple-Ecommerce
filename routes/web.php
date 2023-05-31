<?php

use App\Http\Controllers\Admin\Authentication\AuthenticationController;
use App\Http\Controllers\Admin\General\NotificationController;
use App\Http\Controllers\Admin\Order\OrderController;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticationController::class, 'create'])->name('admin.login');
    Route::post('/login', [AuthenticationController::class, 'store'])->name('admin.login.store');
});

Route::middleware(['auth:web', 'is_admin'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('admin.dashboard');

    Route::delete('/logout', [AuthenticationController::class, 'destroy'])->name('admin.logout');
    Route::get('/orders', [OrderController::class,'index'])->name('admin.orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('read-notification/{notification}', [NotificationController::class, 'read'])->name('admin.read-notification');
    Route::get('mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.mark-all-as-read');
    Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications');
});
