<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register']);
Route::get('/facebook', [AuthController::class, 'redirectToFacebook']);
Route::get('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
