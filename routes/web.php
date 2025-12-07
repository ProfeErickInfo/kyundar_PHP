<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

// Authentication routes
Route::get('/verificando', [AuthController::class, 'showVerif']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout']);

// Dashboard routes (after login)
Route::get('/dam/movil', function () {
    return view('dam.movil');
});

Route::get('/dam/desk', function () {
    return view('dam.desk');
});
