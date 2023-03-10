<?php

use App\Http\Controllers\MateriasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

//Vista principal
Route::get('/', function () {
    return view('welcome');
});

/* ---------------------------- Usuarios ---------------------------- */

Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);

Route::post('/test', [MateriasController::class, 'store']);

Route::get('/materias', [MateriasController::class, 'list']);
Route::post('/materia', [MateriasController::class, 'store']);
Route::put('/materia', [MateriasController::class, 'update']);
Route::delete('/materia', [MateriasController::class, 'destroy']);

