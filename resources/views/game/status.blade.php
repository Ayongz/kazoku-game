@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    📊 Player Status
                </h1>
                <p class="text-muted fs-5">View your character progression and statistics</p>
                <div class="row text-center mt-4">
                    <div class="col-md-4">
                        <div class="badge bg-primary fs-6 px-3 py-2 mb-2">
                            Level {{ $user->level ?? 1 }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="badge bg-success fs-6 px-3 py-2 mb-2">
                            IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="badge bg-warning text-dark fs-6 px-3 py-2 mb-2">
                            {{ $user->treasure }} Treasures
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
                            <h5 class="mb-0">💰 Wealth Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <div class="p-3">
                                        <h3 class="text-primary mb-1">{{ number_format($user->money_earned, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Money Earned</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <h3 class="text-warning mb-1">{{ $user->treasure }}</h3>
                                        <small class="text-muted">Current Treasure</small>
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
                                        <small class="text-muted">Random Boxes</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        @if($user->shield_expires_at && $user->shield_expires_at > now())
                                            <h5 class="text-success mb-1">🛡️ Active</h5>
                                            <small class="text-muted">Shield Protection</small>
                                        @else
                                            <h5 class="text-muted mb-1">🛡️ None</h5>
                                            <small class="text-muted">Shield Protection</small>
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
                            <h5 class="mb-0">⭐ Level & Experience</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-6 border-end">
                                    <div class="p-3">
                                        <h3 class="text-success mb-1">{{ $user->level ?? 1 }}</h3>
                                        <small class="text-muted">Current Level</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <h3 class="text-info mb-1">{{ $user->experience ?? 0 }}</h3>
                                        <small class="text-muted">Total Experience</small>
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
                                    <small class="text-muted">Progress to Level {{ $currentLevel + 1 }}</small>
                                    <small class="text-muted">{{ $expToNext }} EXP needed</small>
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
                            <h5 class="mb-0">🔧 Upgrade Levels</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Steal Level -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="display-6 text-danger mb-2">🗡️</div>
                                        <h4 class="mb-1">{{ $user->steal_level }}</h4>
                                        <small class="text-muted">Steal Level</small>
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
                                        <small class="text-muted">Auto Earning</small>
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
                                        <small class="text-muted">Treasure Multi</small>
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
                                        <small class="text-muted">Treasure Rarity</small>
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
                                        <small class="text-muted">Lucky Strikes</small>
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
                                        <small class="text-muted">Counter Attack</small>
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
                                        <small class="text-muted">Intimidation</small>
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
                                        <small class="text-muted">Fast Recovery</small>
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
                            <h5 class="mb-0">🎯 Random Box Chances</h5>
                        </div>
                        <div class="card-body">
                            @if($user->treasure_rarity_level > 0)
                                <div class="text-center mb-3">
                                    <h3 class="text-warning">{{ $user->getRandomBoxChance() }}%</h3>
                                    <p class="text-muted mb-0">Chance per treasure opened</p>
                                    @php
                                        $rarityNames = \App\Models\User::getTreasureRarityNames();
                                        $currentRarity = $rarityNames[$user->treasure_rarity_level] ?? 'Unknown';
                                    @endphp
                                    <small class="text-info">Current: {{ $currentRarity }} Treasure</small>
                                </div>
                            @else
                                <div class="text-center">
                                    <h4 class="text-muted">0%</h4>
                                    <p class="text-muted">No random box chance</p>
                                    <small class="text-warning">Upgrade treasure rarity to get random boxes!</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-gradient-secondary text-white">
                            <h5 class="mb-0">🕐 Shield Status</h5>
                        </div>
                        <div class="card-body">
                            @if($user->shield_expires_at && $user->shield_expires_at > now())
                                @php
                                    $timeLeft = $user->shield_expires_at->diffInMinutes(now());
                                    $hours = floor($timeLeft / 60);
                                    $minutes = $timeLeft % 60;
                                @endphp
                                <div class="text-center">
                                    <h3 class="text-success">🛡️ ACTIVE</h3>
                                    <p class="text-muted mb-0">Protected from theft</p>
                                    <small class="text-success">{{ $hours }}h {{ $minutes }}m remaining</small>
                                </div>
                            @else
                                <div class="text-center">
                                    <h4 class="text-muted">🛡️ INACTIVE</h4>
                                    <p class="text-muted mb-0">Vulnerable to theft</p>
                                    <small class="text-warning">Purchase shield protection from store</small>
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
                        Dashboard
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('store.index') }}" class="btn btn-success w-100">
                        <i class="fas fa-store me-2"></i>
                        Store
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('game.inventory') }}" class="btn btn-info w-100">
                        <i class="fas fa-box me-2"></i>
                        Inventory
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <button onclick="location.reload()" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh
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
</style>
@endsection