<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::resource('products', ProductController::class);
Route::get('/transactions/report', [TransactionController::class, 'reportForm'])->name('transactions.reportForm');
Route::post('/transactions/report', [TransactionController::class, 'generateReport'])->name('transactions.generateReport');
Route::get('/transactions/report/pdf', [TransactionController::class, 'exportReportPdf'])->name('transactions.exportReportPdf');
Route::get('/transactions/pdf/{id}', [TransactionController::class, 'exportPdf'])->name('transactions.pdf');
Route::resource('transactions', TransactionController::class);
