<?php

use App\Http\Controllers\AdminMobilController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AdminSupirController;
use App\Http\Controllers\HomeAwal;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\StorageFileController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('storage/{path}', [StorageFileController::class, 'show'])->where('path', '.*');

Route::middleware('auth:admin')->group(function () {
    Route::get('logs', [LogViewerController::class, 'index']);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [HomeAwal::class, 'index']);

Route::get('/daftarmobil', [MobilController::class, 'index']);

// Sewa (wajib login customer)
Route::middleware('auth')->group(function () {
    Route::get('/sewa', [SewaController::class, 'index'])->name('sewa');
    Route::get('/hitung', [SewaController::class, 'calculatePrice']);
    Route::post('/sewa', [SewaController::class, 'store'])->name('sewa.store');
    Route::get('/invoice', [SewaController::class, 'invoice'])->name('invoice');
    Route::post('/invoice', [SewaController::class, 'updateInvoice']);

    // Profile Customer
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Area admin (wajib login sebagai admin)
Route::middleware('auth:admin')->group(function () {
    Route::get('/homeadmin', [HomeController::class, 'adminHome'])->name('home.admin');
    Route::resource('/mobil', AdminMobilController::class);
    Route::resource('/supir', AdminSupirController::class);

    Route::get('/transaksi', [VerifikasiController::class, 'index'])->name('transaksi');
    Route::post('/approve_transaksi/{id}', [VerifikasiController::class, 'approve_transaksi'])->name('approve.transaksi');
    Route::post('/reject_transaksi/{id}', [VerifikasiController::class, 'reject_transaksi'])->name('reject.transaksi');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::post('/pengembalian/{id}', [PengembalianController::class, 'pengembalian_selesai'])->name('pengembalian.selesai');
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])->name('pengaturan.profile');
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});

require __DIR__.'/auth.php';
