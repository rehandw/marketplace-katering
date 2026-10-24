<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Merchant;
use App\Http\Controllers\Customer;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'merchant'
            ? redirect()->route('merchant.dashboard')
            : redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/dashboard', [Merchant\ProfileController::class, 'index'])->name('dashboard');
    Route::put('/profile', [Merchant\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('menus', Merchant\MenuController::class);

    Route::get('/orders', [Merchant\OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [Merchant\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [Customer\CateringSearchController::class, 'index'])->name('dashboard');
    Route::get('/catering/{id}', [Customer\CateringSearchController::class, 'show'])->name('catering.show');

    Route::post('/checkout', [Customer\CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/invoices', [Customer\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [Customer\InvoiceController::class, 'show'])->name('invoices.show');
});