<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([EnsureAuthenticated::class])->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/data', [TransactionController::class, 'getData'])->name('transaksi.data');
    Route::get('/transaksi/create', [TransactionController::class, 'create'])->name('transaksi.create');
    Route::get('/transaksi/edit/{id}', [TransactionController::class, 'edit'])->name('transaksi.edit');
    Route::delete('/transaksi/{id}', [TransactionController::class, 'destroy'])->name('transaksi.destroy');
});
Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
