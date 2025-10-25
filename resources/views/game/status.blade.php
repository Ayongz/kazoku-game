@extends('layouts.app')

@section('content')
<!-- RPG Status Interface -->
<div class="rpg-status-container">
    <!-- Animated Background -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
            <div class="text-center mb-4">
                <h1 class="fw-bold display-5" style="color: white;">{{ __('nav.status_page_title') }}</h1>
            </div>
            <div class="text-center mb-3">
                <!-- Player Profile Section - Optimized -->
                <div class="player-profile-card-compact mb-3">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                        <div class="player-avatar-compact">
                            <img src="{{ \App\Http\Controllers\ProfileController::getProfilePictureUrl($user) }}" 
                                 alt="{{ $user->name }}" class="player-profile-avatar-small">
                        </div>
                        <div class="player-info text-center">
                            <h2 class="fw-bold text-dark mb-1">{{ $user->name }}</h2>
                            <p class="text-muted mb-2 small">{{ __('nav.character_progression') }}</p>
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Change Avatar
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats Row - Compact -->
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="badge bg-primary px-2 py-1 w-100">
                            <small>{{ __('nav.level') }} {{ $user->level ?? 1 }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="badge bg-success px-2 py-1 w-100">
                            <small>IDR {{ number_format($user->money_earned, 0, ',', '.') }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="badge bg-warning text-dark px-2 py-1 w-100">
                            <small>{{ $user->treasure }} {{ __('nav.treasures') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wealth & Level Stats -->
            <div class="row g-4 mb-4">
                <!-- Wealth Stats -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient-primary text-white">
                            <h5 class="mb-0">💰 {{ __('nav.wealth_statistics') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <div class="p-3">
                                        <h3 class="text-primary mb-1">{{ number_format($user->money_earned, 0, ',', '.') }}</h3>
                                        <small class="text-muted">{{ __('nav.money_earned') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <h3 class="text-warning mb-1">{{ $user->treasure }}</h3>
                                        <small class="text-muted">{{ __('nav.treasure_found') }}</small>
                                        <br>
                                        <small class="text-info">Max: {{ 20 + ($user->treasure_multiplier_level * 5) }}</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <div class="p-3">
                                        <h5 class="text-info mb-1">{{ $user->randombox ?? 0 }}</h5>
                                        <small class="text-muted">{{ __('nav.random_boxes') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        @if($user->shield_expires_at && $user->shield_expires_at > now())
                                            <h5 class="text-success mb-1">🛡️ {{ __('nav.active') }}</h5>
                                            <small class="text-muted">{{ __('nav.shield_protection') }}</small>
                                        @else
                                            <h5 class="text-muted mb-1">🛡️ {{ __('nav.none') }}</h5>
                                            <small class="text-muted">{{ __('nav.shield_protection') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Level & Experience Stats -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient-success text-white">
                            <h5 class="mb-0">⭐ {{ __('nav.level_statistics') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-6 border-end">
                                    <div class="p-3">
                                        <h3 class="text-success mb-1">{{ $user->level ?? 1 }}</h3>
                                        <small class="text-muted">{{ __('nav.current_level') }}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <h3 class="text-info mb-1">{{ $user->experience ?? 0 }}</h3>
                                        <small class="text-muted">{{ __('nav.current_experience') }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            @php
                                use App\Services\ExperienceService;
                                $currentLevel = $user->level ?? 1;
                                $currentExp = $user->experience ?? 0;
                                $expToNext = ExperienceService::getExpToNextLevel($currentExp, $currentLevel);
                                $progressPercent = ExperienceService::getExpProgressPercentage($currentExp, $currentLevel);
                            @endphp
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">{{ $expToNext }} {{ __('nav.experience_needed') }}</small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progressPercent }}%"></div>
                                </div>
                                <div class="text-center mt-1">
                                    <small class="text-muted">{{ number_format($progressPercent, 1) }}% Complete</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upgrade Levels - Space Optimized -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient-info text-white py-2">
                            <h6 class="mb-0">🔧 {{ __('nav.upgrade_levels') }}</h6>
                        </div>
                        <div class="card-body py-3">
                            <!-- Primary Upgrades -->
                            <div class="row g-2 mb-3">
                                <!-- Steal Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-danger mb-1">🗡️</div>
                                        <h6 class="mb-1">{{ $user->steal_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.steal_level') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-danger" style="width: {{ ($user->steal_level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->steal_level }}/5</small>
                                    </div>
                                </div>

                                <!-- Auto Earning Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-success mb-1">💸</div>
                                        <h6 class="mb-1">{{ $user->auto_earning_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.auto_earning') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-success" style="width: {{ ($user->auto_earning_level / 20) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->auto_earning_level }}/20</small>
                                    </div>
                                </div>

                                <!-- Treasure Multiplier Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-warning mb-1">💎</div>
                                        <h6 class="mb-1">{{ $user->treasure_multiplier_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.treasure_multi') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-warning" style="width: {{ ($user->treasure_multiplier_level / 10) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->treasure_multiplier_level }}/10</small>
                                    </div>
                                </div>

                                <!-- Treasure Rarity Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-purple mb-1">🎁</div>
                                        <h6 class="mb-1">{{ $user->treasure_rarity_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.treasure_rarity') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-purple" style="width: {{ ($user->treasure_rarity_level / 7) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->treasure_rarity_level }}/7</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Secondary Upgrades -->
                            <div class="row g-2">
                                <!-- Lucky Strikes Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-primary mb-1">⚡</div>
                                        <h6 class="mb-1">{{ $user->lucky_strikes_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.lucky_strikes') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-primary" style="width: {{ ($user->lucky_strikes_level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->lucky_strikes_level }}/5</small>
                                    </div>
                                </div>

                                <!-- Counter Attack Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-dark mb-1">🛡️</div>
                                        <h6 class="mb-1">{{ $user->counter_attack_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.counter_attack') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-dark" style="width: {{ ($user->counter_attack_level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->counter_attack_level }}/5</small>
                                    </div>
                                </div>

                                <!-- Intimidation Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-secondary mb-1">😱</div>
                                        <h6 class="mb-1">{{ $user->intimidation_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.intimidation') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-secondary" style="width: {{ ($user->intimidation_level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->intimidation_level }}/5</small>
                                    </div>
                                </div>

                                <!-- Fast Recovery Level -->
                                <div class="col-6 col-md-3">
                                    <div class="upgrade-card-compact text-center p-2 border rounded">
                                        <div class="fs-4 text-info mb-1">💨</div>
                                        <h6 class="mb-1">{{ $user->fast_recovery_level }}</h6>
                                        <small class="text-muted d-block">{{ __('nav.fast_recovery') }}</small>
                                        <div class="progress mt-1" style="height: 3px;">
                                            <div class="progress-bar bg-info" style="width: {{ ($user->fast_recovery_level / 5) * 100 }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $user->fast_recovery_level }}/5</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Treasure Rarity Information -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-warning text-dark">
                            <h5 class="mb-0">🎯 {{ __('nav.random_box_chance') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($user->treasure_rarity_level > 0)
                                <div class="text-center mb-3">
                                    <h3 class="text-warning">{{ $user->getRandomBoxChance() }}%</h3>
                                    <p class="text-muted mb-0">{{ __('nav.chance') }} per treasure opened</p>
                                    @php
                                        $rarityNames = \App\Models\User::getTreasureRarityNames();
                                        $currentRarity = $rarityNames[$user->treasure_rarity_level] ?? 'Unknown';
                                    @endphp
                                    <small class="text-info">{{ __('nav.current_treasure') }}: {{ $currentRarity }} Treasure</small>
                                </div>
                            @else
                                <div class="text-center">
                                    <h4 class="text-muted">0%</h4>
                                    <p class="text-muted">{{ __('nav.no_random_box_chance') }}</p>
                                    <small class="text-warning">{{ __('nav.upgrade_for_boxes') }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-secondary text-white">
                            <h5 class="mb-0">🕐 {{ __('nav.shield_status') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($user->shield_expires_at && $user->shield_expires_at > now())
                                @php
                                    $timeLeft = $user->shield_expires_at->diffInMinutes(now());
                                    $hours = floor($timeLeft / 60);
                                    $minutes = $timeLeft % 60;
                                @endphp
                                <div class="text-center">
                                    <h3 class="text-success">🛡️ {{ __('nav.active') }}</h3>
                                    <p class="text-muted mb-0">{{ __('nav.protected_from_theft') }}</p>
                                    <small class="text-success">{{ $hours }}h {{ $minutes }}m {{ __('nav.remaining_time') }}</small>
                                </div>
                            @else
                                <div class="text-center">
                                    <h4 class="text-muted">🛡️ {{ __('nav.inactive') }}</h4>
                                    <p class="text-muted mb-0">{{ __('nav.vulnerable_to_theft') }}</p>
                                    <small class="text-warning">{{ __('nav.purchase_shield_store') }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== RPG STATUS INTERFACE STYLES ===== */

/* Background & Container */
.rpg-status-container {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, 
        #1a1f2e 0%, 
        #2d3748 25%, 
        #1a202c 50%, 
        #2a4365 75%, 
        #1a1f2e 100%
    );
    background-attachment: fixed;
    overflow-x: hidden;
    padding-top: 0;
    margin-top: 0;
}

.rpg-background {
    position: fixed;
    top: 80px; /* Start below the navigation bar */
    left: 0;
    width: 100%;
    height: calc(100% - 80px); /* Adjust height to account for nav */
    pointer-events: none;
    z-index: -1;
    overflow: hidden;
    background: 
        radial-gradient(circle at 20% 80%, rgba(59,130,246,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(139,92,246,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(245,158,11,0.08) 0%, transparent 50%),
        linear-gradient(135deg, 
            rgba(30,41,59,0.8) 0%, 
            rgba(45,55,72,0.9) 25%, 
            rgba(26,32,44,0.95) 50%, 
            rgba(42,67,101,0.9) 75%, 
            rgba(30,41,59,0.8) 100%
        );
}

/* Animated Particles */
.floating-particles::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
        radial-gradient(1px 1px at 90px 40px, rgba(139,92,246,0.4), transparent),
        radial-gradient(3px 3px at 160px 30px, rgba(16,185,129,0.2), transparent);
    background-repeat: repeat;
    background-size: 200px 100px;
    animation: mysticFloat 15s linear infinite;
    opacity: 0.6;
}

.floating-particles::after {
    content: '';
    position: absolute;
    width: 4px;
    height: 4px;
    background: #ffd700;
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
    box-shadow: 0 0 10px #ffd700;
    top: 60%;
    right: 15%;
    animation-delay: 3s;
}

@keyframes mysticFloat {
    0% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-10px) translateX(5px); }
    50% { transform: translateY(-20px) translateX(0px); }
    75% { transform: translateY(-10px) translateX(-5px); }
    100% { transform: translateY(0px) translateX(0px); }
}

.magic-orbs::before,
.magic-orbs::after {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    background: radial-gradient(circle, #00d4ff 0%, #0099cc 100%);
    border-radius: 50%;
    animation: orbit 8s linear infinite;
    box-shadow: 0 0 15px #00d4ff;
}

.magic-orbs::before {
    top: 30%;
    right: 10%;
}

.magic-orbs::after {
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes orbit {
    0% { transform: rotate(0deg) translateX(50px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(50px) rotate(-360deg); }
}

.energy-waves::before,
.energy-waves::after {
    content: '';
    position: absolute;
    width: 100px;
    height: 100px;
    border: 2px solid rgba(255, 193, 7, 0.3);
    border-radius: 50%;
    animation: energyPulse 4s ease-in-out infinite;
}

.energy-waves::before {
    top: 40%;
    left: 30%;
    animation-delay: 0s;
}

.energy-waves::after {
    bottom: 30%;
    right: 25%;
    animation-delay: 2s;
    border-color: rgba(139, 92, 246, 0.3);
}

@keyframes energyPulse {
    0%, 100% { 
        transform: scale(0.8);
        opacity: 0.4;
    }
    50% { 
        transform: scale(1.2);
        opacity: 0.8;
    }
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Ensure navigation doesn't get affected */
.container {
    position: relative;
    z-index: 10;
}

.navbar {
    position: relative;
    z-index: 1000 !important;
}

/* Original Status Styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
}

.text-purple {
    color: #6f42c1;
}

.bg-purple {
    background-color: #6f42c1;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

/* Player Profile Section */
.player-profile-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6;
}

.player-avatar-container {
    display: inline-block;
    position: relative;
    margin-bottom: 1rem;
}

.player-profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ffffff;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.player-profile-avatar:hover {
    transform: scale(1.05);
}

/* ===== COMPACT OPTIMIZATIONS ===== */

/* Player Profile Compact */
.player-profile-card-compact {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.player-avatar-compact {
    flex-shrink: 0;
}

.player-profile-avatar-small {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #007bff;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    transition: transform 0.3s ease;
}

.player-profile-avatar-small:hover {
    transform: scale(1.1);
}

.player-info h2 {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

/* Upgrade Cards Compact */
.upgrade-card-compact {
    background: rgba(255, 255, 255, 0.95);
    transition: all 0.3s ease;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.upgrade-card-compact:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.upgrade-card-compact .fs-4 {
    font-size: 1.5rem !important;
    line-height: 1;
}

.upgrade-card-compact h6 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.upgrade-card-compact small {
    font-size: 0.7rem;
    line-height: 1.2;
}

.upgrade-card-compact .progress {
    margin-top: 0.25rem;
    margin-bottom: 0.25rem;
    background-color: rgba(0, 0, 0, 0.1);
}

/* Purple color support */
.text-purple {
    color: #6f42c1 !important;
}

.bg-purple {
    background-color: #6f42c1 !important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .player-profile-card {
        padding: 1.5rem;
    }
    
    .player-profile-avatar {
        width: 80px;
        height: 80px;
    }
    
    .player-profile-card-compact {
        padding: 0.75rem;
    }
    
    .player-profile-avatar-small {
        width: 50px;
        height: 50px;
    }
    
    .player-info h2 {
        font-size: 1.25rem;
    }
    
    .upgrade-card-compact {
        min-height: 110px;
        padding: 0.5rem !important;
    }
    
    .upgrade-card-compact .fs-4 {
        font-size: 1.25rem !important;
    }
    
    .upgrade-card-compact h6 {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .upgrade-card-compact {
        min-height: 100px;
    }
    
    .upgrade-card-compact .fs-4 {
        font-size: 1.1rem !important;
    }
    
    .upgrade-card-compact h6 {
        font-size: 0.9rem;
    }
    
    .upgrade-card-compact small {
        font-size: 0.65rem;
    }
}
</style>
@endsection