<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;

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

//Route::get('/', function () {
//  return view('welcome');
//});

//login
Route::get('/', [HomeController::class, 'index', ''])->name('dashboard');
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(BarangController::class)->group(function () {
    Route::get('/barang', 'index')->name('barang');
    Route::post('/barang/tambah', 'tambah')->name('barang.tambah');
    Route::post('/barang/update', 'update')->name('barang.update');
    Route::get('/barang/hapus/{id}', 'hapus')->name('barang.hapus');
    Route::get('/barang/detail/{id}', 'detail')->name('barang.detail');
    Route::get('/barang/list', 'list')->name('barang.list');
});

Route::controller(JenisBarangController::class)->group(function () {
    Route::get('/jenis', 'index')->name('jenis');
    Route::post('/jenis/tambah', 'tambah')->name('jenis.tambah');
    Route::post('/jenis/update', 'update')->name('jenis.update');
    Route::get('/jenis/hapus/{id}', 'hapus')->name('jenis.hapus');
    Route::get('/jenis/detail/{id}', 'detail')->name('jenis.detail');
    Route::get('/jenis/list', 'list')->name('jenis.list');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user');
    Route::post('/user/tambah', 'tambah')->name('user.tambah');
    Route::post('/user/update', 'update')->name('user.update');
    Route::get('/user/hapus/{id}', 'hapus')->name('user.hapus');
    Route::get('/user/detail/{id}', 'detail')->name('user.detail');
    Route::get('/user/list', 'list')->name('user.list');
});

Route::controller(TransaksiController::class)->group(function () {
    Route::get('/transaksi', 'index')->name('transaksi');
    Route::post('/transaksi/tambah', 'tambah')->name('transaksi.tambah');
    Route::post('/transaksi/update', 'update')->name('transaksi.update');
    Route::get('/transaksi/hapus/{id}', 'hapus')->name('transaksi.hapus');
    Route::get('/transaksi/detail/{id}', 'detail')->name('transaksi.detail');
    Route::get('/transaksi/list', 'list')->name('transaksi.list');
});

Route::controller(DiskonController::class)->group(function () {
    Route::get('/diskon', 'index')->name('diskon');
    Route::post('/diskon/tambah', 'tambah')->name('diskon.tambah');
    Route::post('/diskon/update', 'update')->name('diskon.update');
    Route::get('/diskon/hapus/{id}', 'hapus')->name('diskon.hapus');
    Route::get('/diskon/detail/{id}', 'detail')->name('diskon.detail');
    Route::get('/diskon/list', 'list')->name('diskon.list');
});
