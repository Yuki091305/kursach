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
