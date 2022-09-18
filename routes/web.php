<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TournamentController::class, 'index'])->name('tournament.index');
Route::get('/fixture/generate', [FixtureController::class, 'generate'])->name('fixture.generate');
Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation.index');
Route::get('/simulation/playNextWeek', [SimulationController::class, 'playNextWeek'])->name('simulation.playnextweek');
Route::get('/simulation/playAllWeeks', [SimulationController::class, 'playAllWeeks'])->name('simulation.playallweeks');
Route::get('/simulation/resetData', [SimulationController::class, 'resetData'])->name('simulation.resetdata');
Route::get('/simulation/result', [SimulationController::class, 'result'])->name('simulation.result');
