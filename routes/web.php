<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AffiliateLinksController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/affiliate_links/fetch', [AffiliateLinksController::class, 'fetch'])->name('affiliate_links.fetch');
    Route::resource('/affiliate_links', AffiliateLinksController::class)->except(['create', 'edit']);

    Route::group([
        'prefix' => 'admin',
        'name' => 'admin.',
        'middleware' => [AdminMiddleware::class]
    ], function () {
        Route::get('/users/fetch', [UsersController::class, 'fetch'])->name('users.fetch');
        Route::resource('users', UsersController::class);
    });
});
