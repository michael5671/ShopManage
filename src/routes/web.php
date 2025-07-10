<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\NewsController;    

Route::get('/', function () {
    return view('welcome');
});


Route::get('/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook');
Route::get('/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);
Route::get('/share-facebook/{id}', [FacebookAuthController::class, 'shareToFacebook'])->name('share-facebook');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//News
Route::get('/news/share/{id}', [NewsController::class, 'sharePage'])->name('news.share'); // giải thích chỗ name
