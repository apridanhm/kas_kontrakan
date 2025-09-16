<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminBasicAuth;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TransactionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.public');

Route::prefix('admin')->middleware(AdminBasicAuth::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');

    Route::resource('members', MemberController::class);
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::resource('transactions', TransactionController::class)->only(['index','create','store','destroy']);
});
