<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth::routes();
/* SPA */
Route::get('{path}', function () {
    return view('home');
})->where('path', '(.*)');
/*
DECLARAR LAS RUTAS EN EL ARCHIVO api.php
*/

    
