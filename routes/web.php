<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\CashflowReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\FundSourceController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\IuranSayaController;
use App\Http\Controllers\PengajuanIuranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifikasiIuranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Riwayat Transaksi
|--------------------------------------------------------------------------
| Semua user yang sudah login dapat melihat riwayat transaksi
| secara read-only.
|--------------------------------------------------------------------------
*/

Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])
    ->middleware('auth')
    ->name('riwayat-transaksi.index');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Administrasi Surat
|--------------------------------------------------------------------------
| Superadmin & Sekretaris
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Superadmin|Sekretaris'])->group(function () {

    Route::resource('surat-masuk', SuratMasukController::class);

});

/*
|--------------------------------------------------------------------------
| Master Data
|--------------------------------------------------------------------------
| Superadmin & Ketua RT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Superadmin|Ketua RT'])->group(function () {

    Route::resource('blocks', BlockController::class);

    Route::resource('transaction-categories', TransactionCategoryController::class);

    Route::resource('fund-sources', FundSourceController::class);

});

/*
|-----------------------------

---------------------------------------------
| Data KK
|--------------------------------------------------------------------------
| Superadmin, Ketua RT & Bendahara
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Superadmin|Ketua RT|Bendahara'])->group(function () {

    Route::resource('households', HouseholdController::class);

});

/*
|--------------------------------------------------------------------------
| Keuangan
|--------------------------------------------------------------------------
| Bendahara
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Bendahara'])->group(function () {

    Route::prefix('cashflow')->name('cashflow.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Transaksi Pemasukan
        |--------------------------------------------------------------------------
        */

        Route::get(
            'transactions/create-income',
            [TransactionController::class, 'createIncome']
        )->name('transactions.create-income');

        Route::post(
            'transactions/store-income',
            [TransactionController::class, 'storeIncome']
        )->name('transactions.store-income');

        /*
        |--------------------------------------------------------------------------
        | Transaksi Pengeluaran
        |--------------------------------------------------------------------------
        */

        Route::get(
            'transactions/create-expense',
            [TransactionController::class, 'createExpense']
        )->name('transactions.create-expense');

        Route::post(
            'transactions/store-expense',
            [TransactionController::class, 'storeExpense']
        )->name('transactions.store-expense');

        /*
        |--------------------------------------------------------------------------
        | Data Transaksi
        |--------------------------------------------------------------------------
        */

        Route::resource('transactions', TransactionController::class)
            ->except([
                'create',
                'store',
                'edit',
                'update',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Iuran KK
        |--------------------------------------------------------------------------
        */

        Route::resource('dues', DueController::class)
            ->only([
                'index',
                'create',
                'store',
            ]);

        Route::post(
            'dues/{due}/pay',
            [DueController::class, 'pay']
        )->name('dues.pay');

        /*
        |--------------------------------------------------------------------------
        | Laporan Keuangan
        |--------------------------------------------------------------------------
        */

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

/*
|--------------------------------------------------------------------------
| Pengajuan Iuran
|--------------------------------------------------------------------------
| Ketua Block
|--------------------------------------------------------------------------
|
| Ketua Block hanya dapat:
| - Melihat pengajuan milik bloknya
| - Membuat pengajuan iuran
| - Memilih KK yang sudah membayar
| - Melihat detail pengajuan
|
*/

Route::middleware(['auth', 'role:Ketua Block'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Daftar Pengajuan Iuran
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengajuan-iuran',
        [PengajuanIuranController::class, 'index']
    )->name('pengajuan-iuran.index');

    /*
    |--------------------------------------------------------------------------
    | Form Pengajuan Iuran
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengajuan-iuran/create',
        [PengajuanIuranController::class, 'create']
    )->name('pengajuan-iuran.create');

    /*
    |--------------------------------------------------------------------------
    | Simpan Pengajuan Iuran
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/pengajuan-iuran',
        [PengajuanIuranController::class, 'store']
    )->name('pengajuan-iuran.store');

    /*
    |--------------------------------------------------------------------------
    | Detail Pengajuan Iuran
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengajuan-iuran/{pengajuanIuran}',
        [PengajuanIuranController::class, 'show']
    )->name('pengajuan-iuran.show');

    Route::delete('/pengajuan-iuran/{pengajuanIuran}/cancel', [PengajuanIuranController::class, 'cancel'])
        ->name('pengajuan-iuran.cancel');
    Route::get('/rekap-iuran-blok', [DueController::class, 'myBlockRecap'])->name('dues.my-block');
    Route::get('/rekap-iuran-blok/export', [DueController::class, 'exportMyBlockRecap'])->name('dues.my-block.export');
});

Route::middleware(['auth', 'role:Bendahara|Superadmin|Ketua RT|Ketua Block'])->group(function () {
    Route::get('/verifikasi-iuran/rekap', [VerifikasiIuranController::class, 'rekap'])
        ->name('verifikasi-iuran.rekap');

    Route::get('/verifikasi-iuran/export-excel', [VerifikasiIuranController::class, 'exportExcel'])
        ->name('verifikasi-iuran.export-excel');

    Route::get('/verifikasi-iuran/{pengajuanIuran}/export-excel', [VerifikasiIuranController::class, 'exportPengajuanExcel'])
        ->name('verifikasi-iuran.export-pengajuan-excel');
});

Route::middleware(['auth', 'role:Bendahara'])->group(function () {
    Route::get('/verifikasi-iuran', [VerifikasiIuranController::class, 'index'])
        ->name('verifikasi-iuran.index');

    Route::get('/verifikasi-iuran/{pengajuanIuran}', [VerifikasiIuranController::class, 'show'])
        ->name('verifikasi-iuran.show');

    Route::post('/verifikasi-iuran/{pengajuanIuran}/approve', [VerifikasiIuranController::class, 'approve'])
        ->name('verifikasi-iuran.approve');

    Route::post('/verifikasi-iuran/{pengajuanIuran}/reject', [VerifikasiIuranController::class, 'reject'])
        ->name('verifikasi-iuran.reject');
});
Route::middleware(['auth', 'role:Warga'])->group(function () {
    Route::get('/iuran-saya', [IuranSayaController::class, 'index'])
        ->name('iuran-saya.index');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
