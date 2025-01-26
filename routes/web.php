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
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StaffController;
Route::get('/social/{post}', [PostController::class, 'show'])->name('social.show');

Route::get('/api/social/{post}/comments', [CommentController::class, 'getComments'])->name('social.comments');

Route::get('/social/{post}/{comment}', [CommentController::class, 'showComment'])->name('social.comment');

Route::get('/profile/{user:tag}', [UserController::class, 'show'])->name('user.show');

Route::get('/api/profile/{user:tag}', [UserController::class, 'getUser'])->name('user.get');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post')->middleware(['middleware' =>'throttle:10,1']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->name('login.post')->middleware(['middleware' =>'throttle:10,1']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/hub', [HubsController::class, 'index'])->name('hub.index');

});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/report/{post}', [ReportController::class, 'report'])->name('report');

    Route::post('/api/follow/{user}', [FollowController::class, 'follow'])->name('follow');

    Route::post('/post', [PostController::class, 'store'])->name('post.store')->middleware(['middleware' =>'throttle:10,1']);

    Route::post('/post/like/{post}', [LikeController::class, 'post_like'])->name('like.post');

    Route::post('/comment/like/{comment}', [LikeController::class, 'like_comment'])->name('like.comment');

    Route::post('/api/report/comment/{comment}', [ReportController::class, 'report_comment'])->name('report.comment');

    Route::post('/api/report/post/{post}', [ReportController::class, 'report_post'])->name('report.post');

    Route::post('/social/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
});

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/load-more', [IndexController::class, 'loadMore'])->name('load.more');

Route::get('/post', [PostController::class, 'get_posts'])->name('post.get');


Route::group(['middleware' => 'can:view reports'], function () {
    Route::get('/admin/reports', [StaffController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/users', [StaffController::class, 'users'])->name('admin.users');
    Route::get('/admin/user/{user}', [StaffController::class, 'user'])->name('admin.user');
    Route::post('/admin/delete/post/{post}', [StaffController::class, 'delete_post'])->name('admin.delete.post');
    Route::post('/admin/undelete/post/{post}', [StaffController::class, 'undelete_post'])->name('admin.undelete.post');
    Route::post('/admin/delete/comment/{comment}', [StaffController::class, 'delete_comment'])->name('admin.delete.comment');
    Route::post('/admin/undelete/comment/{comment}', [StaffController::class, 'undelete_comment'])->name('admin.undelete.comment');
    Route::post('/admin/ban/user/{user}', [StaffController::class, 'ban_user'])->name('admin.ban.user');
    Route::post('/admin/unban/user/{user}', [StaffController::class, 'unban_user'])->name('admin.unban.user');
    Route::post('/admin/clear/post/report/{post}', [StaffController::class, 'clear_post_report'])->name('admin.clear.post.report');

});
