<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\FrontHomeController;
use App\Http\Controllers\Back\DashboardController;


use App\Http\Controllers\Back\BranchController;
use App\Http\Controllers\Back\WarehouseController;
use App\Http\Controllers\Back\RackController;
use App\Http\Controllers\Back\ItemController;
use App\Http\Controllers\Back\ScanController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\WmsApiController;
use App\Http\Controllers\Back\RakitanApiController;
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

Route::get('/', [FrontHomeController::class, 'index']);

Route::get('/login', [FrontHomeController::class, 'index'])->name('front.login');
Route::post('/login', [FrontHomeController::class, 'login'])->name('submit.login');
Route::post('/logout', [FrontHomeController::class, 'logout'])->name('logout');
Route::get('/refresh-csrf', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

/*------------------------------------------
--------------------------------------------
ADMIN Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user.roles:1'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('users/{user}/login-as',        [UserController::class, 'loginAs'])->name('users.login-as');
    Route::post('users/leave-impersonation',    [UserController::class, 'leaveImpersonation'])->name('users.leave-impersonation');
});


/*------------------------------------------
--------------------------------------------
GUDANG Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user.roles:2'])->group(function () {
    Route::get('/gudang/dashboard', [DashboardController::class, 'index'])->name('gudang.dashboard');
});





Route::middleware(['auth'])->group(function () {
    Route::get('/back/scan-qr', [ScanController::class, 'index'])->name('scan.qr');
    Route::get('/back/rakitan-data', [RakitanApiController::class, 'getData'])->name('rakitan.data');

    // WMS API Proxy — realtime, tanpa cache
    Route::prefix('api/wms')->name('api.wms.')->group(function () {
        Route::get('/summary',          [WmsApiController::class, 'summary'])->name('summary');
        Route::get('/racks',            [WmsApiController::class, 'allRacks'])->name('racks');
        Route::get('/rack/{code}',      [WmsApiController::class, 'byRack'])->name('rack');
        Route::get('/product/{code}',   [WmsApiController::class, 'byProduct'])->name('product');
    });
});

Route::prefix('back')->group(function () {
    Route::resource('branch', BranchController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('rack', RackController::class);
    Route::resource('item', ItemController::class);
});
