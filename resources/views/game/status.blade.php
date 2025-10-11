@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <!-- Player Profile Section -->
                <div class="player-profile-card mb-4">
                    <div class="player-avatar-container">
                        <img src="{{ \App\Http\Controllers\ProfileController::getProfilePictureUrl($user) }}" 
                             alt="{{ $user->name }}" class="player-profile-avatar">
                    </div>
                    <h1 class="display-4 fw-bold text-dark mb-2">{{ $user->name }}</h1>
                    <p class="text-muted fs-5">{{ __('nav.character_progression') }}</p>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Change Avatar
                    </a>
                </div>
                
                <div class="row text-center mt-4">
                    <div class="col-md-4">
                        <div class="badge bg-primary fs-6 px-3 py-2 mb-2">
                            {{ __('nav.level') }} {{ $user->level ?? 1 }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="badge bg-success fs-6 px-3 py-2 mb-2">
                            IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="badge bg-warning text-dark fs-6 px-3 py-2 mb-2">
                            {{ $user->treasure }} {{ __('nav.treasures') }}
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
                                    <small class="text-muted">{{ __('nav.next_level_at', ['exp' => $currentLevel + 1]) }}</small>
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

            <!-- Upgrade Levels -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient-info text-white">
                            <h5 class="mb-0">🔧 {{ __('nav.upgrade_levels') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Steal Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-danger mb-2">🗡️</div>
                                        <h4 class="mb-1">{{ $user->steal_level }}</h4>
                                        <small class="text-muted">{{ __('nav.steal_level') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-danger" style="width: {{ ($user->steal_level / 5) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->steal_level }}/5</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Auto Earning Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-success mb-2">💸</div>
                                        <h4 class="mb-1">{{ $user->auto_earning_level }}</h4>
                                        <small class="text-muted">{{ __('nav.auto_earning') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-success" style="width: {{ ($user->auto_earning_level / 20) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->auto_earning_level }}/20</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Treasure Multiplier Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-warning mb-2">💎</div>
                                        <h4 class="mb-1">{{ $user->treasure_multiplier_level }}</h4>
                                        <small class="text-muted">{{ __('nav.treasure_multi') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-warning" style="width: {{ ($user->treasure_multiplier_level / 10) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->treasure_multiplier_level }}/10</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Treasure Rarity Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-purple mb-2">🎁</div>
                                        <h4 class="mb-1">{{ $user->treasure_rarity_level }}</h4>
                                        <small class="text-muted">{{ __('nav.treasure_rarity') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-purple" style="width: {{ ($user->treasure_rarity_level / 7) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->treasure_rarity_level }}/7</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Upgrades Row -->
                            <div class="row g-4 mt-2">
                                <!-- Lucky Strikes Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-primary mb-2">⚡</div>
                                        <h4 class="mb-1">{{ $user->lucky_strikes_level }}</h4>
                                        <small class="text-muted">{{ __('nav.lucky_strikes') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-primary" style="width: {{ ($user->lucky_strikes_level / 5) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->lucky_strikes_level }}/5</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Counter Attack Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-dark mb-2">🛡️</div>
                                        <h4 class="mb-1">{{ $user->counter_attack_level }}</h4>
                                        <small class="text-muted">{{ __('nav.counter_attack') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-dark" style="width: {{ ($user->counter_attack_level / 5) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->counter_attack_level }}/5</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Intimidation Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-secondary mb-2">😱</div>
                                        <h4 class="mb-1">{{ $user->intimidation_level }}</h4>
                                        <small class="text-muted">{{ __('nav.intimidation') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
                                                <div class="progress-bar bg-secondary" style="width: {{ ($user->intimidation_level / 5) * 100 }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $user->intimidation_level }}/5</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fast Recovery Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-info mb-2">💨</div>
                                        <h4 class="mb-1">{{ $user->fast_recovery_level }}</h4>
                                        <small class="text-muted">{{ __('nav.fast_recovery') }}</small>
                                        <div class="mt-2">
                                            <div class="progress" style="height: 4px;">
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

            <!-- Quick Actions -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <a href="{{ route('game.dashboard') }}" class="btn btn-primary w-100">
                        <i class="fas fa-gamepad me-2"></i>
                        {{ __('nav.dashboard') }}
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('store.index') }}" class="btn btn-success w-100">
                        <i class="fas fa-store me-2"></i>
                        {{ __('nav.store') }}
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('game.inventory') }}" class="btn btn-info w-100">
                        <i class="fas fa-box me-2"></i>
                        {{ __('nav.inventory') }}
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <button onclick="location.reload()" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync-alt me-2"></i>
                        {{ __('nav.refresh') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

@media (max-width: 768px) {
    .player-profile-card {
        padding: 1.5rem;
    }
    
    .player-profile-avatar {
        width: 80px;
        height: 80px;
    }
}
</style>
@endsection