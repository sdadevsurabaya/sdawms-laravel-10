<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\FrontHomeController;
use App\Http\Controllers\Back\DashboardController;


use App\Http\Controllers\Back\BranchController;
use App\Http\Controllers\Back\WarehouseController;
use App\Http\Controllers\Back\RackController;
use App\Http\Controllers\Back\ItemController;
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
Route::post('/logout',[FrontHomeController::class, 'logout'])->name('logout');
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
});


/*------------------------------------------
--------------------------------------------
GUDANG Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user.roles:2'])->group(function () {
    Route::get('/gudang/dashboard', function () {
        return "<h1>DASHBOARD GUDANG</h1>";
    })->name('gudang.dashboard');
});





Route::prefix('back')->group(function () {
    Route::resource('branch', BranchController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('rack', RackController::class);
    Route::resource('item', ItemController::class);
});
