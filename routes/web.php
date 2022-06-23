<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LokasiControllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('barang', App\Http\Controllers\BarangController::class);
    Route::resource('member', App\Http\Controllers\MemberController::class);
    Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
});

Route::get('country-state-city', [App\Http\Controllers\LokasiControllers::class, 'index'])->name('location');
Route::post('get-states-by-country', [App\Http\Controllers\LokasiControllers::class, 'getState']);
Route::post('get-cities-by-state', [App\Http\Controllers\LokasiControllers::class, 'getCity']);

Route::post('/location', [App\Http\Controllers\LokasiControllers::class, 'storeloc'])->name('simpan.lokasi');
Route::post('/room', [App\Http\Controllers\LokasiControllers::class, 'storeroom'])->name('simpan.ruang');
Route::post('/locker', [App\Http\Controllers\LokasiControllers::class, 'storelocker'])->name('simpan.lemari');

Route::post('sendsesion', [App\Http\Controllers\TransaksiController::class, 'send'])->name('daftar');
Route::post('kembali', [App\Http\Controllers\TransaksiController::class, 'kembali'])->name('kembali');
