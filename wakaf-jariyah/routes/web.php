<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/donation', [OrderController::class, 'index'])->name('order.index');
Route::post('/donation', [OrderController::class, 'store'])->name('order.store');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/admin', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('order.indexAdmin');
    Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

