<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LogAktivitasController;

// Auth Route Start
Route::get('/login', [AuthController::class, 'login_view'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.login');

// Route::get('/register', [AuthController::class, 'register_view'])->name('register.index');
// Route::post('/register', [AuthController::class, 'register'])->name('register.register');

Route::get('logout', [AuthController::class, 'logout_success_view'])->name('logout_success.index');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.logout');

// Auth Route End


// Route All Role Start

Route::middleware(['auth'])->group(function() {
    Route::get('/', [DashboardController::class, 'index']);

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Peminjam
    Route::get('peminjam/', [PeminjamController::class, 'index'])->name('peminjam.index');
    Route::get('peminjam/detail/{id}', [PeminjamController::class, 'detail'])->name('peminjam.detail');
    Route::get('peminjam/create', [PeminjamController::class, 'create'])->name('peminjam.create');
    Route::post('peminjam/create', [PeminjamController::class, 'store'])->name('peminjam.store');
    Route::get('peminjam/update/{id}', [PeminjamController::class, 'edit'])->name('peminjam.edit');
    Route::put('peminjam/update/{id}', [PeminjamController::class, 'update'])->name('peminjam.update');
    Route::delete('puri: eminjam/delete/{id}', [PeminjamController::class, 'destroy'])->name('peminjam.destroy');

    // Peminjaman
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman/create', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('peminjaman/update/{id}', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('peminjaman/update/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('peminjaman/delete/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::get('peminjaman/detail/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('peminjaman/tambah_ke_keranjang', [PeminjamanController::class, 'addToCart'])->name('peminjaman.addToCart');
    Route::post('peminjaman/hapus_dari_keranjang/{index}', [PeminjamanController::class, 'removeFromCart'])->name('peminjaman.removeFromCart');

    // Kategori
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('kategori/create', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('kategori/update/{id}', action: [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('kategori/update/{id}', action: [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('kategori/delete/{id}', action: [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('kategori/detail/{id}', [KategoriController::class, 'show'])->name('kategori.show');

    // Barang
    Route::get('barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('barang/create', [BarangController::class, 'store'])->name('barang.store');
    Route::get('barang/update/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Barang Masuk
    Route::get('barang_masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::get('barang_masuk/create', [BarangMasukController::class, 'create'])->name('barang_masuk.create');
    Route::post('barang_masuk/create', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
    Route::get('barang_masuk/update/{id}', [BarangMasukController::class, 'edit'])->name('barang_masuk.edit');
    Route::put('barang_masuk/update/{id}', [BarangMasukController::class, 'update'])->name('barang_masuk.update');
    Route::delete('barang_masuk/delete/{id}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
    Route::post('barang_masuk/tambah_ke_keranjang', [BarangMasukController::class, 'addToCart'])->name('barang_masuk.addToCart');
    Route::post('barang_masuk/hapus_dari_keranjang/{index}', [BarangMasukController::class, 'removeFromCart'])->name('barang_masuk.removeFromCart');
    Route::get('barang_masuk/detail/{ids}', [BarangMasukController::class, 'show'])->name('barang_masuk.show');
    Route::delete('/barang_masuk/cancel_all', [BarangMasukController::class, 'cancelAll'])->name('barang_masuk.cancel_all');
    Route::delete('/barang_masuk/{id}/cancel', [BarangMasukController::class, 'cancel'])->name('barang_masuk.cancel');

    // Barang Keluar
    Route::get('barang_keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::get('barang_keluar/create', [BarangKeluarController::class, 'create'])->name('barang_keluar.create');
    Route::post('barang_keluar/create', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
    Route::get('barang_keluar/update/{id}', [BarangKeluarController::class, 'edit'])->name('barang_keluar.edit');
    Route::put('barang_keluar/update/{id}', [BarangKeluarController::class, 'update'])->name('barang_keluar.update');
    Route::delete('barang_keluar/delete/{id}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
    Route::post('barang_keluar/tambah_ke_keranjang', [BarangKeluarController::class, 'addToCart'])->name('barang_keluar.addToCart');
    Route::post('barang_keluar/hapus_dari_keranjang/{index}', [BarangKeluarController::class, 'removeFromCart'])->name('barang_keluar.removeFromCart');
    Route::get('barang_keluar/detail/{ids}', [BarangKeluarController::class, 'show'])->name('barang_keluar.show');
    Route::delete('/barang_keluar/cancel_all', [BarangKeluarController::class, 'cancelAll'])->name('barang_keluar.cancel_all');
    Route::delete('/barang_keluar/{id}/cancel', [BarangKeluarController::class, 'cancel'])->name('barang_keluar.cancel');

    // Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('supplier/create', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('supplier/update/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('supplier/detail/{id}', [SupplierController::class, 'show'])->name('supplier.show');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export.pdf');
});

// Routes All Role End

// Routes Petugas Can't Not Start
Route::middleware(['auth', 'checkRole:0'])->group(function () {
    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/{id}', [SettingsController::class, 'update'])->name('settings.update');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('users/create', [UserController::class, 'store'])->name('user.store');
    Route::get('users/update/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('users/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('users/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    
    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log_aktivitas.index');
    Route::delete('/log-aktivitas/clear', [LogAktivitasController::class, 'clear'])->name('log_aktivitas.clear');
});

// Routes Petugas Can't Not End