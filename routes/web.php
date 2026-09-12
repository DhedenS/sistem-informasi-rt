<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\SuratMasukController;
use App\Models\Approval;
use App\Http\Controllers\BlockDepositController;


/*
|--------------------------------------------------------------------------
| Public Routes
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
Route::get('/dashboard', function () {

    $pendingApprovals = Approval::whereNotIn('status', [
        'approved',
        'rejected',
        'archived',
    ])->count();

    return view('dashboard', compact('pendingApprovals'));

})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // =========================
    // PROFILE
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =========================
    // APPROVAL
    // Kategori 4
    // =========================
    Route::prefix('approval')
        ->name('approval.')
        ->group(function () {

            Route::get('/', [ApprovalController::class, 'index'])
                ->name('index');

            Route::get('/{approval}', [ApprovalController::class, 'show'])
                ->name('show');

            Route::post('/{approval}/verify', [ApprovalController::class, 'verify'])
                ->name('verify');

            Route::post('/{approval}/approve', [ApprovalController::class, 'approve'])
                ->name('approve');

            Route::post('/{approval}/reject', [ApprovalController::class, 'reject'])
                ->name('reject');

            Route::post('/{approval}/revision', [ApprovalController::class, 'revision'])
                ->name('revision');

            Route::post('/{approval}/archive', [ApprovalController::class, 'archive'])
                ->name('archive');
        });


    // =========================
    // ADMINISTRASI SURAT
    // Surat Masuk
    // =========================
    Route::resource('surat-masuk', SuratMasukController::class);

    Route::prefix('block-deposits')
    ->name('block-deposits.')
    ->group(function () {

        Route::get(
            '/',
            [BlockDepositController::class, 'index']
        )->name('index');

        Route::get(
            '/create',
            [BlockDepositController::class, 'create']
        )->name('create');

        Route::post(
            '/',
            [BlockDepositController::class, 'store']
        )->name('store');

        Route::get(
            '/{blockDeposit}',
            [BlockDepositController::class, 'show']
        )->name('show');
    });
});


/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
|
| Hanya Superadmin yang boleh mengelola:
| - Blok
| - Kategori Transaksi
|
*/

Route::middleware(['auth', 'role:Superadmin'])->group(function () {

    Route::resource('blocks', BlockController::class);

    Route::resource(
        'transaction-categories',
        TransactionCategoryController::class
    );
});


/*
|--------------------------------------------------------------------------
| SUPERADMIN & BENDAHARA
|--------------------------------------------------------------------------
|
| Superadmin dan Bendahara boleh mengelola data KK.
|
*/

Route::middleware(['auth', 'role:Superadmin|Bendahara'])->group(function () {

    Route::resource('households', HouseholdController::class);
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';