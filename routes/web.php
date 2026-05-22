<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('produk', ProdukController::class)->except(['show']);

    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::post('/stok', [StokController::class, 'store'])->name('stok.store');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{transaksi}', [LaporanController::class, 'show'])->name('laporan.show');

    Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik.index');
});

Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('index');
    Route::get('/cari', [KasirController::class, 'search'])->name('search');
    Route::post('/checkout', [KasirController::class, 'checkout'])->name('checkout');
    Route::get('/struk/{transaksi}', [KasirController::class, 'struk'])->name('struk');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
