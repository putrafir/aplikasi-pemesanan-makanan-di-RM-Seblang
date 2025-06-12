<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/menu',
    [MenuController::class, 'index']
)->name('customer.menu');
Route::get(
    '/',
    function () {
        return view('auth.login');
    }
);

Route::get('customer/keranjang', [KeranjangController::class, 'index'])->name('customer.keranjang.view');
Route::post('/customer/keranjang/add', [KeranjangController::class, 'addToCart'])->name('customer.keranjang.add');
Route::delete('/customer/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('customer.keranjang.delete');
Route::post('/customer/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('customer.keranjang.checkout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/kasir/dashboard', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/kasir/pesanan', [KasirController::class, 'index'])->name('kasir.pesanan');
    Route::post('/keranjang/checkout-pesanan', [KeranjangController::class, 'checkoutToPesanan'])->name('keranjang.checkoutPesanan');
    Route::get('/kasir/pesanan/{id}/bayar', [PesananController::class, 'showBayar'])->name('kasir.bayar');
    Route::put('/pesanan/{id}/bayar/', [PesananController::class, 'prosesBayar'])->name('pesanan.bayar.proses');
    Route::post('/kasir/pesanan/{id}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::post('/transaksi/bayar/{pesananId}', [TransaksiController::class, 'prosesBayar'])->name('transaksi.bayar');
    Route::get('/kasir/pesanan/{id}/detail', [KasirController::class, 'detail'])->name('kasir.pesanan.detail');
    Route::delete('/kasir/pesanan/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
    Route::put('/kasir/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('kasir.transaksi.updateStatus');
    Route::put('/kasir/transaksi/{id}/status/bayar', [TransaksiController::class, 'updateStatusBayar'])->name('kasir.transaksi.updateStatusBayar');
    Route::get('/admin/menu', [AdminController::class, 'index'])->name('admin.menu');
    Route::get('/admin/nomormeja', [AdminController::class, 'nomorMeja'])->name('admin.nomormeja');
    Route::get('/admin/tambah/menu', [AdminController::class, 'tambahMenu'])->name('admin.tambah.menu');
    Route::get('/admin/tambah/nomormeja', [AdminController::class, 'tambahNomorMeja'])->name('admin.tambah.nomormeja');
    Route::post('/admin/store/menu', [AdminController::class, 'storeMenu'])->name('admin.store.menu');
    Route::post('/admin/store/nomormeja', [AdminController::class, 'storeNomorMeja'])->name('admin.store.nomormeja');
    Route::get('/admin/edit/menu/{id}', [AdminController::class, 'editMenu'])->name('admin.edit.menu');
    Route::get('/admin/edit/nomormeja/{id}', [AdminController::class, 'editNomorMeja'])->name('admin.edit.nomormeja');
    Route::post('/admin/update/menu', [AdminController::class, 'updateMenu'])->name('admin.update.menu');
    Route::post('/admin/update/nomormeja', [AdminController::class, 'updateNomorMeja'])->name('admin.update.nomormeja');
    Route::get('/admin/delete/menu/{id}', [AdminController::class, 'deleteMenu'])->name('admin.delete.menu');
    Route::get('/admin/delete/nomormeja/{id}', [AdminController::class, 'deleteNomorMeja'])->name('admin.delete.nomormeja');
    Route::put('/admin/update/stok/{id}', [AdminController::class, 'updateStok'])->name('admin.update.stok');
});



require __DIR__ . '/auth.php';
