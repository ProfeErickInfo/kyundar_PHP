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

// Dashboard routes (after login) - Note: Add auth middleware when Laravel auth is fully configured
// For now, routes are accessible but views check session data
Route::get('/dam/movil', function () {
    if (!session('idUxer')) {
        return redirect('/');
    }
    return view('dam.movil');
});

Route::get('/dam/desk', function () {
    if (!session('idUxer')) {
        return redirect('/');
    }
    return view('dam.desk');
});
