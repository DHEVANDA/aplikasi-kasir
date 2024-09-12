<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'create'])->name('home');
Route::resource('products', ProductController::class);
Route::resource('transactions', TransactionController::class);

