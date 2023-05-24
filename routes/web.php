<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatmenuController;
use App\Http\Controllers\CompController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
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

    Route::group(['middleware' => ['role:admin']], function () {
        Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');
        Route::resource('user', UserController::class)->except('create', 'show', 'destroy');

        Route::delete('/catmenu', [CatmenuController::class, 'destroy'])->name('catmenu.destroy');
        Route::resource('catmenu', CatmenuController::class)->except('index', 'create', 'show', 'destroy');

        Route::delete('/menu', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::resource('menu', MenuController::class)->except('index', 'create', 'show', 'destroy');

        Route::delete('/table', [TableController::class, 'destroy'])->name('table.destroy');
        Route::resource('table', TableController::class)->except('index', 'create', 'show', 'destroy');

        Route::get('/company/general', [CompController::class, 'general'])->name('company.general');
        Route::post('/company/general', [CompController::class, 'generalUpdate'])->name('company.general.update');
        Route::get('/company/social', [CompController::class, 'social'])->name('company.social');
        Route::post('/company/social', [CompController::class, 'socialUpdate'])->name('company.social.update');
        Route::get('/company/image', [CompController::class, 'image'])->name('company.image');
        Route::post('/company/image', [CompController::class, 'imageUpdate'])->name('company.image.update');
        Route::get('/company/other', [CompController::class, 'other'])->name('company.other');
        Route::post('/company/other', [CompController::class, 'otherUpdate'])->name('company.other.update');


        Route::post('/reqstock/{id}/change', [ReqstockController::class, 'change'])->name('reqstock.change');

        Route::get('/report/user', [ReportController::class, 'user'])->name('report.user');
        Route::get('/report/user/data', [ReportController::class, 'data'])->name('report.user.data');
        Route::get('/report/user/peruser', [ReportController::class, 'peruser'])->name('report.user.peruser');
    });

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
    Route::get('/report/getdata', [ReportController::class, 'getData'])->name('report.getdata');
    Route::get('/report/perdate', [ReportController::class, 'perDate'])->name('report.perdate');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/getdata', [HomeController::class, 'getData'])->name('home.getdata');
    Route::get('/home/report', [HomeController::class, 'report'])->name('home.report');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::get('/user/password', [UserController::class, 'password'])->name('user.password');
    Route::post('/user/password', [UserController::class, 'passwordUpdate'])->name('user.password.update');

    Route::get('/table/paginate', [TableController::class, 'paginate'])->name('table.paginate');
    Route::post('/table/change', [TableController::class, 'change'])->name('table.change');
    Route::resource('table', TableController::class)->only('index');

    Route::resource('catmenu', CatmenuController::class)->only('index');

    Route::get('/menu/paginate', [MenuController::class, 'paginate'])->name('menu.paginate');
    Route::resource('menu', MenuController::class)->only('index');

    Route::get('/order/{number}/print', [OrderController::class, 'print'])->name('order.print');
    Route::get('/order/lastfive', [OrderController::class, 'lastfive'])->name('order.lastfive');
    Route::resource('order', OrderController::class)->only('index', 'store', 'edit');

    Route::resource('reqstock', ReqstockController::class)->only('index', 'store', 'edit');

    Route::post('/cart/change', [CartController::class, 'change'])->name('cart.change');
    Route::resource('cart', CartController::class)->except('create', 'show');
});
