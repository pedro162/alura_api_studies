<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(Authenticate::class);

Route::get('/login', [App\Http\Controllers\V1\User\Login\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\V1\User\Login\LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [App\Http\Controllers\V1\User\Login\LoginController::class, 'destory'])->name('login.logout');
Route::post('/user/register', [App\Http\Controllers\V1\User\UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [App\Http\Controllers\V1\User\UserController::class, 'store'])->name('user.store');
Route::middleware('authenticator')->group(function () {
    Route::get('/seasons/{season}/episodes', [App\Http\Controllers\EpisodeController::class, 'index'])->name('seasons.episodes.index');
});
