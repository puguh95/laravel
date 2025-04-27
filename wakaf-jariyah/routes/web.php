<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome'); //redirect to landing page
});

Route::get('/donation', [OrderController::class, 'index'])->name('order.index');
Route::post('/donation', [OrderController::class, 'store'])->name('order.store');
Route::post('/donation/callback', [OrderController::class, 'handleCallback'])->name('order.callback');
Route::get('/donation/{uuid}', [OrderController::class, 'indexTransfer'])->name('order.transfer');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/admin', [OrderController::class, 'indexAdmin'])->name('order.indexAdmin');
    Route::get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('order.indexAdmin');
    Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

