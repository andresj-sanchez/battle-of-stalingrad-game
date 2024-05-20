<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TankController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\SimulationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResources([
        'tanks' => TankController::class,
        'maps' => MapController::class,
        'players' => PlayerController::class,
        'scores' => ScoreController::class,
    ], ['only' => ['index', 'show']]);

    Route::get('leaderboards', [LeaderboardController::class, 'index']);
    Route::post('simulate', [SimulationController::class, 'simulate']);
});