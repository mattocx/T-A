<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\SalesAuthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', fn () => redirect()->to('/'))->name('login');

Route::get('/dashboard/login', [AdminAuthController::class, 'login'])->name('filament.dashboard.auth.login');
Route::post('/dashboard/login', [AdminAuthController::class, 'authenticate'])->name('filament.dashboard.auth.login');

Route::get('/sales/login', [SalesAuthController::class, 'login'])->name('filament.sales.auth.login');
Route::post('/sales/login', [SalesAuthController::class, 'authenticate'])->name('filament.sales.auth.login');

Route::get('/customer/login', [CustomerAuthController::class, 'login'])->name('filament.customer.auth.login');
Route::post('/customer/login', [CustomerAuthController::class, 'authenticate'])->name('filament.customer.auth.login');
