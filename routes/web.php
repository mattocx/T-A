<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

// Routes untuk pembayaran
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment/status/{orderId}', [PaymentController::class, 'paymentStatus'])->name('payment.status');
});

// Route callback dari Midtrans (tidak perlu auth, karena dipanggil oleh Midtrans)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


