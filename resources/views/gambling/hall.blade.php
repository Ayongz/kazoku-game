@extends('layouts.app')

@section('content')
<style>
.rare-treasure-indicator {
    font-size: 0.8em;
    padding: 2px 6px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    border-radius: 12px;
    color: #333;
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
    animation: rareTreasureGlow 2s ease-in-out infinite alternate;
}

@keyframes rareTreasureGlow {
    from { box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3); }
    to { box-shadow: 0 4px 16px rgba(255, 215, 0, 0.6); }
}

.text-purple {
    color: #7c3aed !important;
}

/* Enhanced text visibility */
.gambling-text-enhanced {
    color: #ffffff !important;
    font-weight: 600 !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8) !important;
}

.gambling-description {
    color: #f8f9fa !important;
    font-weight: 500 !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7) !important;
    line-height: 1.4 !important;
}

.gambling-small-text {
    color: #e9ecef !important;
    font-weight: 500 !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8) !important;
}

/* Fix for bet amount buttons to ensure they are clickable */
.btn-outline-light {
    position: relative !important;
    z-index: 10 !important;
    pointer-events: auto !important;
    cursor: pointer !important;
    user-select: none !important;
}

/* === RPG THEME STYLING === */

/* Main Container Background */
.rpg-dashboard-container {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #1a1a2e 75%, #16213e 100%);
    background-size: 400% 400%;
    animation: backgroundShift 20s ease-in-out infinite;
}

.rpg-dashboard-container::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
        radial-gradient(1px 1px at 90px 40px, rgba(147,51,234,0.4), transparent),
        radial-gradient(1px 1px at 130px 80px, rgba(34,197,94,0.3), transparent),
        radial-gradient(2px 2px at 160px 30px, rgba(239,68,68,0.3), transparent);
    background-repeat: repeat;
    background-size: 200px 100px;
    animation: floatingStars 25s linear infinite;
    pointer-events: none;
    z-index: 1;
}

@keyframes backgroundShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 50%; }
    50% { background-position: 100% 100%; }
    75% { background-position: 0% 100%; }
}

@keyframes floatingStars {
    0% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-10px) translateX(5px); }
    50% { transform: translateY(0px) translateX(-5px); }
    75% { transform: translateY(5px) translateX(5px); }
    100% { transform: translateY(0px) translateX(0px); }
}

.rpg-dashboard-container > .container {
    position: relative;
    z-index: 2;
}

/* RPG Panels */
.rpg-panel {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-radius: 15px;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.1),
        0 0 20px rgba(59, 130, 246, 0.1);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.rpg-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.05) 50%, transparent 70%);
    pointer-events: none;
}

.panel-main {
    border-color: rgba(59, 130, 246, 0.4);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.15),
        0 0 25px rgba(59, 130, 246, 0.2);
}

.panel-class {
    border-color: rgba(147, 51, 234, 0.4);
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.1),
        0 0 20px rgba(147, 51, 234, 0.15);
}

/* RPG Titles */
.rpg-title {
    font-family: 'Cinzel', serif;
    font-weight: 600;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    letter-spacing: 1px;
}

/* Store Title */
.store-title-container {
    position: relative;
    display: inline-block;
}

.store-title-container .rpg-title {
    background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: titleShimmer 3s ease-in-out infinite;
    font-size: 3rem;
    font-weight: 700;
    text-shadow: none;
}

