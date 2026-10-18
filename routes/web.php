<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
Route::get('/', function () {
    return view('welcome');
});
Route::view('/', 'meowmap.index');
Route::view('/login', 'meowmap.login');
Route::view('/admin', 'admin.dashboard')
    ->name('admin.dashboard');
    Route::view('/register', 'meowmap.register')->name('register');


    Route::get('/auth/google/redirect', [
    GoogleAuthController::class,
    'redirect'
])->name('google.redirect');

Route::get('/auth/google/callback', [
    GoogleAuthController::class,
    'callback'
])->name('google.callback');

Route::get('/auth/google/complete', [
    GoogleAuthController::class,
    'complete'
])->name('google.complete');