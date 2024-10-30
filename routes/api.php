<?php

use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SerieController;
use App\Models\Episode;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/products', ProductController::class);
Route::apiResource('/series', SerieController::class);
Route::get('/series/{series}/seasons', [SerieController::class, 'seasons'])->name('series.seasons');
Route::get('/series/{series}/episodes', [SerieController::class, 'episodes'])->name('series.episodes');

Route::patch('/episodes/{episode}', [EpisodeController::class, 'watched']);
