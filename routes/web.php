<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StoreController;

// Homepage route - redirect to login if not authenticated, otherwise to game dashboard
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('game.dashboard');
    }
    return redirect()->route('login');
})->name('homepage');

// Authentication routes
Auth::routes();

// --- AUTHENTICATED ROUTES ONLY ---
Route::middleware(['auth'])->group(function () {
    
    // Home/Dashboard route
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // --- GAME ROUTES ---
    // Game Dashboard (The main view to show stats and actions)
    Route::get('/game', [GameController::class, 'index'])->name('game.dashboard');

    // Core Action: Earn Money
    Route::post('/game/earn', [GameController::class, 'earnMoney'])->name('game.earn');

    // Action: Execute Steal
    Route::post('/game/steal', [GameController::class, 'executeSteal'])->name('game.steal');

    // --- STORE ROUTES ---
    // Store page
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    
    // Store purchases
    Route::post('/store/purchase/steal', [StoreController::class, 'purchaseSteal'])->name('store.purchase.steal');
    Route::post('/store/purchase/auto-earning', [StoreController::class, 'purchaseAutoEarning'])->name('store.purchase.auto-earning');
    Route::post('/store/purchase/treasure-multiplier', [StoreController::class, 'purchaseTreasureMultiplier'])->name('store.purchase.treasure-multiplier');
    Route::post('/store/purchase/lucky-strikes', [StoreController::class, 'purchaseLuckyStrikes'])->name('store.purchase.lucky-strikes');
    Route::post('/store/purchase/counter-attack', [StoreController::class, 'purchaseCounterAttack'])->name('store.purchase.counter-attack');
    Route::post('/store/purchase/shield', [StoreController::class, 'purchaseShield'])->name('store.purchase.shield');
});
