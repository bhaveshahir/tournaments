<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;

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
    return view('welcome');
});
Route::get('/', fn () => redirect()->route('tournaments.index'));
Route::resource('tournaments', TournamentController::class);
Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
Route::get('/tournaments/{tournament}/result', [TournamentController::class, 'result'])->name('tournaments.result');
