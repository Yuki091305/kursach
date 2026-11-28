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

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');;

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

Route::get('/community', function () {
    return view('community');
})->middleware('auth');

use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'update'])->middleware('auth');

use App\Http\Controllers\SubscriptionController;

Route::get('/subscription', [SubscriptionController::class, 'show'])->middleware('auth')->name('subscription');
Route::post('/subscription', [SubscriptionController::class, 'subscribe'])->middleware('auth');
Route::post('/subscription/cancel', [SubscriptionController::class, 'unsubscribe'])->middleware('auth')->name('subscription.cancel');

use App\Http\Controllers\PostController;

Route::get('/create-post', [PostController::class, 'create'])->middleware('auth')->name('create-post');
Route::post('/create-post', [PostController::class, 'store'])->middleware('auth');
Route::get('/community', [PostController::class, 'community'])->middleware('auth')->name('community');
Route::delete('/post/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('post.destroy');

use App\Http\Controllers\CommentController;

Route::post('/comment', [CommentController::class, 'store'])->middleware('auth')->name('comment.store');
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->middleware('auth')->name('comment.destroy');

use App\Http\Controllers\LikeController;

Route::post('/post/{post}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('like.toggle');
