<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\FundSourceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\CashflowReportController;

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

    // Administrasi Surat - Surat Masuk (modul surat di-skip dulu sesuai dokumen terbaru,
    // route dibiarkan ada tapi belum dipakai/didemokan)
    Route::resource('surat-masuk', SuratMasukController::class);
});

// Ketua RT: mengawasi sistem & data RT secara keseluruhan -> kelola blok & master data
Route::middleware(['auth', 'role:Ketua RT'])->group(function () {

    Route::resource('blocks', BlockController::class);

    Route::resource('transaction-categories', TransactionCategoryController::class);

    Route::resource('fund-sources', FundSourceController::class);
});

// Bendahara: kelola & periksa data keuangan, approve/reject pembayaran
Route::middleware(['auth', 'role:Bendahara'])->group(function () {

    Route::prefix('cashflow')->name('cashflow.')->group(function () {

        Route::get(
            'transactions/create-income',
            [TransactionController::class, 'createIncome']
        )->name('transactions.create-income');

        Route::post(
            'transactions/store-income',
            [TransactionController::class, 'storeIncome']
        )->name('transactions.store-income');

        Route::get(
            'transactions/create-expense',
            [TransactionController::class, 'createExpense']
        )->name('transactions.create-expense');

        Route::post(
            'transactions/store-expense',
            [TransactionController::class, 'storeExpense']
        )->name('transactions.store-expense');

        Route::resource('transactions', TransactionController::class)
            ->except(['create', 'store', 'edit', 'update']);

        Route::resource('dues', DueController::class)
            ->only(['index', 'create', 'store']);

        Route::post(
            'dues/{due}/pay',
            [DueController::class, 'pay']
        )->name('dues.pay');

        Route::get(
            'reports',
            [CashflowReportController::class, 'index']
        )->name('reports.index');

        Route::get(
            'reports/pdf',
            [CashflowReportController::class, 'exportPdf']
        )->name('reports.pdf');

        Route::get(
            'reports/excel',
            [CashflowReportController::class, 'exportExcel']
        )->name('reports.excel');
    });
});

// Ketua RT & Bendahara yang boleh kelola data KK
Route::middleware(['auth', 'role:Ketua RT|Bendahara'])->group(function () {
    Route::resource('households', HouseholdController::class);
});

require __DIR__ . '/auth.php';
