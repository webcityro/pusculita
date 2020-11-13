<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AffiliateLinksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/affiliate_links/fetch', [AffiliateLinksController::class, 'fetch'])->name('affiliate_links.fetch');
    Route::resource('/affiliate_links', AffiliateLinksController::class)->except(['create', 'edit']);
});
