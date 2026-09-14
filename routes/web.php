<?php

use Illuminate\Support\Facades\Route;

use App\Models\Approval;
use App\Models\PengajuanIuran;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\FundSourceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\CashflowReportController;
use App\Http\Controllers\PengajuanIuranController;
use App\Http\Controllers\VerifikasiIuranController;
use App\Http\Controllers\IuranSayaController;


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $pendingApprovals = 0;

    if (
        auth()->user()->hasAnyRole([
            'Ketua RT',
            'Bendahara',
        ])
    ) {
        $pendingApprovals = \App\Models\Approval::where(
            'approvable_type',
            \App\Models\PengajuanIuran::class
        )
            ->where('status', 'pending')
            ->count();
    }

    return view(
        'dashboard',
        compact('pendingApprovals')
    );

})
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| ADMINISTRASI SURAT
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Superadmin|Sekretaris',
])->group(function () {

    Route::resource(
        'surat-masuk',
        SuratMasukController::class
    );

});


/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Superadmin|Ketua RT',
])->group(function () {

    Route::resource(
        'blocks',
        BlockController::class
    );

    Route::resource(
        'transaction-categories',
        TransactionCategoryController::class
    );

    Route::resource(
        'fund-sources',
        FundSourceController::class
    );

});


/*
|--------------------------------------------------------------------------
| DATA KK
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Ketua RT|Bendahara',
])->group(function () {

    Route::get(
        '/verifikasi-iuran',
        [VerifikasiIuranController::class, 'index']
    )->name('verifikasi-iuran.index');

    Route::get(
        '/verifikasi-iuran/{pengajuanIuran}',
        [VerifikasiIuranController::class, 'show']
    )->name('verifikasi-iuran.show');

    Route::post(
        '/verifikasi-iuran/{pengajuanIuran}/approve',
        [VerifikasiIuranController::class, 'approve']
    )->name('verifikasi-iuran.approve');

    Route::post(
        '/verifikasi-iuran/{pengajuanIuran}/reject',
        [VerifikasiIuranController::class, 'reject']
    )->name('verifikasi-iuran.reject');

});


/*
|--------------------------------------------------------------------------
| CASHFLOW
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Superadmin|Bendahara',
])->group(function () {

    Route::prefix('cashflow')
        ->name('cashflow.')
        ->group(function () {

            Route::get(
                'transactions/create-income',
                [
                    TransactionController::class,
                    'createIncome',
                ]
            )->name(
                'transactions.create-income'
            );

            Route::post(
                'transactions/store-income',
                [
                    TransactionController::class,
                    'storeIncome',
                ]
            )->name(
                'transactions.store-income'
            );


            Route::get(
                'transactions/create-expense',
                [
                    TransactionController::class,
                    'createExpense',
                ]
            )->name(
                'transactions.create-expense'
            );

            Route::post(
                'transactions/store-expense',
                [
                    TransactionController::class,
                    'storeExpense',
                ]
            )->name(
                'transactions.store-expense'
            );


            Route::resource(
                'transactions',
                TransactionController::class
            )->except([
                'create',
                'store',
                'edit',
                'update',
            ]);


            Route::resource(
                'dues',
                DueController::class
            )->only([
                'index',
                'create',
                'store',
            ]);

            Route::post(
                'dues/{due}/pay',
                [
                    DueController::class,
                    'pay',
                ]
            )->name('dues.pay');


            Route::get(
                'reports',
                [
                    CashflowReportController::class,
                    'index',
                ]
            )->name('reports.index');

            Route::get(
                'reports/pdf',
                [
                    CashflowReportController::class,
                    'exportPdf',
                ]
            )->name('reports.pdf');

            Route::get(
                'reports/excel',
                [
                    CashflowReportController::class,
                    'exportExcel',
                ]
            )->name('reports.excel');
        });

});


/*
|--------------------------------------------------------------------------
| PENGAJUAN IURAN - KETUA BLOCK
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Perwakilan Blok',
])->group(function () {

    Route::get(
        '/pengajuan-iuran',
        [PengajuanIuranController::class, 'index']
    )->name('pengajuan-iuran.index');

    Route::get(
        '/pengajuan-iuran/create',
        [PengajuanIuranController::class, 'create']
    )->name('pengajuan-iuran.create');

    Route::post(
        '/pengajuan-iuran',
        [PengajuanIuranController::class, 'store']
    )->name('pengajuan-iuran.store');

    Route::get(
        '/pengajuan-iuran/{pengajuanIuran}',
        [PengajuanIuranController::class, 'show']
    )->name('pengajuan-iuran.show');

});


/*
|--------------------------------------------------------------------------
| APPROVAL / VERIFIKASI IURAN
|--------------------------------------------------------------------------
|
| Superadmin ikut diberikan akses untuk testing.
|
*/
Route::middleware([
    'auth',
    'role:Superadmin|Bendahara',
])->group(function () {

    Route::get(
        '/verifikasi-iuran',
        [VerifikasiIuranController::class, 'index']
    )->name('verifikasi-iuran.index');

    Route::get(
        '/verifikasi-iuran/{pengajuanIuran}',
        [VerifikasiIuranController::class, 'show']
    )->name('verifikasi-iuran.show');

    Route::post(
        '/verifikasi-iuran/{pengajuanIuran}/approve',
        [VerifikasiIuranController::class, 'approve']
    )->name('verifikasi-iuran.approve');

    Route::post(
        '/verifikasi-iuran/{pengajuanIuran}/reject',
        [VerifikasiIuranController::class, 'reject']
    )->name('verifikasi-iuran.reject');

});


/*
|--------------------------------------------------------------------------
| WARGA
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Warga',
])->group(function () {

    Route::get(
        '/iuran-saya',
        [
            IuranSayaController::class,
            'index',
        ]
    )->name(
        'iuran-saya.index'
    );

});


require __DIR__ . '/auth.php';
require __DIR__ . '/auth.php';
