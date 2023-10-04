<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Models\Post;

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


Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('members', App\Http\Controllers\MemberController::class);
    Route::resource('products', ProductController::class);
    Route::resource('post', PostController::class );
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('dashboard', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.view');
    Route::post('transactions/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/return-product', [TransactionController::class, 'kembalikanbarang'])->name('transactions.return.product');
    Route::post('/transactions/return', [TransactionController::class, 'kembalikan'])->name('transactions.return');

    Route::get('report/transaction', [ReportController::class, 'transaction'])->name('report.transaction');
    Route::get('report/member', [ReportController::class, 'member'])->name('report.member');
    Route::get('report/member/{member}', [ReportController::class, 'memberdetail'])->name('report.member-detail');
    Route::get('report/product', [ReportController::class, 'product'])->name('report.product');

});

Route::get('/', function(){
    return view('welcome', [
        'posts' => Post::paginate(9),
    ]);
});

Route::get('blog/{post}', function(Post $post) {
    $nextPost = Post::where('id', '>', $post->id)->first();
    $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
    return view('blog', compact('post', 'nextPost', 'previousPost'));
})->name('blog.post');

Route::get('daftar', function(){
    return view('auth.register');
})->name('daftar');




Route::get('country-state-city', [App\Http\Controllers\LokasiControllers::class, 'index'])->name('location');
Route::post('get-states-by-country', [App\Http\Controllers\LokasiControllers::class, 'getState']);
Route::post('get-cities-by-state', [App\Http\Controllers\LokasiControllers::class, 'getCity']);

Route::post('/location', [App\Http\Controllers\LokasiControllers::class, 'storeloc'])->name('simpan.lokasi');
Route::post('/room', [App\Http\Controllers\LokasiControllers::class, 'storeroom'])->name('simpan.ruang');
Route::post('/locker', [App\Http\Controllers\LokasiControllers::class, 'storelocker'])->name('simpan.lemari');

Route::get('/search-no-result', [TransactionController::class, 'nosewarch']);
Route::get('/search-member', [TransactionController::class, 'searchmember']);
Route::get('/search-product', [TransactionController::class, 'searchproduct']);
Route::post('/processmember', [TransactionController::class, 'processmember']);
Route::post('/processproduct', [TransactionController::class, 'processproduct']);
