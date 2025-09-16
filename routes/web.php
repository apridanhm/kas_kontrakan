<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Middleware\AdminBasicAuth;

Route::prefix('admin')->middleware(AdminBasicAuth::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home'); // <-- ganti dari redirect()

    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);

    Route::get('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [\App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [\App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('payments.store');
    Route::delete('payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class)->only(['index','create','store','destroy']);
});
