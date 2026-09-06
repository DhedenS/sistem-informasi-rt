<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\SuratMasukController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Administrasi Surat - Surat Masuk
    Route::resource('surat-masuk', SuratMasukController::class);
});

// Cuma Superadmin yang boleh kelola blok & kategori transaksi
Route::middleware(['auth', 'role:Superadmin'])->group(function () {
    Route::resource('blocks', BlockController::class);
    Route::resource('transaction-categories', TransactionCategoryController::class);
});

// Superadmin & Bendahara yang boleh kelola data KK
Route::middleware(['auth', 'role:Superadmin|Bendahara'])->group(function () {
    Route::resource('households', HouseholdController::class);
});

require __DIR__ . '/auth.php';