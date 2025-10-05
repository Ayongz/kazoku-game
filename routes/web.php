<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

// Route is already defined by Auth::routes() to redirect after login,
// but defining it explicitly here is fine if you modify the destination controller later.
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// --- GAME ROUTES ---
Route::middleware(['auth'])->group(function () {
    // 1. Game Dashboard (The main view to show stats and actions)
    Route::get('/game', [GameController::class, 'index'])->name('game.dashboard');

    // 2. Core Action: Earn Money
    Route::post('/game/earn', [GameController::class, 'earnMoney'])->name('game.earn');

    // 3. Upgrade Action: Purchase Steal Ability
    Route::post('/game/upgrade', [GameController::class, 'purchaseSteal'])->name('game.purchase');

    // 4. Action: Execute Steal
    Route::post('/game/steal', [GameController::class, 'executeSteal'])->name('game.steal');
});