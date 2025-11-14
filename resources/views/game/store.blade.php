@extends('layouts.app')

@section('content')
<!-- RPG Store Interface -->
<div class="rpg-store-container">
    <!-- Animated Background -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container-fluid pt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <!-- Store Header -->
                <div class="rpg-header text-center mb-4">
                    <div class="store-title-container">
                        <h1 class="rpg-title">
                            <i class="fas fa-scroll me-3"></i>
                            {{ __('nav.game_store') }}
                            <i class="fas fa-scroll ms-3"></i>
                        </h1>
                        <div class="title-decoration"></div>
                    </div>
                </div>

                <!-- Status Messages -->
                @if (session('success'))
                    <div class="rpg-alert rpg-alert-success mb-4 alert alert-dismissible show" role="alert" style="display:flex;align-items:center;gap:1rem;background:linear-gradient(90deg,#232046,#6a5acd);color:#ffd700;border:2px solid #ffd700;border-radius:12px;box-shadow:0 2px 8px #6a5acd55;">
                        <div class="alert-icon" style="font-size:2rem;">⚔️</div>
                        <div class="alert-content">
                            <div class="alert-title" style="font-weight:bold;font-size:1.2rem;">{{ __('nav.success') }}!</div>
                            <div class="alert-message" style="font-size:1rem;">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="rpg-close btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" style="margin-left:auto;"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="rpg-alert rpg-alert-danger mb-4 alert alert-dismissible" role="alert">
                        <div class="alert-icon">🔥</div>
                        <div class="alert-content">
                            <div class="alert-title">{{ __('nav.error') }}!</div>
                            <div class="alert-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="rpg-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                <!-- Player Money Card -->
                <div class="rpg-wealth-display mb-4">
                    <div class="wealth-card">
                        <div class="wealth-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="wealth-content">
                            <h3 class="wealth-title">{{ __('nav.your_money') }}</h3>
                            <h2 class="wealth-amount">IDR {{ number_format($user->money_earned, 0, ',', '.') }}</h2>
                        </div>
                        <div class="wealth-decoration"></div>
                    </div>
                </div>

                <!-- Store Items Grid -->
                <div class="rpg-items-grid"
                     data-masonry='{"percentPosition": true, "itemSelector": ".rpg-item", "columnWidth": ".rpg-item", "gutter": 15}'>
                    
                    <!-- 1. AUTO STEAL -->
                    <div class="rpg-item rpg-item-danger">
                        <div class="rpg-card">
                            <div class="card-corner-decoration"></div>
                            <div class="rpg-card-header">
                                <div class="ability-icon danger-glow">
                                    <i class="fas fa-mask"></i>
                                </div>
                                <div class="ability-info">
                                    <h6 class="ability-name">{{ __('nav.auto_steal') }}</h6>
                                    <span class="ability-level">{{ __('nav.level_max', ['current' => $user->steal_level, 'max' => $maxStealLevel]) }}</span>
                                </div>
                            </div>
                            
                            <div class="rpg-card-body">
                                <div class="rpg-card-inner">
                                    <div class="rpg-card-top-row">
                                        <div class="rpg-card-badge">
                                            <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                        </div>
                                        <div class="rpg-card-level">
                                            <span class="level-label">{{ __('nav.level') }}:</span>
                                            <span class="level-value">{{ $user->steal_level }}</span>
                                        </div>
                                    </div>
                                    <div class="rpg-card-stats">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.success_rate') }}</span>
                                            <span class="stat-value">{{ $user->steal_level * 5 }}%</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.steal_amount') }}</span>
                                            <span class="stat-value">{{ min(1 + ($user->steal_level * 0.8), 5) }}% max</span>
                                        </div>
                                    </div>
                                    <div class="rpg-card-desc">
                                        <span class="desc-title">{{ __('nav.auto_steal') }}</span>
                                        <span class="desc-text">{{ __('nav.auto_steal_description') }}</span>
                                    </div>
                                    @if ($user->steal_level < $maxStealLevel)
                                    <div class="rpg-card-next">
                                        <span class="next-title">{{ __('nav.next_level', ['level' => $user->steal_level + 1]) }}</span>
                                        <ul class="next-list">
                                            <li>{{ __('nav.success_rate') }}: {{ ($user->steal_level + 1) * 5 }}%</li>
                                            <li>{{ __('nav.steal_amount') }}: {{ min(1 + (($user->steal_level + 1) * 0.8), 5) }}% max</li>
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="rpg-card-action">
                                        @if ($user->steal_level < $maxStealLevel)
                                            <form method="POST" action="{{ route('store.purchase.steal') }}">
                                                @csrf
                                                <button type="submit" class="rpg-btn rpg-btn-danger @if($user->money_earned < $stealUpgradeCost) rpg-btn-disabled @endif" @if($user->money_earned < $stealUpgradeCost) disabled @endif>
                                                    <i class="fas fa-shopping-cart me-2"></i>
                                                    <span class="btn-text">IDR {{ number_format($stealUpgradeCost, 0, ',', '.') }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <div class="max-level-badge">
                                                <i class="fas fa-crown me-2"></i>
                                                {{ __('nav.max_level') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- 2. AUTO EARNING -->
                <div class="rpg-item rpg-item-warning">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.auto_earning') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->auto_earning_level, 'max' => $maxAutoEarningLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->auto_earning_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.rate_per_hour') }}</span>
                                        <span class="stat-value">{{ $user->auto_earning_level * 0.20 }}%/hour</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.hourly_income') }}</span>
                                        <span class="stat-value">IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.20 / 100), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.auto_earning') }}</span>
                                    <span class="desc-text">{{ __('nav.auto_earning_description') }}</span>
                                </div>
                                @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->auto_earning_level + 1]) }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.rate_per_hour') }}: {{ ($user->auto_earning_level + 1) * 0.20 }}%/hour</li>
                                        <li>{{ __('nav.hourly_income') }}: IDR {{ number_format($user->money_earned * (($user->auto_earning_level + 1) * 0.20 / 100), 0, ',', '.') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                        <form method="POST" action="{{ route('store.purchase.auto-earning') }}">
                                            @csrf
                                            <button type="submit" class="rpg-btn @if($user->money_earned < $autoEarningUpgradeCost) rpg-btn-disabled @endif" @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($autoEarningUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. SHIELD PROTECTION -->
                <div class="rpg-item rpg-item-info">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.shield_protection') }}</h6>
                                <span class="ability-level">
                                    @if ($isShieldActive)
                                        <span class="text-warning">{{ __('nav.active') }}</span>
                                    @else
                                        <span class="text-light">{{ __('nav.inactive') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ $isShieldActive ? __('nav.protected') : __('nav.inactive') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.duration') }}:</span>
                                        <span class="level-value">{{ $shieldDurationHours }}h</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.shield_protection') }}</span>
                                    <span class="desc-text">{{ __('nav.shield_description', ['hours' => $shieldDurationHours]) }}</span>
                                </div>
                                @if (!$isShieldActive)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.benefits') }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.hours_protection', ['hours' => $shieldDurationHours]) }}</li>
                                        <li>{{ __('nav.blocks_theft') }}</li>
                                        <li>{{ __('nav.peace_of_mind') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if (!$isShieldActive)
                                        <form method="POST" action="{{ route('store.purchase.shield') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $shieldCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $shieldCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($shieldCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-shield-alt"></i> {{ __('nav.active') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. TREASURE MULTIPLIER -->
                <div class="rpg-item rpg-item-warning">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.treasure_multiplier') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->treasure_multiplier_level, 'max' => $maxTreasureMultiplierLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->treasure_multiplier_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.capacity') }}</span>
                                        <span class="stat-value">{{ 20 + ($user->treasure_multiplier_level * 5) }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.efficiency') }}</span>
                                        <span class="stat-value">{{ $user->treasure_multiplier_level * 2 }}%</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.treasure_multiplier') }}</span>
                                    <span class="desc-text">{{ __('nav.treasure_multiplier_description') }}</span>
                                </div>
                                @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->treasure_multiplier_level + 1]) }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.capacity') }}: {{ __('nav.treasure_max', ['count' => 20 + (($user->treasure_multiplier_level + 1) * 5)]) }}</li>
                                        <li>{{ __('nav.efficiency') }}: {{ __('nav.chance_to_save', ['percent' => ($user->treasure_multiplier_level + 1) * 2]) }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                        <form method="POST" action="{{ route('store.purchase.treasure-multiplier') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $treasureMultiplierUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $treasureMultiplierUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($treasureMultiplierUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. LUCKY STRIKES -->
                <div class="rpg-item rpg-item-success">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.lucky_strikes') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->lucky_strikes_level, 'max' => $maxLuckyStrikesLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->lucky_strikes_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.lucky_chance') }}</span>
                                        <span class="stat-value">{{ $user->lucky_strikes_level * 2 }}%</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.bonus') }}</span>
                                        <span class="stat-value">2x Money</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.lucky_strikes') }}</span>
                                    <span class="desc-text">{{ __('nav.lucky_chance_detailed') }}</span>
                                </div>
                                @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->lucky_strikes_level + 1]) }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.lucky_chance') }}: {{ ($user->lucky_strikes_level + 1) * 2 }}%</li>
                                        <li>{{ __('nav.double_money_earning') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                        <form method="POST" action="{{ route('store.purchase.lucky-strikes') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $luckyStrikesUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $luckyStrikesUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($luckyStrikesUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. COUNTER-ATTACK -->
                <div class="rpg-item rpg-item-dark">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.counter_attack') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->counter_attack_level, 'max' => $maxCounterAttackLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->counter_attack_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.counter_chance') }}</span>
                                        <span class="stat-value">{{ $user->counter_attack_level * 20 }}%</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Steal Back</span>
                                        <span class="stat-value">{{ min(0.5 + ($user->counter_attack_level * 0.5), 3) }}% max</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.counter_attack') }}</span>
                                    <span class="desc-text">{{ __('nav.counter_attack_detailed') }}</span>
                                </div>
                                @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->counter_attack_level + 1]) }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.counter_chance') }}: {{ ($user->counter_attack_level + 1) * 20 }}%</li>
                                        <li>{{ __('nav.steal_back', ['percent' => min(0.5 + (($user->counter_attack_level + 1) * 0.5), 3)]) }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                        <form method="POST" action="{{ route('store.purchase.counter-attack') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $counterAttackUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $counterAttackUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($counterAttackUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. INTIMIDATION -->
                <div class="rpg-item rpg-item-warning">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-skull"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.intimidation') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->intimidation_level, 'max' => $maxIntimidationLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->intimidation_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.steal_reduction') }}</span>
                                        <span class="stat-value">{{ $user->intimidation_level * 2 }}%</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.effect') }}</span>
                                        <span class="stat-value">{{ __('nav.intimidates_attackers') }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.intimidation') }}</span>
                                    <span class="desc-text">{{ __('nav.intimidation_detailed') }}</span>
                                </div>
                                @if ($user->intimidation_level < $maxIntimidationLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->intimidation_level + 1]) }}</span>
                                    <ul class="next-list">
                                        <li>{{ __('nav.steal_reduction') }}: {{ ($user->intimidation_level + 1) * 2 }}%</li>
                                        <li>{{ __('nav.greater_defensive') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->intimidation_level < $maxIntimidationLevel)
                                        <form method="POST" action="{{ route('store.purchase.intimidation') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $intimidationUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $intimidationUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($intimidationUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 8. FAST RECOVERY -->
                <div class="rpg-item rpg-item-primary">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-clock-rotate-left"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.fast_recovery') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->fast_recovery_level, 'max' => $maxFastRecoveryLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->fast_recovery_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        @php
                                            $intervals = [60, 55, 50, 45, 40, 30];
                                            $currentInterval = $intervals[$user->fast_recovery_level];
                                        @endphp
                                        <span class="stat-label">{{ __('nav.speed') }}</span>
                                        <span class="stat-value">{{ __('nav.min_intervals', ['minutes' => $currentInterval]) }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.effect') }}</span>
                                        <span class="stat-value">{{ __('nav.faster_regen') }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.fast_recovery') }}</span>
                                    <span class="desc-text">{{ __('nav.fast_recovery_detailed') }}</span>
                                </div>
                                @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->fast_recovery_level + 1]) }}</span>
                                    <ul class="next-list">
                                        @php
                                            $intervals = [60, 55, 50, 45, 40, 30];
                                            $nextInterval = $intervals[$user->fast_recovery_level + 1];
                                        @endphp
                                        <li>{{ __('nav.regeneration') }}: {{ __('nav.every_minutes', ['minutes' => $nextInterval]) }}</li>
                                        <li>{{ __('nav.faster_collection') }}</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                        <form method="POST" action="{{ route('store.purchase.fast-recovery') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if($user->money_earned < $fastRecoveryUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $fastRecoveryUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($fastRecoveryUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 9. TREASURE RARITY -->
                <div class="rpg-item rpg-item-primary">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.treasure_rarity') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->treasure_rarity_level, 'max' => $maxTreasureRarityLevel]) }}</span>
                            </div>
                        </div>
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->treasure_rarity_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        @php
                                            $rarityNames = \App\Models\User::getTreasureRarityNames();
                                            $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                            $currentRarityName = $rarityNames[$user->treasure_rarity_level] ?? 'Ultimate';
                                            $currentChance = $rarityChances[$user->treasure_rarity_level] ?? 0;
                                        @endphp
                                        <span class="stat-label">{{ __('nav.type') }}</span>
                                        <span class="stat-value">{{ $currentRarityName }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.random_box') }}</span>
                                        <span class="stat-value">{{ $currentChance }}% {{ __('nav.chance') }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.treasure_rarity') }}</span>
                                    <span class="desc-text">{{ __('nav.treasure_rarity_detailed') }}</span>
                                </div>
                                @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                <div class="rpg-card-next">
                                    <span class="next-title">{{ __('nav.next_level', ['level' => $user->treasure_rarity_level + 1]) }}</span>
                                    @php
                                        $nextRarityName = $rarityNames[$user->treasure_rarity_level + 1] ?? 'Ultimate';
                                        $nextChance = $rarityChances[$user->treasure_rarity_level + 1] ?? 19;
                                    @endphp
                                    <ul class="next-list">
                                        <li>{{ __('nav.rarity') }}: {{ $nextRarityName }}</li>
                                        <li>{{ __('nav.random_box_chance') }}: {{ $nextChance }}%</li>
                                    </ul>
                                </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                        <form method="POST" action="{{ route('store.purchase.treasure-rarity') }}">
                                            @csrf
                                            <button type="submit" class="rpg-btn @if($user->money_earned < $treasureRarityUpgradeCost) rpg-btn-disabled @endif" @if($user->money_earned < $treasureRarityUpgradeCost) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($treasureRarityUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 10. PRESTIGE SYSTEM -->
                <div class="rpg-item rpg-item-prestige">
                    <div class="rpg-card">
                        <div class="card-corner-decoration"></div>
                        <div class="rpg-card-header">
                            <div class="ability-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div class="ability-info">
                                <h6 class="ability-name">{{ __('nav.prestige_system') }}</h6>
                                <span class="ability-level">{{ __('nav.level_max', ['current' => $user->prestige_level, 'max' => $maxPrestigeLevel]) }}</span>
                            </div>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="rpg-card-inner">
                                <div class="rpg-card-top-row">
                                    <div class="rpg-card-badge">
                                        <span class="badge badge-rpg">{{ __('nav.owned') }}</span>
                                    </div>
                                    <div class="rpg-card-level">
                                        <span class="level-label">{{ __('nav.level') }}:</span>
                                        <span class="level-value">{{ $user->prestige_level }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.passive_income') }}</span>
                                        <span class="stat-value">{{ $user->prestige_level }}%/hour</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">{{ __('nav.hourly_income') }}</span>
                                        <span class="stat-value">IDR {{ number_format($user->money_earned * ($user->prestige_level / 100), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="rpg-card-desc">
                                    <span class="desc-title">{{ __('nav.prestige_system') }}</span>
                                    <span class="desc-text">{{ __('nav.prestige_description') }}</span>
                                </div>
                                @if ($user->prestige_level < $maxPrestigeLevel)
                                    @php
                                        $nextLevel = $user->prestige_level + 1;
                                        $requiredLevel = $prestigeLevelRequirements[$nextLevel] ?? 0;
                                        $isLevelRequirementMet = $user->level >= $requiredLevel;
                                        $hasEnoughMoney = $user->money_earned >= $prestigeUpgradeCost;
                                        $canUpgrade = $isLevelRequirementMet && $hasEnoughMoney;
                                    @endphp
                                    <div class="rpg-card-next">
                                        <span class="next-title">{{ __('nav.next_level', ['level' => $nextLevel]) }}</span>
                                        <ul class="next-list">
                                            <li>{{ __('nav.passive_income') }}: {{ $nextLevel }}% {{ __('nav.per_hour') }}</li>
                                            <li>{{ __('nav.required_level') }}: {{ $requiredLevel }}</li>
                                            <li>{{ __('nav.cost') }}: IDR {{ number_format($prestigeCosts[$nextLevel], 0, ',', '.') }}</li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="rpg-card-action">
                                    @if ($user->prestige_level < $maxPrestigeLevel)
                                        @php
                                            $nextLevel = $user->prestige_level + 1;
                                            $requiredLevel = $prestigeLevelRequirements[$nextLevel] ?? 0;
                                        @endphp
                                        <form method="POST" action="{{ route('store.purchase.prestige') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn @if(!$canUpgrade) rpg-btn-disabled @endif"
                                                    @if(!$canUpgrade) disabled @endif>
                                                <span class="btn-text">
                                                    <i class="fas fa-shopping-cart"></i> IDR {{ number_format($prestigeUpgradeCost, 0, ',', '.') }}
                                                </span>
                                            </button>
                                        </form>
                                        @if (!$isLevelRequirementMet)
                                            <small class="text-muted mt-2 d-block text-center" style="color:white !important;">{{ __('nav.need_level') }} {{ $requiredLevel }}</small>
                                        @endif
                                    @else
                                        <div class="max-level-badge">
                                            <i class="fas fa-star"></i> {{ __('nav.max_level') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Back to Game Button -->
                <div class="rpg-back-area">
                    <a href="{{ route('game.dashboard') }}" class="rpg-back-btn">
                        <i class="fas fa-arrow-left"></i> &nbsp; {{ __('nav.back_to_game') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

<style>
/* --- Mobile-first, gaming-inspired redesign --- */
.rpg-store-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #232046 0%, #6a5acd 100%);
    padding-bottom: 2rem;
}
.rpg-background {
    display: none; /* Remove background clutter for clarity */
}
.rpg-header {
    margin-bottom: 2rem;
}
.rpg-title {
    font-family: 'Orbitron', 'Cinzel', serif;
    font-size: 2rem;
    color: #ffd700;
    text-shadow: 0 2px 8px #6a5acd;
    letter-spacing: 2px;
}
.title-decoration {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg,#ffd700,#6a5acd);
    border-radius:2px;
    margin: 0 auto;
}
.rpg-wealth-display {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
}
.wealth-card {
    background: #232046;
    border: 2px solid #ffd700;
    border-radius: 16px;
    box-shadow: 0 4px 16px #6a5acd55;
    padding: 1rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.wealth-icon {
    font-size: 2rem;
    color: #ffd700;
}
.wealth-title {
    color: #ffd700;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}
.wealth-amount {
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
}
.rpg-items-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}
.rpg-item {
    flex: 1 1;
    max-width: 350px;
    min-width: 260px;
    margin-bottom: 1rem;
}
.rpg-card {
    background: linear-gradient(145deg, #232046 80%, #6a5acd 100%);
    border: 2px solid #ffd700;
    border-radius: 16px;
    box-shadow: 0 4px 16px #6a5acd55;
    padding: 0.7rem; /* reduced from 1rem for closer spacing */
    display: flex;
    flex-direction: column;
    min-height: 260px; /* reduced from 340px for less space */
    gap: 0.3rem; /* add gap for tighter layout */
}
.rpg-card-inner {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    background: linear-gradient(120deg, #232046 80%, #6a5acd 100%);
    border-radius: 12px;
    box-shadow: 0 2px 8px #6a5acd55;
    padding: 0.7rem 0.9rem;
}
.rpg-card-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.rpg-card-badge .badge-rpg {
    background: linear-gradient(90deg,#ffd700,#6a5acd);
    color: #232046;
    font-weight: bold;
    border-radius: 12px;
    padding: 0.3em 0.8em;
    font-size: 0.9rem;
}
.rpg-card-level {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.level-label {
    color: #ffd700;
    font-size: 0.9rem;
}
.level-value {
    color: #fff;
    font-size: 1.1rem;
    font-weight: bold;
}
.rpg-card-stats {
    display: flex;
    gap: 1.2rem;
    justify-content: flex-start;
}
.rpg-card-desc {
    margin-top: 0.2rem;
    margin-bottom: 0.2rem;
}
.desc-title {
    color: #ffd700;
    font-weight: bold;
    font-size: 1rem;
    margin-right: 0.5rem;
}
.desc-text {
    color: #fff;
    font-size: 0.95rem;
}
.rpg-card-next {
    background: rgba(255,255,255,0.07);
    border-radius: 8px;
    padding: 0.4rem 0.7rem;
    margin-top: 0.2rem;
}
.next-title {
    color: #ffd700;
    font-size: 0.95rem;
    font-weight: bold;
}
.next-list {
    margin: 0.2rem 0 0 1rem;
    color: #fff;
    font-size: 0.9rem;
}
.rpg-card-action {
    margin-top: 0.3rem;
    display: flex;
    justify-content: flex-end;
}
.rpg-description {
    background: rgba(255,255,255,0.07);
    border-radius: 8px;
    color: #fff;
    font-size: 0.95rem;
    padding: 0.5rem; /* reduced from 0.75rem */
    margin-bottom: 0.2rem; /* reduced spacing */
}
.next-level-preview {
    margin-top: 0.2rem; /* reduced spacing */
}
.current-stats {
    margin-bottom: 0.5rem;
}
.stat-badge.owned {
    background: linear-gradient(90deg,#ffd700,#6a5acd);
    color: #232046;
    font-weight: bold;
    border-radius: 12px;
    padding: 0.3em 0.8em;
    margin-bottom: 0.3em;
}
.stats-grid {
    display: flex;
    gap: 0.3rem; /* reduced gap */
    flex-wrap: wrap;
}
.stat-item {
    background: rgba(255,255,255,0.08);
    border-radius: 8px;
    padding: 0.3rem; /* reduced from 0.5rem */
    text-align: center;
    min-width: 70px; /* reduced from 90px */
}
.stat-label {
    font-size: 0.8rem;
    color: #ffd700;
}
.stat-value {
    font-size: 1rem;
    color: #fff;
    font-weight: bold;
}
.rpg-action-area {
    margin-top: 0.2rem; /* reduced spacing */
}
.rpg-btn {
    background: linear-gradient(90deg,#ffd700,#6a5acd);
    color: #232046;
    font-weight: bold;
    border-radius: 8px;
    box-shadow: 0 2px 8px #6a5acd55;
    padding: 0.7rem 1.2rem;
    font-size: 1rem;
    width: 100%;
    margin-top: 0.5rem;
}
.rpg-btn-disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.max-level-badge {
    background: linear-gradient(90deg,#ffd700,#6a5acd);
    color: #232046;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    text-align: center;
    font-weight: bold;
    font-size: 0.95rem;
    margin-top: 0.2rem; /* reduced spacing */
}
.rpg-back-area {
    text-align: center;
    margin-top: 2rem;
}
.rpg-back-btn {
    background: linear-gradient(135deg, #6a5acd 0%, #ffd700 100%);
    color: #232046;
    font-weight: bold;
    border-radius: 24px;
    box-shadow: 0 2px 8px #6a5acd55;
    padding: 0.7rem 2rem;
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-block;
    margin-top: 1rem;
}
.rpg-back-btn:hover {
    background: linear-gradient(135deg, #ffd700 0%, #6a5acd 100%);
    color: #fff;
}
@media (max-width: 768px) {
    .rpg-title { font-size: 1.3rem; }
    .wealth-card { flex-direction: column; text-align: center; padding: 1rem; }
    .rpg-items-grid { flex-direction: column; gap: 0.5rem; }
    .rpg-item { min-width: 0; max-width: 100%; }
    .rpg-card { min-height: 0; padding: 0.7rem; }
    .rpg-card-header { gap: 0.3rem; }
    .ability-icon { width: 32px; height: 32px; font-size: 1rem; }
    .rpg-btn { font-size: 0.95rem; padding: 0.6rem 1rem; }
}
@media (max-width: 480px) {
    .rpg-title { font-size: 1rem; }
    .wealth-amount { font-size: 1.1rem; }
    .rpg-card { padding: 0.3rem; }
    .rpg-description { padding: 0.3rem; }
    .rpg-btn { padding: 0.3rem 0.5rem; }
}

/* --- UI fix: Hide info panel space until info button is clicked --- */
.rpg-description, .next-level-preview {
    display: none;
}
.rpg-collapse.show .rpg-description, .rpg-collapse.show .next-level-preview {
    display: block;
}
.rpg-collapse {
    margin-bottom: 0;
    padding: 0;
}

/* --- New styles for ability cards --- */
.rpg-card-header .ability-name,
.rpg-card-header .ability-level,
.rpg-card-header .ability-info {
    color: #fff !important;
}
.rpg-card-desc .desc-title,
.rpg-card-desc .desc-text,
.rpg-card-next .next-title,
.rpg-card-next .next-list,
.rpg-card-stats .stat-label,
.rpg-card-stats .stat-value {
    color: #fff !important;
}
@media (max-width: 768px) {
    .rpg-card-inner { padding: 0.5rem 0.4rem; gap: 0.3rem; }
    .rpg-card-stats { gap: 0.5rem; }
    .next-list { font-size: 0.85rem; }
    .desc-title, .desc-text { font-size: 0.9rem; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle RPG alert close buttons
    const closeButtons = document.querySelectorAll('.rpg-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const alert = this.closest('.rpg-alert');
            if (alert) {
                // Add fade out animation
                alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                
                // Remove the alert after animation
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.rpg-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeBtn = alert.querySelector('.rpg-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });

    // Handle collapse behavior to ensure only one info panel is open at a time
    const infoButtons = document.querySelectorAll('.rpg-info-btn');
    const collapseElements = document.querySelectorAll('.rpg-collapse');
    
    // Store active collapse instances
    const collapseInstances = new Map();
    
    // Initialize Bootstrap collapse instances
    collapseElements.forEach(collapse => {
        const bsCollapse = new bootstrap.Collapse(collapse, {
            toggle: false
        });
        collapseInstances.set(collapse.id, bsCollapse);
    });
    
    infoButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-target').substring(1); // Remove #
            const targetElement = document.getElementById(targetId);
            const targetInstance = collapseInstances.get(targetId);
            
            if (!targetElement || !targetInstance) return;
            
            const isCurrentlyShown = targetElement.classList.contains('show');
            
            // Close all other collapse elements
            collapseElements.forEach(collapse => {
                if (collapse.id !== targetId && collapse.classList.contains('show')) {
                    const instance = collapseInstances.get(collapse.id);
                    if (instance) {
                        instance.hide();
                    }
                }
            });
            
            // Toggle the current element
            if (isCurrentlyShown) {
                targetInstance.hide();
            } else {
                targetInstance.show();
            }
        });
    });

    // Update aria-expanded attribute when collapse state changes
    collapseElements.forEach(collapse => {
        collapse.addEventListener('shown.bs.collapse', function() {
            const targetId = '#' + this.id;
            const button = document.querySelector(`[data-bs-target="${targetId}"]`);
            if (button) {
                button.setAttribute('aria-expanded', 'true');
            }
        });

        collapse.addEventListener('hidden.bs.collapse', function() {
            const targetId = '#' + this.id;
            const button = document.querySelector(`[data-bs-target="${targetId}"]`);
            if (button) {
                button.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>
@endsection
