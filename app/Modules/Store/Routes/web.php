<?php


use App\Modules\Store\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('login', [UserController::class, 'showFormLogin'])->name('showFormLogin');
Route::get('/', [UserController::class, 'index'])->name('index');
//Route::get('users/{id}', [UserController::class, 'show']);
Route::get('test', function(){
    return view('layouts.master');
});
