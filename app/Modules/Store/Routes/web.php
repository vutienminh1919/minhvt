<?php


use App\Http\Controllers\AuthenController;
use App\Http\Controllers\MenuController;
use App\Modules\Store\Controllers\UserController;
use App\Modules\Store\Controllers\VietQrController;
use Illuminate\Support\Facades\Route;


Route::get('login', [UserController::class, 'showFormLogin'])->name('showFormLogin');
Route::get('/', function () {
    return redirect()->route('users.index');
});

Route::prefix('/users')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('users.index');
    Route::get('/{id}', [UserController::class, 'getUser'])->name('users.getUser');
    Route::post('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/update', [UserController::class, 'update'])->name('users.update');
});

Route::prefix('/menus')->group(function () {
    Route::get('', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/show-form-create', [MenuController::class, 'showFormCreate'])->name('menus.showFormCreate');
    Route::post('/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/change-status', [MenuController::class, 'changeStatus'])->name('menus.changeStatus');
    Route::get('/{id}', [MenuController::class, 'detail'])->name('menus.detail');
    Route::post('/update', [MenuController::class, 'update'])->name('menus.update');
});

Route::prefix('/viet-qr')->group(function () {
    Route::get('create', [VietQrController::class, 'create'])->name('viet-qr.create');
    Route::get('get-banks-list', [VietQrController::class, 'getBankList'])->name('viet-qr.get-bank-list');

});

Route::get('login', function () {
    return view('authen.login');
})->name('login');
Route::post('login', [AuthenController::class, 'login'])->name('authen.login');
