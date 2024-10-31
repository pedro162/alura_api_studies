<?php

use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SerieController;
use App\Models\Episode;
use App\Models\Serie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    //5|h7POFkS059tsHdJIlc2xrfVNsyNvFG7Rn8vL7x9oa2a2bc2b

    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/series', SerieController::class);
    Route::get('/series/{series}/seasons', [SerieController::class, 'seasons'])->name('series.seasons');
    Route::get('/series/{series}/episodes', [SerieController::class, 'episodes'])->name('series.episodes');

    Route::patch('/episodes/{episode}', [EpisodeController::class, 'watched']);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email', 'password']);
    $authorized = Auth::attempt($credentials);

    if (!$authorized)
        return response()->json('Unauthorized', JsonResponse::HTTP_UNAUTHORIZED);

    $user = Auth::user();
    $token = $user->createToken('token');
    return response()->json($token->plainTextToken);
});
