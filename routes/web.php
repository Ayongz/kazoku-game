<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GamblingController;

// Language switching route
Route::get('/language/{language}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

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
    
    // Core Action: Open Rare Treasure
    Route::post('/game/open-rare-treasure', [GameController::class, 'openRareTreasure'])->name('game.open-rare-treasure');

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
    Route::post('/store/purchase/intimidation', [StoreController::class, 'purchaseIntimidation'])->name('store.purchase.intimidation');
    Route::post('/store/purchase/fast-recovery', [StoreController::class, 'purchaseFastRecovery'])->name('store.purchase.fast-recovery');
    Route::post('/store/purchase/treasure-rarity', [StoreController::class, 'purchaseTreasureRarity'])->name('store.purchase.treasure-rarity');
    Route::post('/store/purchase/shield', [StoreController::class, 'purchaseShield'])->name('store.purchase.shield');
    Route::post('/store/purchase/prestige', [StoreController::class, 'purchasePrestige'])->name('store.purchase.prestige');
    
    // --- INVENTORY ROUTES ---
    // Inventory page
    Route::get('/game/inventory', [InventoryController::class, 'index'])->name('game.inventory');
    
    // Open random box
    Route::post('/game/inventory/open-random-box', [InventoryController::class, 'openRandomBox'])->name('game.inventory.open-random-box');
    
    // --- CLASS SYSTEM ROUTES ---
    // Class selection page
    Route::get('/game/class-selection', [GameController::class, 'showClassSelection'])->name('game.class-selection');
    
    // Class path (full tree view)
    Route::get('/game/class-path', [GameController::class, 'showClassPath'])->name('game.class-path');
    
    // Select class
    Route::post('/game/select-class', [GameController::class, 'selectClass'])->name('game.select-class');
    
    // Advance class
    Route::post('/game/advance-class', [GameController::class, 'advanceClass'])->name('game.advance-class');
    
    // --- STATUS ROUTES ---
    // Player status page
    Route::get('/game/status', [StatusController::class, 'index'])->name('game.status');
    
    // --- GUIDE ROUTES ---
    // Game guide page
    Route::get('/game/guide', [GuideController::class, 'index'])->name('game.guide');
    
    // --- PROFILE ROUTES ---
    // Profile management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update-picture');
    
    // --- GAMBLING HALL ROUTES ---
    // Gambling hall main page
    Route::get('/gambling-hall', [GamblingController::class, 'index'])->name('gambling.hall');
    
    // Gambling games
    Route::post('/gambling/dice-duel', [GamblingController::class, 'diceDuel'])->name('gambling.dice-duel');
    Route::post('/gambling/treasure-fusion', [GamblingController::class, 'treasureFusion'])->name('gambling.treasure-fusion');
    Route::post('/gambling/card-flip', [GamblingController::class, 'cardFlip'])->name('gambling.card-flip');
});
