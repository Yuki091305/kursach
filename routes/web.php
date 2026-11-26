<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/history-culture', function () {
    return view('history');
});
Route::get('/angels', function () {
    return view('angels');
});
Route::get('/hierarchies', function () {
    return view('hierarchies');
});
use App\Http\Controllers\AuthController;

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/profile', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    return view('profile');
});
