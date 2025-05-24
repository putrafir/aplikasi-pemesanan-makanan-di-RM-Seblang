<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/kasir/pesanan', [KasirController::class, 'index'])->name('kasir.pesanan');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/menu', [AdminController::class, 'index'])->name('admin.menu');
    Route::get('/admin/tambah/menu', [AdminController::class, 'tambahMenu'])->name('admin.tambah.menu');
    Route::post('/admin/store/menu', [AdminController::class, 'storeMenu'])->name('admin.store.menu');
    Route::get('/admin/edit/menu/{id}', [AdminController::class, 'editMenu'])->name('admin.edit.menu');
    Route::post('/admin/update/menu', [AdminController::class, 'updateMenu'])->name('admin.update.menu');
    Route::get('/admin/delete/menu/{id}', [AdminController::class, 'deleteMenu'])->name('admin.delete.menu');
});



require __DIR__ . '/auth.php';
