<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\FrontHomeController;
use App\Http\Controllers\Back\DashboardController;


use App\Http\Controllers\Back\BranchController;
use App\Http\Controllers\Back\WarehouseController;
use App\Http\Controllers\Back\RackController;
use App\Http\Controllers\Back\ItemController;
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


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');



Route::prefix('back')->group(function () {
    Route::resource('branch', BranchController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('rack', RackController::class);
    Route::resource('item', ItemController::class);
});
