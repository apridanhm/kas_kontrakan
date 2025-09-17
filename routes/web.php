<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminBasicAuth;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ContributionController;
// use App\Http\Controllers\Admin\IncomeCategoryController; // aktifkan kalau mau kelola kategori lewat UI

// Halaman publik (dashboard umum)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.public');

// Area Admin
Route::prefix('admin')->middleware(AdminBasicAuth::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');

    // Anggota
    Route::resource('members', MemberController::class);

    // Pemasukan (dinamis, bisa beberapa kali/bulan/kategori)
    Route::get('contributions', [ContributionController::class, 'index'])->name('contributions.index');
    Route::get('contributions/create', [ContributionController::class, 'create'])->name('contributions.create');
    Route::post('contributions', [ContributionController::class, 'store'])->name('contributions.store');
    Route::delete('contributions/{contribution}', [ContributionController::class, 'destroy'])->name('contributions.destroy');

    // (Opsional) Kelola kategori pemasukan
    // Route::resource('categories', IncomeCategoryController::class)->except(['show']);

    // Pengeluaran (+ upload nota)
    Route::resource('transactions', TransactionController::class)->only(['index','create','store','destroy']);

    // Kompatibilitas: alihkan menu "payments" lama ke "contributions"
    Route::get('payments', fn () => redirect()->route('contributions.index'))->name('payments.index');
    Route::get('payments/create', function (\Illuminate\Http\Request $r) {
        return redirect()->route('contributions.create', [
            'month'       => $r->query('month', now()->format('Y-m')),
            'category_id' => $r->query('category_id'),
        ]);
    })->name('payments.create');
    // Hapus route POST/DELETE payments lama agar tidak dipakai lagi.
});
