<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatmenuController;
use App\Http\Controllers\CompController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReqstockController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/blank', function () {
//     return view('blank');
// });
// Auth::routes();
Auth::routes([
    'register' => false, // Routes of Registration
    'reset' => false,    // Routes of Password Reset
    'verify' => false,   // Routes of Email Verification
]);
Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/getdata', [HomeController::class, 'getData'])->name('home.getdata');
    Route::get('/home/report', [HomeController::class, 'report'])->name('home.report');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserController::class, 'profileUpdate'])->name('user.profileUpdate');

    Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');
    Route::resource('user', UserController::class)->except('create', 'show', 'destroy');

    Route::get('/table/paginate', [TableController::class, 'paginate'])->name('table.paginate');
    Route::post('/table/change', [TableController::class, 'change'])->name('table.change');
    Route::delete('/table', [TableController::class, 'destroy'])->name('table.destroy');
    Route::resource('table', TableController::class)->except('create', 'show', 'destroy');

    Route::delete('/catmenu', [CatmenuController::class, 'destroy'])->name('catmenu.destroy');
    Route::resource('catmenu', CatmenuController::class)->except('create', 'show', 'destroy');

    Route::get('/menu/paginate', [MenuController::class, 'paginate'])->name('menu.paginate');
    Route::delete('/menu', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::resource('menu', MenuController::class)->except('create', 'show', 'destroy');

    Route::get('/order/{number}/print', [OrderController::class, 'print'])->name('order.print');
    Route::get('/order/lastfive', [OrderController::class, 'lastfive'])->name('order.lastfive');
    Route::post('/order/change', [OrderController::class, 'change'])->name('order.change');
    Route::delete('/order', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::resource('order', OrderController::class)->only('index', 'store', 'edit');

    Route::post('/reqstock/{id}/change', [ReqstockController::class, 'change'])->name('reqstock.change');
    Route::resource('reqstock', ReqstockController::class)->only('index', 'store', 'edit');

    Route::post('/cart/change', [CartController::class, 'change'])->name('cart.change');
    Route::resource('cart', CartController::class)->except('create', 'show');

    Route::get('/company', [CompController::class, 'index'])->name('company.index');
    Route::post('/company', [CompController::class, 'store'])->name('company.store');

    Route::get('/tes', [OrderController::class, 'tes'])->name('tes');
});
