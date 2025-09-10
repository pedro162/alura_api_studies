<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SerieController;
use App\Http\Middleware\Auth\AuthenticateWithBasicAuth;
use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('can:create, App\Models\User');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->can('update', User::class);
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('can:update,user');
});

Route::get('/profile', function () {
    //
})->middleware('auth:basic');

Route::get('/api/user', function () {
    //Only authenticated users may access this route
})->middleware(AuthenticateWithBasicAuth::class);

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/', function () {});
});

Route::middleware('auth:header')->get('/test-custom-auth-header', fn() => 'Autenticado');

Route::middleware('auth:api_token')->get('/test-custom-auth-token', fn() => 'Autenticado');
Route::get('/mail', function () {
    return new SeriesCreated(
        nomeSerie: 'Série de teste',
        id: 1,
        qtdTemporadas: 3,
        epPorTemporada: 10
    );
});

Route::middleware('auth:header')->group(function () {
    Route::get('/series', [SerieController::class, 'index'])->name('series.index');
    Route::get('/series/{series}/seasons', [SerieController::class, 'seasons'])->name('series.seasons');
});

require __DIR__ . '/auth.php';
