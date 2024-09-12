<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::resource('products', ProductController::class);
Route::post('transactions/print-selected', [TransactionController::class, 'printSelectedPdf'])->name('transactions.printSelectedPdf');
Route::resource('transactions', TransactionController::class);

