<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IndexController;


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.post');
});

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');
});


Route::get('/', [IndexController::class, 'index'])->name('home');
