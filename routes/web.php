<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LeaderboardController;
use App\Http\Controllers\Web\SimulationController;
use App\Http\Controllers\Web\SelectionMenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/swagger/docs', function () {
    return view('swagger.index');
});

Route::get('leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::get('selection-menu', [SelectionMenuController::class, 'index'])->name('selection-menu');
Route::post('simulate', [SimulationController::class, 'simulate'])->name('simulate');
