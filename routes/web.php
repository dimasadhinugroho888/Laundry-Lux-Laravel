<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('home', [
        'packages' => \App\Models\Package::all()
    ]);
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{transaction}/bill', [TransactionController::class, 'bill'])
        ->name('transactions.bill');

    Route::get('transactions/{transaction}/pdf', [TransactionController::class, 'pdf'])
        ->name('transactions.pdf');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.csv');
});

require __DIR__.'/auth.php';
