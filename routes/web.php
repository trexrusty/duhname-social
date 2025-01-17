<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HubsController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.post');
});

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');

    Route::post('/like/{post}', [LikeController::class, 'post_like'])->name('like.post');
    Route::get('/like/{post}', [LikeController::class, 'get_post_likes'])->name('like.post.get');

    Route::get('/hub', [HubsController::class, 'index'])->name('hub.index');
});


Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/social/{post}', [PostController::class, 'show'])->name('social.show');
