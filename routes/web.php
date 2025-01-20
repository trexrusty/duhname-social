<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HubsController;
use App\Http\Controllers\CommentController;

Route::get('/social/{post}', [PostController::class, 'show'])->name('social.show');


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.post');
});

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');

    Route::post('/post/like/{post}', [LikeController::class, 'post_like'])->name('like.post');

    Route::post('/comment/like/{comment}', [LikeController::class, 'like_comment'])->name('like.comment');

    Route::post('/social/{post}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/hub', [HubsController::class, 'index'])->name('hub.index');
});


Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/load-more', [IndexController::class, 'loadMore'])->name('load.more');

Route::get('/post', [PostController::class, 'get_posts'])->name('post.get');