@keyframes titleShimmer {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.title-decoration {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 3px;
    background: linear-gradient(90deg, transparent, #3b82f6, #8b5cf6, #ec4899, transparent);
    border-radius: 2px;
    animation: decorationGlow 2s ease-in-out infinite alternate;
}

@keyframes decorationGlow {
    from { box-shadow: 0 0 10px rgba(59, 130, 246, 0.5); }
    to { box-shadow: 0 0 20px rgba(236, 72, 153, 0.8); }
}

/* RPG Buttons */
.rpg-button {
    position: relative;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.rpg-button-content {
    position: relative;
    z-index: 2;
}

.rpg-button-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.rpg-button:hover .rpg-button-glow {
    left: 100%;
}

.rpg-button-primary {
    background: linear-gradient(45deg, #dc2626, #ef4444);
    color: white;
}

.rpg-button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
}

.rpg-button-legendary {
    background: linear-gradient(45deg, #d97706, #f59e0b);
    color: white;
}

.rpg-button-legendary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
}

.rpg-button-epic {
    background: linear-gradient(45deg, #7c3aed, #a855f7);
    color: white;
}

.rpg-button-epic:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
}

.rpg-button-large {
    padding: 15px 30px;
    font-size: 1.1rem;
}

/* RPG Stat Cards */
.rpg-stat-value {
    font-family: 'Orbitron', monospace;
    font-weight: 700;
    font-size: 1.8rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

/* RPG Notifications */
.rpg-notification {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: white;
}

.rpg-notification-success {
    border-color: rgba(34, 197, 94, 0.4);
    box-shadow: 0 10px 25px rgba(34, 197, 94, 0.2);
}

.rpg-notification-error {
    border-color: rgba(239, 68, 68, 0.4);
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.2);
}

.rpg-notification-lose {
    border-color: rgba(251, 146, 60, 0.4);
    box-shadow: 0 10px 25px rgba(251, 146, 60, 0.2);
}

.rpg-notification-icon {
    font-size: 1.5rem;
    margin-right: 15px;
    flex-shrink: 0;
}

.rpg-notification-success .rpg-notification-icon {
    color: #22c55e;
}

.rpg-notification-error .rpg-notification-icon {
    color: #ef4444;
}

.rpg-notification-lose .rpg-notification-icon {
    color: #fb923c;
}

.rpg-notification-content {
    flex: 1;
}

.rpg-notification-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 5px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
}

.rpg-notification-message {
    font-size: 0.95rem;
    opacity: 0.9;
    line-height: 1.4;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
}

.rpg-notification-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 5px;
    margin-left: 15px;
    opacity: 0.7;
    transition: opacity 0.3s ease;
    flex-shrink: 0;
}

.rpg-notification-close:hover {
    opacity: 1;
}

/* Notification Animations */
.rpg-notification {
    animation: slideInFromTop 0.5s ease-out;
}

@keyframes slideInFromTop {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Additional spacing for notifications */
.rpg-notification.mb-4 {
    margin-bottom: 1.5rem !important;
    z-index: 1000;
    position: relative;
}

.rpg-locked-feature {
    opacity: 0.7;
}

/* Betting amount quick buttons */
.btn-outline-light {
    border-color: rgba(255, 255, 255, 0.5);
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.8);
    color: white;
}

.input-group-text {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}
</style>

<div class="rpg-dashboard-container">
    <!-- RPG Background Elements -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                
                <!-- RPG Header -->
                <div class="rpg-header text-center mb-5">
                    <div class="store-title-container">
                        <h1 class="rpg-title">
                            <i class="fas fa-dice me-3"></i>{{ __('nav.gambling_hall') }}
                        </h1>
                        <div class="title-decoration"></div>
                    </div>
                </div>

                <!-- RPG Status Messages -->
                @if (session('success'))
                    <div class="rpg-notification rpg-notification-success mb-4">
                        <div class="rpg-notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="rpg-notification-content">
                            <div class="rpg-notification-title">{{ __('nav.success') }}</div>
                            <div class="rpg-notification-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="rpg-notification-close" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                @if (session('lose'))
                    <div class="rpg-notification rpg-notification-lose mb-4">
                        <div class="rpg-notification-icon">
                            <i class="fas fa-frown"></i>
                        </div>
                        <div class="rpg-notification-content">
                            <div class="rpg-notification-title">{{ __('nav.lose') }}</div>
                            <div class="rpg-notification-message">{{ session('lose') }}</div>
                        </div>
                        <button type="button" class="rpg-notification-close" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="rpg-notification rpg-notification-error mb-4">
                        <div class="rpg-notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="rpg-notification-content">
                            <div class="rpg-notification-title">{{ __('nav.error') }}</div>
                            <div class="rpg-notification-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="rpg-notification-close" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <!-- Gambling Stats Panel -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="rpg-panel panel-main">
                            <div class="panel-content p-4">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <h3 class="rpg-title mb-2" style="color: white;">
                                            <i class="fas fa-chart-line me-2 text-warning"></i>{{ __('gambling.level') }}
                                        </h3>
                                        <h2 class="rpg-stat-value text-warning">{{ $user->gambling_level }}</h2>
                                        <small class="gambling-small-text">EXP: {{ $user->gambling_exp }}/100</small>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h3 class="rpg-title mb-2" style="color: white;">
                                            <i class="fas fa-coins me-2 text-success"></i>{{ __('gambling.max_bet') }}
                                        </h3>
                                        <h2 class="rpg-stat-value text-success">IDR {{ number_format($maxBetAmount) }}</h2>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h3 class="rpg-title mb-2" style="color: white;">
                                            <i class="fas fa-clock me-2 text-info"></i>{{ __('gambling.attempts') }}
                                        </h3>
                                        <h2 class="rpg-stat-value text-info">{{ $remainingAttempts }}/{{ $maxDailyAttempts }}</h2>
                                        <small class="gambling-small-text">{{ __('gambling.remaining_today') }}</small>
                                        <small class="text-warning d-block mt-1" style="font-size: 0.7rem;">
                                            Used {{ $user->gambling_attempts_today }} | Max {{ $maxDailyAttempts }}
                                        </small>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <h3 class="rpg-title mb-2" style="color: white;">
                                            <i class="fas fa-wallet me-2 text-primary"></i>{{ __('gambling.your_money') }}
                                        </h3>
                                        <h2 class="rpg-stat-value text-primary">IDR {{ number_format($user->money_earned) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gambling Games -->
                <div class="row">
                    <!-- Dice Duel -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="rpg-panel panel-class position-relative overflow-hidden h-100">
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0.05; background: radial-gradient(circle at 50% 50%, #dc2626 0%, transparent 70%);"></div>
                            
                            <div class="panel-content p-4">
                                <div class="text-center">
                                    <h3 class="rpg-title gambling-text-enhanced mb-3">
                                        <i class="fas fa-dice me-2 text-danger"></i>{{ __('gambling.dice_duel') }}
                                    </h3>
                                    <p class="gambling-description mb-4">
                                        {{ __('gambling.dice_duel_desc') }}
                                    </p>
                                    
                                    @if($canGamble)
                                        <form action="{{ route('gambling.dice-duel') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label gambling-text-enhanced">{{ __('gambling.bet_amount') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">IDR</span>
                                                    <input type="number" name="bet_amount" class="form-control" 
                                                        min="10000" max="{{ $maxBetAmount }}" value="10000" step="500"
                                                        id="diceBetAmount">
                                                </div>
                                                <small class="text-white mt-1 d-block">
                                                    {{ __('gambling.bet_range') }}: IDR 10,000 - IDR {{ number_format($maxBetAmount) }}
                                                </small>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light me-1" onclick="setBetAmount('diceBetAmount', 10000)">Min</button>
                                                    <button type="button" class="btn btn-sm btn-outline-light me-1" onclick="setBetAmount('diceBetAmount', {{ $maxBetAmount }})">Max</button>
                                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="setBetAmount('diceBetAmount', {{ intval((10000 + $maxBetAmount) / 2) }})">Mid</button>
                                                </div>
                                            </div>
                                            <button type="submit" class="rpg-button rpg-button-primary rpg-button-large">
                                                <div class="rpg-button-content">
                                                    <i class="fas fa-dice me-2"></i>{{ __('gambling.play_now') }}
                                                </div>
                                                <div class="rpg-button-glow"></div>
                                            </button>
                                        </form>
                                    @else
                                        <div class="rpg-locked-feature">
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-lock me-1"></i>
                                                @if($user->money_earned < 10000)
                                                    {{ __('gambling.insufficient_money') }}
                                                @else
                                                    {{ __('gambling.no_attempts_left') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treasure Fusion Gamble -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="rpg-panel panel-class position-relative overflow-hidden h-100">
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0.05; background: radial-gradient(circle at 50% 50%, #d97706 0%, transparent 70%);"></div>
                            
                            <div class="panel-content p-4">
                                <div class="text-center">
                                    <h3 class="rpg-title gambling-text-enhanced mb-3">
                                        <i class="fas fa-magic me-2 text-warning"></i>{{ __('gambling.treasure_fusion') }}
                                    </h3>
                                    <p class="gambling-description mb-4">
                                        {{ __('gambling.treasure_fusion_desc') }}
                                    </p>
                                    
                                    <div class="mb-3">
                                        <p class="gambling-description">
                                            <strong>{{ __('gambling.cost') }}:</strong> 3 {{ __('nav.treasure') }} + IDR 1,000<br>
                                            <strong>{{ __('gambling.success_rate') }}:</strong> 35%<br>
                                            <strong>{{ __('gambling.reward') }}:</strong> 1 {{ __('gambling.rare_treasure') }}
                                        </p>
                                    </div>
                                    
                                    @if($user->treasure >= 3 && $user->money_earned >= 1000 && $remainingAttempts > 0)
                                        <form action="{{ route('gambling.treasure-fusion') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rpg-button rpg-button-legendary rpg-button-large">
                                                <div class="rpg-button-content">
                                                    <i class="fas fa-magic me-2"></i>{{ __('gambling.fusion_now') }}
                                                </div>
                                                <div class="rpg-button-glow"></div>
                                            </button>
                                        </form>
                                    @else
                                        <div class="rpg-locked-feature">
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-lock me-1"></i>
                                                @if($user->treasure < 3)
                                                    {{ __('gambling.need_treasures') }}
                                                @elseif($user->money_earned < 1000)
                                                    {{ __('gambling.need_money') }}
                                                @else
                                                    {{ __('gambling.no_attempts_left') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Flip -->
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="rpg-panel panel-class position-relative overflow-hidden h-100">
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0.05; background: radial-gradient(circle at 50% 50%, #7c3aed 0%, transparent 70%);"></div>
                            
                            <div class="panel-content p-4">
                                <div class="text-center">
                                    <h3 class="rpg-title gambling-text-enhanced mb-3">
                                        <i class="fas fa-play me-2 text-purple"></i>{{ __('gambling.card_flip') }}
                                    </h3>
                                    <p class="gambling-description mb-4">
                                        {{ __('gambling.card_flip_desc') }}
                                    </p>
                                    
                                    @if($canGamble)
                                        <form action="{{ route('gambling.card-flip') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label gambling-text-enhanced">{{ __('gambling.bet_amount') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">IDR</span>
                                                    <input type="number" name="bet_amount" class="form-control" 
                                                           min="10000" max="{{ $maxBetAmount }}" value="10000" step="500"
                                                           id="cardBetAmount">
                                                </div>
                                                <small class="text-white mt-1 d-block">
                                                    {{ __('gambling.bet_range') }}: IDR 10,000 - IDR {{ number_format($maxBetAmount) }}
                                                </small>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-light me-1" onclick="setBetAmount('cardBetAmount', 10000)">Min</button>
                                                    <button type="button" class="btn btn-sm btn-outline-light me-1" onclick="setBetAmount('cardBetAmount', {{ $maxBetAmount }})">Max</button>
                                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="setBetAmount('cardBetAmount', {{ intval((10000 + $maxBetAmount) / 2) }})">Mid</button>
                                                </div>
                                            </div>
                                            <button type="submit" class="rpg-button rpg-button-epic rpg-button-large">
                                                <div class="rpg-button-content">
                                                    <i class="fas fa-play me-2"></i>{{ __('gambling.flip_card') }}
                                                </div>
                                                <div class="rpg-button-glow"></div>
                                            </button>
                                        </form>
                                    @else
                                        <div class="rpg-locked-feature">
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-lock me-1"></i>
                                                @if($user->money_earned < 10000)
                                                    {{ __('gambling.insufficient_money') }}
                                                @else
                                                    {{ __('gambling.no_attempts_left') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Panel -->
                <div class="row">
                    <div class="col-12">
                        <div class="rpg-panel panel-main">
                            <div class="panel-content p-4">
                                <h3 class="rpg-title mb-3" style="color: white;">
                                    <i class="fas fa-info-circle me-2 text-info"></i>{{ __('gambling.rules') }}
                                </h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="gambling-description">
                                            <li>{{ __('gambling.rule_1') }}</li>
                                            <li>{{ __('gambling.rule_2') }}</li>
                                            <li>{{ __('gambling.rule_3') }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="gambling-description">
                                            <li>{{ __('gambling.rule_4') }}</li>
                                            <li>{{ __('gambling.rule_5') }}</li>
                                            <li>{{ __('gambling.rule_6') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<script>
function setBetAmount(inputId, amount) {
    console.log('setBetAmount called with:', inputId, amount); // Debug log
    const input = document.getElementById(inputId);
    if (input) {
        input.value = amount;
        console.log('Set value to:', amount); // Debug log
        
        // Trigger input event to ensure any listeners are notified
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    } else {
        console.error('Input element not found:', inputId); // Debug log
    }
}

// Test function on page load and add backup event listeners
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, testing setBetAmount function...');
    const diceInput = document.getElementById('diceBetAmount');
    const cardInput = document.getElementById('cardBetAmount');
    console.log('Dice input found:', !!diceInput);
    console.log('Card input found:', !!cardInput);
    
    // Add backup event listeners for dice betting buttons
    const diceBtns = document.querySelectorAll('[onclick*="diceBetAmount"]');
    diceBtns.forEach((btn, index) => {
        const amounts = [10000, {{ $maxBetAmount }}, {{ intval((10000 + $maxBetAmount) / 2) }}];
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Button clicked via event listener:', amounts[index]);
            setBetAmount('diceBetAmount', amounts[index]);
        });
    });
    
    // Add backup event listeners for card betting buttons  
    const cardBtns = document.querySelectorAll('[onclick*="cardBetAmount"]');
    cardBtns.forEach((btn, index) => {
        const amounts = [10000, {{ $maxBetAmount }}, {{ intval((10000 + $maxBetAmount) / 2) }}];
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Button clicked via event listener:', amounts[index]);
            setBetAmount('cardBetAmount', amounts[index]);
        });
    });
});
</script>
@endsection