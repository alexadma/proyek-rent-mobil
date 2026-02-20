<?php

use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;

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

use App\Http\Controllers\AdminMobilController;
use App\Http\Controllers\AdminSupirController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController as LoginControl;

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/sewa', [App\Http\Controllers\SewaController::class, 'index'])->name('sewa');
Route::get('/hitung', [App\Http\Controllers\SewaController::class, 'calculatePrice']);
Route::post('/sewa', [App\Http\Controllers\SewaController::class, 'store'])->name('sewa.store');
Route::get('/invoice', [App\Http\Controllers\SewaController::class, 'invoice'])->name('invoice');
Route::post('/invoice', [App\Http\Controllers\SewaController::class, 'updateInvoice']);

// Rute untuk tombol kembali
Route::get('/back-to-home', function () {
    return redirect('/home');
})->name('back.home');

Route::get('/', [\App\Http\Controllers\HomeAwal::class, 'index']);

Route::get('/daftarmobil', [MobilController::class, 'index']);

Route::get('/transaksi', [App\Http\Controllers\VerifikasiController::class, 'index'])->name('transaksi');
Route::get('/approve_transaksi/{id}', [App\Http\Controllers\VerifikasiController::class, 'approve_transaksi']);
Route::get('/reject_transaksi/{id}', [App\Http\Controllers\VerifikasiController::class, 'reject_transaksi']);
Route::get('/pengembalian', [App\Http\Controllers\pengembalianController::class, 'index'])->name('pengembalian');
Route::get('/pengembalian/{id}', [App\Http\Controllers\pengembalianController::class, 'pengembalian_selesai']);
Route::get('/keuangan', [App\Http\Controllers\KeuanganController::class, 'index'])->name('keuangan');
// Route::get('/pengembalian', [App\Http\Controllers\PengembalianController::class, 'index'])->name('pengembalian');

//Route::get('verifikasi', \App\Http\Controllers\Admin\VerifikasiController::class);


// Route::get('/login', 'Auth\LoginController@login')->name('login');
// Route::get('/login', [Auth\LoginController::class, 'login'])->name('login');
// Route untuk mengirimkan formulir kontak


// Route::group(['middleware' => ['auth', 'checkRole:staff']], function () {
//     Route::get('homeadmin', 'StaffController@dashboard')->name('staff.dashboard');
//     Route::get('/verifikasi', function () {
//         return view('admin/verifikasi');
//     });
// });

Auth::routes();

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/homeadmin', [\App\Http\Controllers\HomeController::class, 'adminHome'])->name('home.admin');
    Route::resource('/mobil', AdminMobilController::class);
    Route::resource('/supir', AdminSupirController::class);
});

require __DIR__ . '/auth.php';
