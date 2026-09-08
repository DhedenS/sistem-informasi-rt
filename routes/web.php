<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\ApprovalController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


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
    // MASTER DATA
    // =========================
    Route::resource('blocks', BlockController::class);

    Route::resource('households', HouseholdController::class);

    Route::resource(
        'transaction-categories',
        TransactionCategoryController::class
    );


    // =========================
    // APPROVAL
    // Kategori 4
    // =========================

    Route::get('/approval', [ApprovalController::class, 'index'])
        ->name('approval.index');

    Route::get('/approval/{approval}', [ApprovalController::class, 'show'])
        ->name('approval.show');

    Route::post('/approval/{approval}/verify', [ApprovalController::class, 'verify'])
        ->name('approval.verify');

    Route::post('/approval/{approval}/approve', [ApprovalController::class, 'approve'])
        ->name('approval.approve');

    Route::post('/approval/{approval}/reject', [ApprovalController::class, 'reject'])
        ->name('approval.reject');

    Route::post('/approval/{approval}/revision', [ApprovalController::class, 'revision'])
        ->name('approval.revision');

    Route::post('/approval/{approval}/archive', [ApprovalController::class, 'archive'])
        ->name('approval.archive');

});


require __DIR__ . '/auth.php';