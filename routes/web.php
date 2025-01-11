<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
require app_path('Modules/Store/Routes/web.php');
