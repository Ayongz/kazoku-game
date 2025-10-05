@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-5">
                <i class="fas fa-store me-3 text-primary"></i>Game Store
            </h1>

            <!-- Status Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">Success!</p>
                    <p class="mb-0">{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">Error!</p>
                    <p class="mb-0">{{ session('error') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Player Money Card -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card shadow-lg border-start border-5 border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success mb-2">
                                <i class="fas fa-wallet me-2"></i>Your Money
                            </h3>
                            <h2 class="display-5 fw-bold text-dark">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Items -->
            <div class="row g-5">
                
                <!-- 1. AUTO STEAL ABILITY UPGRADE -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-danger text-white text-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-mask me-2"></i>Auto Steal Ability
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                        Level {{ $user->steal_level }} / {{ $maxStealLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->steal_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Auto Steal Success Rate: {{ $user->steal_level * 5 }}%</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Steal Amount: {{ min(1 + ($user->steal_level * 0.8), 5) }}% of target's money</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Triggers automatically when opening treasure</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Works with Lucky Strikes for bonus multipliers</li>
                                    </ul>
                                @else
                                    <p class="text-muted">
                                        Unlock automatic stealing! Every time you open treasure, you'll also attempt to steal from other players as a bonus.
                                    </p>
                                @endif
                            </div>

                            @if ($user->steal_level < $maxStealLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-danger mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Auto Steal Success Rate: {{ ($user->steal_level + 1) * 5 }}%</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Steal Amount: {{ min(1 + (($user->steal_level + 1) * 0.8), 5) }}% of target's money</li>
                                        @if($user->steal_level === 0)
                                            <li><i class="fas fa-arrow-up text-primary me-2"></i>Automatic stealing when opening treasure</li>
                                        @endif
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.steal') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger btn-lg w-100 fw-bold @if($user->money_earned < $stealUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $stealUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($stealUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 fs-md-5 py-2 py-md-3 px-3 px-md-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 2. AUTO EARNING ABILITY UPGRADE -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-warning text-dark text-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-robot me-2"></i>Auto Earning
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        Level {{ $user->auto_earning_level }} / {{ $maxAutoEarningLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->auto_earning_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Auto Earning Rate: {{ $user->auto_earning_level * 0.05 }}% per hour</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Passive income while offline</li>
                                        <li><i class="fas fa-check text-success me-2"></i>No treasure required</li>
                                    </ul>
                                    <div class="alert alert-info">
                                        <small>
                                            <strong>Hourly Income:</strong> 
                                            IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.05 / 100), 0, ',', '.') }}
                                        </small>
                                    </div>
                                @else
                                    <p class="text-muted">
                                        Start earning money automatically! Your current money will generate passive income every hour, even when you're not playing.
                                    </p>
                                @endif
                            </div>

                            @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-warning mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Auto Earning Rate: {{ ($user->auto_earning_level + 1) * 0.05 }}% per hour</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Higher passive income</li>
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.auto-earning') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-warning btn-lg w-100 fw-bold text-dark @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($autoEarningUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 fs-md-5 py-2 py-md-3 px-3 px-md-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 3. SHIELD PROTECTION -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-info text-white text-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-shield-alt me-2"></i>Shield Protection
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                @if ($isShieldActive)
                                    <div class="mb-3">
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="fas fa-shield-alt me-1"></i>ACTIVE
                                        </span>
                                    </div>
                                    <p class="text-muted mb-2">
                                        <strong>Current Protection:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Protected from theft</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Safe from heist attacks</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Money is secure</li>
                                    </ul>
                                    <div class="alert alert-success">
                                        <small>
                                            <strong>Shield Expires:</strong> 
                                            <span id="shieldTimer">{{ $user->shield_expires_at ? $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') . ' (GMT+7)' : 'N/A' }}</span>
                                        </small>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                            <i class="fas fa-shield-alt me-1"></i>INACTIVE
                                        </span>
                                    </div>
                                    <p class="text-muted">
                                        Protect yourself from theft! Activate a shield to prevent other players from stealing your money.
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>{{ $shieldDurationHours }} hours of protection</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Blocks all theft attempts</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Peace of mind</li>
                                    </ul>
                                @endif
                            </div>

                            @if (!$isShieldActive)
                                <div class="text-center">
                                    <form method="POST" action="{{ route('store.purchase.shield') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-info btn-lg w-100 fw-bold text-white @if($user->money_earned < $shieldCost) disabled @endif"
                                                @if($user->money_earned < $shieldCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            ACTIVATE SHIELD - IDR {{ number_format($shieldCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-5 py-3 px-4">
                                        <i class="fas fa-shield-check me-2"></i>PROTECTED
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Abilities Row -->
            <div class="row g-5 mt-3">
                
                <!-- 4. TREASURE MULTIPLIER -->
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-warning text-dark text-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-gem me-2"></i>Treasure Multiplier
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        Level {{ $user->treasure_multiplier_level }} / {{ $maxTreasureMultiplierLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->treasure_multiplier_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Max Treasure: {{ 20 + ($user->treasure_multiplier_level * 5) }}</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Treasure Efficiency: {{ $user->treasure_multiplier_level * 2 }}% chance to save treasure</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Extended gameplay time</li>
                                        <li><i class="fas fa-check text-success me-2"></i>More earning opportunities</li>
                                    </ul>
                                @else
                                    <p class="text-muted">
                                        Dual benefit upgrade! Increases your maximum treasure capacity AND adds efficiency to save treasure when earning money.
                                    </p>
                                @endif
                            </div>

                            @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-warning mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Max Treasure: {{ 20 + (($user->treasure_multiplier_level + 1) * 5) }}</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Treasure Efficiency: {{ ($user->treasure_multiplier_level + 1) * 2 }}% chance to save treasure</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Dual benefit upgrade</li>
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.treasure-multiplier') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-warning btn-lg w-100 fw-bold text-dark @if($user->money_earned < $treasureMultiplierUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $treasureMultiplierUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($treasureMultiplierUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 fs-md-5 py-2 py-md-3 px-3 px-md-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 5. LUCKY STRIKES -->
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-success text-white text-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-star me-2"></i>Lucky Strikes
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        Level {{ $user->lucky_strikes_level }} / {{ $maxLuckyStrikesLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->lucky_strikes_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Lucky Chance: {{ $user->lucky_strikes_level * 2 }}%</li>
                                        <li><i class="fas fa-check text-success me-2"></i>2x money from treasure opening</li>
                                        <li><i class="fas fa-check text-success me-2"></i>2x stolen money from auto-steal</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Works on ALL money-earning activities</li>
                                    </ul>
                                @else
                                    <p class="text-muted">
                                        Ultimate luck upgrade! Get a chance to double ALL money earned - from treasure opening AND auto-stealing. Pure profit multiplier!
                                    </p>
                                @endif
                            </div>

                            @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-success mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Lucky Chance: {{ ($user->lucky_strikes_level + 1) * 2 }}%</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Higher chance for 2x money</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Works on earning AND stealing</li>
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.lucky-strikes') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success btn-lg w-100 fw-bold @if($user->money_earned < $luckyStrikesUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $luckyStrikesUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($luckyStrikesUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 fs-md-5 py-2 py-md-3 px-3 px-md-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. COUNTER-ATTACK -->
            <div class="col-12 col-lg-6 col-xl-4 mt-4">
                <div class="card h-100 shadow-lg border-0 ability-card">
                    <div class="card-header bg-gradient bg-dark text-white text-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-shield-alt me-2"></i>Counter-Attack
                        </h5>
                        <small class="text-white-75">
                            @if ($user->counter_attack_level > 0)
                                Level {{ $user->counter_attack_level }} / {{ $maxCounterAttackLevel }}
                            @else
                                <span class="text-warning">LOCKED</span>
                            @endif
                        </small>
                    </div>
                    <div class="card-body">
                        @if ($user->counter_attack_level > 0)
                            <h6 class="text-success mb-3"><i class="fas fa-check-circle me-1"></i>OWNED</h6>
                            <div class="mb-3">
                                <strong>Current Benefits:</strong>
                                <ul class="list-unstyled mt-2 text-sm">
                                    <li><i class="fas fa-check text-success me-2"></i>Counter Chance: {{ $user->counter_attack_level * 20 }}%</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Automatically retaliates when stolen from</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Steals back 0.5-{{ min(0.5 + ($user->counter_attack_level * 0.5), 3) }}% of attacker's money</li>
                                </ul>
                            </div>
                        @else
                            <p class="text-muted mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                Defend yourself! When someone steals from you, counter-attack and steal back from them automatically.
                            </p>
                        @endif

                        <div class="mt-auto">
                            @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                <div class="mb-3">
                                    <strong>Next Level Benefits:</strong>
                                    <ul class="list-unstyled mt-2 text-sm text-primary">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Counter Chance: {{ ($user->counter_attack_level + 1) * 20 }}%</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Better retaliation damage</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Stronger defensive capabilities</li>
                                    </ul>
                                </div>
                                <div class="text-center">
                                    <form method="POST" action="{{ route('store.purchase.counter-attack') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-dark btn-lg w-100 fw-bold @if($user->money_earned < $counterAttackUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $counterAttackUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($counterAttackUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-dark fs-6 fs-md-5 py-2 py-md-3 px-3 px-md-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Game Button -->
            <div class="text-center mt-5">
                <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Back to Game
                </a>
            </div>
        </div>
    </div>
</div>
@endsection