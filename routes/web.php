<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WishlistController; // [Penting] Import Controller Wishlist
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK (Bisa diakses siapa saja)
Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/car/{id}', [CarController::class, 'show'])->name('car.show');

// 2. GROUP USER (Harus Login Dulu)
Route::middleware(['auth'])->group(function () {
    
    // --- FITUR PEMBELIAN ---
    Route::get('/checkout/{id}', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{id}', [TransactionController::class, 'store'])->name('transaction.store');
    
    // --- FITUR RIWAYAT & REVIEW ---
    Route::get('/history', [TransactionController::class, 'history'])->name('history');
    Route::post('/transaction/review/{id}', [TransactionController::class, 'submitReview'])->name('transaction.review');

    // --- FITUR WISHLIST (BARU) ---
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

});

// 3. GROUP ADMIN (Hanya Role Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    
    // --- MANAJEMEN MOBIL (CRUD) ---
    Route::get('/admin/create', [CarController::class, 'create'])->name('car.create');
    Route::post('/admin/store', [CarController::class, 'store'])->name('car.store');
    Route::get('/admin/edit/{id}', [CarController::class, 'edit'])->name('car.edit');
    Route::put('/admin/update/{id}', [CarController::class, 'update'])->name('car.update'); 
    Route::delete('/admin/delete/{id}', [CarController::class, 'destroy'])->name('car.destroy');

    // --- MANAJEMEN TRANSAKSI ---
    Route::get('/admin/transactions', [TransactionController::class, 'indexAdmin'])->name('admin.transactions');
    Route::patch('/admin/transactions/{id}', [TransactionController::class, 'updateStatus'])->name('admin.transaction.update');

});

// Load Routes untuk Login/Register bawaan Breeze
require __DIR__.'/auth.php';