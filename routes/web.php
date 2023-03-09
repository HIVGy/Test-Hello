<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Vista principal
Route::get('/', function () {
    return view('welcome');
});

/* ---------------------------- Usuarios ---------------------------- */

Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);
