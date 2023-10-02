<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LokasiControllers;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
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



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('members', App\Http\Controllers\MemberController::class);
    Route::resource('products', ProductController::class);
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('dashboard', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.view');
    Route::post('transactions/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/return-product', [TransactionController::class, 'kembalikanbarang'])->name('transactions.return.product');
    Route::post('/transactions/return', [TransactionController::class, 'kembalikan'])->name('transactions.return');

    Route::get('report/transaction', [ReportController::class, 'transaction'])->name('report.transaction');
    Route::get('report/member', [ReportController::class, 'member'])->name('report.member');

    // Route::get('/',function (){
    //     return view('test');
    // });

});

Route::get('country-state-city', [App\Http\Controllers\LokasiControllers::class, 'index'])->name('location');
Route::post('get-states-by-country', [App\Http\Controllers\LokasiControllers::class, 'getState']);
Route::post('get-cities-by-state', [App\Http\Controllers\LokasiControllers::class, 'getCity']);

Route::post('/location', [App\Http\Controllers\LokasiControllers::class, 'storeloc'])->name('simpan.lokasi');
Route::post('/room', [App\Http\Controllers\LokasiControllers::class, 'storeroom'])->name('simpan.ruang');
Route::post('/locker', [App\Http\Controllers\LokasiControllers::class, 'storelocker'])->name('simpan.lemari');

Route::post('sendsesion', [App\Http\Controllers\TransaksiController::class, 'send'])->name('daftar');
Route::post('kembali', [App\Http\Controllers\TransaksiController::class, 'kembali'])->name('kembali');

Route::get('/search-no-result', [TransactionController::class, 'nosewarch']);
Route::get('/search-member', [TransactionController::class, 'searchmember']);
Route::get('/search-product', [TransactionController::class, 'searchproduct']);
Route::post('/processmember', [TransactionController::class, 'processmember']);
Route::post('/processproduct', [TransactionController::class, 'processproduct']);
