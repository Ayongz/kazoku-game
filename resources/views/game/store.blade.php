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
                    <div class="rpg-alert rpg-alert-success mb-4 alert alert-dismissible" role="alert">
                        <div class="alert-icon">⚔️</div>
                        <div class="alert-content">
                            <div class="alert-title">{{ __('nav.success') }}!</div>
                            <div class="alert-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="rpg-close" data-bs-dismiss="alert" aria-label="Close">×</button>
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
                                <button class="rpg-info-btn" type="button" data-target="#autoStealInfo" aria-expanded="false" aria-controls="autoStealInfo">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                            
                            <div class="rpg-card-body">
                                <div class="collapse rpg-collapse" id="autoStealInfo">
                                    <div class="rpg-description">
                                        <strong>{{ __('nav.auto_steal') }}:</strong> {{ __('nav.auto_steal_description') }}
                                        @if ($user->steal_level < $maxStealLevel)
                                            <div class="next-level-preview">
                                                <strong>{{ __('nav.next_level', ['level' => $user->steal_level + 1]) }}:</strong>
                                                <ul>
                                                    <li>{{ __('nav.success_rate') }}: {{ ($user->steal_level + 1) * 5 }}%</li>
                                                    <li>{{ __('nav.steal_amount') }}: {{ min(1 + (($user->steal_level + 1) * 0.8), 5) }}% max</li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if ($user->steal_level > 0)
                                    <div class="current-stats">
                                        <div class="stat-badge owned">{{ __('nav.owned') }}</div>
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <span class="stat-label">{{ __('nav.success_rate') }}</span>
                                                <span class="stat-value">{{ $user->steal_level * 5 }}%</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">{{ __('nav.steal_amount') }}</span>
                                                <span class="stat-value">{{ min(1 + ($user->steal_level * 0.8), 5) }}% max</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="rpg-action-area">
                                    @if ($user->steal_level < $maxStealLevel)
                                        <form method="POST" action="{{ route('store.purchase.steal') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="rpg-btn rpg-btn-danger @if($user->money_earned < $stealUpgradeCost) rpg-btn-disabled @endif"
                                                    @if($user->money_earned < $stealUpgradeCost) disabled @endif>
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
                            <button class="rpg-info-btn" type="button" data-target="#autoEarningInfo" aria-expanded="false" aria-controls="autoEarningInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="autoEarningInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.auto_earning') }}:</strong> {{ __('nav.auto_earning_description') }}
                                    @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->auto_earning_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.rate_per_hour') }}: {{ ($user->auto_earning_level + 1) * 0.20 }}% per hour</li>
                                                <li>{{ __('nav.hourly_income') }}: IDR {{ number_format($user->money_earned * (($user->auto_earning_level + 1) * 0.20 / 100), 0, ',', '.') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->auto_earning_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.rate_per_hour') }}</span>
                                            <span class="stat-value">{{ $user->auto_earning_level * 0.20 }}%/hour</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.hourly_income') }}</span>
                                            <span class="stat-value">IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.20 / 100), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
                                @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                    <form method="POST" action="{{ route('store.purchase.auto-earning') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="rpg-btn @if($user->money_earned < $autoEarningUpgradeCost) rpg-btn-disabled @endif"
                                                @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif>
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
                            <button class="rpg-info-btn" type="button" data-target="#shieldInfo" aria-expanded="false" aria-controls="shieldInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="shieldInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.shield_protection') }}:</strong> {{ __('nav.shield_description', ['hours' => $shieldDurationHours]) }}
                                    @if (!$isShieldActive)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.benefits') }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.hours_protection', ['hours' => $shieldDurationHours]) }}</li>
                                                <li>{{ __('nav.blocks_theft') }}</li>
                                                <li>{{ __('nav.peace_of_mind') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($isShieldActive)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.protected') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">Expires</span>
                                            <span class="stat-value" id="shieldTimer">{{ $user->shield_expires_at ? $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('M d, H:i') : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#treasureMultiplierInfo" aria-expanded="false" aria-controls="treasureMultiplierInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="treasureMultiplierInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.treasure_multiplier') }}:</strong> {{ __('nav.treasure_multiplier_description') }}
                                    @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->treasure_multiplier_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.capacity') }}: {{ __('nav.treasure_max', ['count' => 20 + (($user->treasure_multiplier_level + 1) * 5)]) }}</li>
                                                <li>{{ __('nav.efficiency') }}: {{ __('nav.chance_to_save', ['percent' => ($user->treasure_multiplier_level + 1) * 2]) }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_multiplier_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.capacity') }}</span>
                                            <span class="stat-value">{{ 20 + ($user->treasure_multiplier_level * 5) }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.efficiency') }}</span>
                                            <span class="stat-value">{{ $user->treasure_multiplier_level * 2 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#luckyStrikesInfo" aria-expanded="false" aria-controls="luckyStrikesInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="luckyStrikesInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.lucky_strikes') }}:</strong> {{ __('nav.lucky_chance_detailed') }}
                                    @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->lucky_strikes_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.lucky_chance') }}: {{ ($user->lucky_strikes_level + 1) * 2 }}%</li>
                                                <li>{{ __('nav.double_money_earning') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->lucky_strikes_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.lucky_chance') }}</span>
                                            <span class="stat-value">{{ $user->lucky_strikes_level * 2 }}%</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.bonus') }}</span>
                                            <span class="stat-value">2x Money</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#counterAttackInfo" aria-expanded="false" aria-controls="counterAttackInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="counterAttackInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.counter_attack') }}:</strong> {{ __('nav.counter_attack_detailed') }}
                                    @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->counter_attack_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.counter_chance') }}: {{ ($user->counter_attack_level + 1) * 20 }}%</li>
                                                <li>{{ __('nav.steal_back', ['percent' => min(0.5 + (($user->counter_attack_level + 1) * 0.5), 3)]) }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->counter_attack_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.counter_chance') }}</span>
                                            <span class="stat-value">{{ $user->counter_attack_level * 20 }}%</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">Steal Back</span>
                                            <span class="stat-value">{{ min(0.5 + ($user->counter_attack_level * 0.5), 3) }}% max</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#intimidationInfo" aria-expanded="false" aria-controls="intimidationInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="intimidationInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.intimidation') }}:</strong> {{ __('nav.intimidation_detailed') }}
                                    @if ($user->intimidation_level < $maxIntimidationLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->intimidation_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.steal_reduction') }}: {{ ($user->intimidation_level + 1) * 2 }}%</li>
                                                <li>{{ __('nav.greater_defensive') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->intimidation_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.steal_reduction') }}</span>
                                            <span class="stat-value">{{ $user->intimidation_level * 2 }}%</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.effect') }}</span>
                                            <span class="stat-value">{{ __('nav.intimidates_attackers') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#fastRecoveryInfo" aria-expanded="false" aria-controls="fastRecoveryInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="fastRecoveryInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.fast_recovery') }}:</strong> {{ __('nav.fast_recovery_detailed') }}
                                    @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                        <div class="next-level-preview">
                                            <strong>{{ __('nav.next_level', ['level' => $user->fast_recovery_level + 1]) }}:</strong>
                                            <ul>
                                                @php
                                                    $intervals = [60, 55, 50, 45, 40, 30];
                                                    $nextInterval = $intervals[$user->fast_recovery_level + 1];
                                                @endphp
                                                <li>{{ __('nav.regeneration') }}: {{ __('nav.every_minutes', ['minutes' => $nextInterval]) }}</li>
                                                <li>{{ __('nav.faster_collection') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->fast_recovery_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
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
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
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
                            <button class="rpg-info-btn" type="button" data-target="#treasureRarityInfo" aria-expanded="false" aria-controls="treasureRarityInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="treasureRarityInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.treasure_rarity') }}:</strong> {{ __('nav.treasure_rarity_detailed') }}
                                    @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                        <div class="next-level-preview">
                                            @php
                                                $rarityNames = \App\Models\User::getTreasureRarityNames();
                                                $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                                $nextRarityName = $rarityNames[$user->treasure_rarity_level + 1] ?? 'Ultimate';
                                                $nextChance = $rarityChances[$user->treasure_rarity_level + 1] ?? 19;
                                            @endphp
                                            <strong>{{ __('nav.next_level', ['level' => $user->treasure_rarity_level + 1]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.rarity') }}: {{ $nextRarityName }}</li>
                                                <li>{{ __('nav.random_box_chance') }}: {{ $nextChance }}%</li>
                                                <!-- <li>{{ __('nav.better_rewards') }}</li> -->
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_rarity_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
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
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
                                @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                    <form method="POST" action="{{ route('store.purchase.treasure-rarity') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="rpg-btn @if($user->money_earned < $treasureRarityUpgradeCost) rpg-btn-disabled @endif"
                                                @if($user->money_earned < $treasureRarityUpgradeCost) disabled @endif
                                                style="background: linear-gradient(45deg, #6f42c1, #e83e8c);">
                                            <span class="btn-text">
                                                <i class="fas fa-shopping-cart"></i> IDR {{ number_format($treasureRarityUpgradeCost, 0, ',', '.') }}
                                            </span>
                                        </button>
                                    </form>
                                @else
                                    <div class="max-level-badge" style="background: linear-gradient(45deg, #6f42c1, #e83e8c);">
                                        <i class="fas fa-crown"></i> {{ __('nav.max_level') }}
                                    </div>
                                @endif
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
                            <button class="rpg-info-btn" type="button" data-target="#prestigeInfo" aria-expanded="false" aria-controls="prestigeInfo">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                        
                        <div class="rpg-card-body">
                            <div class="collapse rpg-collapse" id="prestigeInfo">
                                <div class="rpg-description">
                                    <strong>{{ __('nav.prestige_system') }}:</strong> {{ __('nav.prestige_description') }}
                                    @if ($user->prestige_level < $maxPrestigeLevel)
                                        <div class="next-level-preview">
                                            @php
                                                $nextLevel = $user->prestige_level + 1;
                                                $requiredLevel = $prestigeLevelRequirements[$nextLevel];
                                            @endphp
                                            <strong>{{ __('nav.next_level', ['level' => $nextLevel]) }}:</strong>
                                            <ul>
                                                <li>{{ __('nav.passive_income') }}: {{ $nextLevel }}% {{ __('nav.per_hour') }}</li>
                                                <li>{{ __('nav.required_level') }}: {{ $requiredLevel }}</li>
                                                <li>{{ __('nav.cost') }}: IDR {{ number_format($prestigeCosts[$nextLevel], 0, ',', '.') }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->prestige_level > 0)
                                <div class="current-stats">
                                    <span class="stat-badge owned">{{ __('nav.owned') }}</span>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.passive_income') }}</span>
                                            <span class="stat-value">{{ $user->prestige_level }}%/hour</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">{{ __('nav.hourly_income') }}</span>
                                            <span class="stat-value">IDR {{ number_format($user->money_earned * ($user->prestige_level / 100), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="rpg-action-area">
                                @if ($user->prestige_level < $maxPrestigeLevel)
                                    @php
                                        $nextLevel = $user->prestige_level + 1;
                                        $requiredLevel = $prestigeLevelRequirements[$nextLevel];
                                        $isLevelRequirementMet = $user->level >= $requiredLevel;
                                        $hasEnoughMoney = $user->money_earned >= $prestigeUpgradeCost;
                                        $canUpgrade = $isLevelRequirementMet && $hasEnoughMoney;
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
/* ===== RPG STORE INTERFACE STYLES ===== */

/* Background & Container */
.rpg-store-container {
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

/* Ensure navigation doesn't get affected */
.container-fluid {
    position: relative;
    z-index: 10;
}

.navbar {
    position: relative;
    z-index: 1000 !important;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
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

/* Header Styles */
.rpg-header {
    position: relative;
    margin-bottom: 2rem;
}

.store-title-container {
    position: relative;
    display: inline-block;
}

.rpg-title {
    font-size: 2.5rem;
    color: #ffd700;
    text-shadow: 
        0 0 10px #ffd700,
        0 0 20px #ffd700,
        0 0 30px #ffd700;
    font-family: 'Cinzel', serif;
    font-weight: bold;
    margin: 0;
    position: relative;
    z-index: 2;
}

.title-decoration {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 4px;
    background: linear-gradient(90deg, transparent 0%, #ffd700 50%, transparent 100%);
    box-shadow: 0 0 10px #ffd700;
}

/* Alert Styles */
.rpg-alert {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 15px;
    border: 2px solid;
    position: relative;
    backdrop-filter: blur(10px);
    animation: slideInFromTop 0.5s ease-out;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.rpg-alert-success {
    background: rgba(46, 204, 113, 0.2);
    border-color: #2ecc71;
    color: #27ae60;
}

.rpg-alert-danger {
    background: rgba(231, 76, 60, 0.2);
    border-color: #e74c3c;
    color: #c0392b;
}

.alert-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
    animation: pulse 2s infinite;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.alert-message {
    font-size: 0.9rem;
    opacity: 0.9;
}

.rpg-close {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    margin-left: 1rem;
    transition: all 0.3s ease;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.rpg-close:hover {
    transform: scale(1.2);
    color: #ff6b6b;
    background: rgba(255, 107, 107, 0.1);
}

/* Wealth Display */
.rpg-wealth-display {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.wealth-card {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 215, 0, 0.05) 100%);
    border: 2px solid #ffd700;
    border-radius: 20px;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    position: relative;
    backdrop-filter: blur(10px);
    box-shadow: 
        0 0 30px rgba(255, 215, 0, 0.3),
        inset 0 0 30px rgba(255, 215, 0, 0.1);
    animation: goldGlow 3s ease-in-out infinite alternate;
}

.wealth-icon {
    font-size: 2.5rem;
    color: #ffd700;
    margin-right: 1.5rem;
    animation: coinSpin 4s linear infinite;
}

.wealth-content {
    text-align: left;
}

.wealth-title {
    color: #ffd700;
    font-size: 1.2rem;
    margin: 0 0 0.5rem 0;
    font-weight: 600;
}

.wealth-amount {
    color: #fff;
    font-size: 2rem;
    margin: 0;
    font-weight: bold;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

.wealth-decoration {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 20px;
    height: 20px;
    background: radial-gradient(circle, #ffd700 0%, transparent 70%);
    border-radius: 50%;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes goldGlow {
    0% { box-shadow: 0 0 30px rgba(255, 215, 0, 0.3), inset 0 0 30px rgba(255, 215, 0, 0.1); }
    100% { box-shadow: 0 0 50px rgba(255, 215, 0, 0.5), inset 0 0 50px rgba(255, 215, 0, 0.2); }
}

@keyframes coinSpin {
    0% { transform: rotateY(0deg); }
    100% { transform: rotateY(360deg); }
}

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0); }
    50% { opacity: 1; transform: scale(1); }
}

/* Items Grid */
.rpg-items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 0 1rem;
}

/* RPG Item Cards */
.rpg-item {
    position: relative;
    animation: slideInFromBottom 0.6s ease-out;
}

.rpg-item:nth-child(even) {
    animation-delay: 0.1s;
}

.rpg-item:nth-child(3n) {
    animation-delay: 0.2s;
}

.rpg-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 2px solid;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(15px);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.rpg-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.card-corner-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    clip-path: polygon(100% 0%, 0% 100%, 100% 100%);
}

/* Color Themes */
.rpg-item-danger {
    --theme-color: #e74c3c;
    --theme-glow: rgba(231, 76, 60, 0.4);
}

.rpg-item-warning {
    --theme-color: #f39c12;
    --theme-glow: rgba(243, 156, 18, 0.4);
}

.rpg-item-info {
    --theme-color: #3498db;
    --theme-glow: rgba(52, 152, 219, 0.4);
}

.rpg-item-success {
    --theme-color: #2ecc71;
    --theme-glow: rgba(46, 204, 113, 0.4);
}

.rpg-item-dark {
    --theme-color: #34495e;
    --theme-glow: rgba(52, 73, 94, 0.4);
}

.rpg-item-primary {
    --theme-color: #9b59b6;
    --theme-glow: rgba(155, 89, 182, 0.4);
}

.rpg-item-prestige {
    --theme-color: #ffd700;
    --theme-glow: rgba(255, 215, 0, 0.4);
}

.rpg-card {
    border-color: var(--theme-color);
    box-shadow: 0 0 20px var(--theme-glow);
}

.rpg-card:hover {
    box-shadow: 0 0 40px var(--theme-glow), 0 20px 40px rgba(0, 0, 0, 0.3);
}

/* Card Header */
.rpg-card-header {
    padding: 1rem;
    background: linear-gradient(135deg, var(--theme-color) 0%, rgba(0, 0, 0, 0.2) 100%);
    display: flex;
    align-items: center;
    position: relative;
}

.ability-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 1rem;
    position: relative;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.ability-icon::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: var(--theme-color);
    z-index: -1;
    animation: iconPulse 3s ease-in-out infinite;
}

.ability-info {
    flex: 1;
}

.ability-name {
    color: white;
    font-size: 1.1rem;
    font-weight: bold;
    margin: 0 0 0.25rem 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.ability-level {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.85rem;
}

.rpg-info-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.rpg-info-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
    color: white;
}

@keyframes iconPulse {
    0%, 100% { box-shadow: 0 0 10px var(--theme-color); }
    50% { box-shadow: 0 0 20px var(--theme-color), 0 0 30px var(--theme-glow); }
}

/* Card Body */
.rpg-card-body {
    padding: 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.rpg-collapse {
    margin-bottom: 1rem;
    overflow: hidden;
}

.rpg-collapse.collapsing {
    transition: height 0.35s ease;
}

.rpg-collapse:not(.show) {
    display: none;
}

.rpg-collapse.show {
    display: block;
}

.rpg-description {
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem;
    border-radius: 10px;
    color: #fff;
    font-size: 0.9rem;
    line-height: 1.5;
    border-left: 4px solid var(--theme-color);
}

.next-level-preview {
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.next-level-preview ul {
    margin: 0.5rem 0 0 1rem;
    padding: 0;
}

.next-level-preview li {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.25rem;
}

/* Current Stats */
.current-stats {
    margin-bottom: 1rem;
}

.stat-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    margin-bottom: 0.75rem;
}

.stat-badge.owned {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
    color: white;
    box-shadow: 0 0 15px rgba(46, 204, 113, 0.4);
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
}

.stat-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem;
    border-radius: 8px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 0.25rem;
}

.stat-value {
    display: block;
    font-size: 0.9rem;
    color: white;
    font-weight: bold;
}

/* Action Area */
.rpg-action-area {
    margin-top: auto;
}

.rpg-btn {
    width: 100%;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    background: linear-gradient(135deg, var(--theme-color) 0%, rgba(0, 0, 0, 0.2) 100%);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.rpg-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    transition: left 0.5s ease;
}

.rpg-btn:hover::before {
    left: 100%;
}

.rpg-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.rpg-btn:active {
    transform: translateY(0px);
}

.rpg-btn-disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #7f8c8d;
}

.rpg-btn-disabled:hover {
    transform: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-text {
    position: relative;
    z-index: 2;
}

.max-level-badge {
    background: linear-gradient(135deg, #ffd700 0%, #f39c12 100%);
    color: #2c3e50;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    text-align: center;
    font-weight: bold;
    font-size: 0.9rem;
    box-shadow: 
        0 0 20px rgba(255, 215, 0, 0.4),
        0 4px 15px rgba(0, 0, 0, 0.2);
    animation: maxLevelGlow 2s ease-in-out infinite alternate;
}

@keyframes maxLevelGlow {
    0% { box-shadow: 0 0 20px rgba(255, 215, 0, 0.4), 0 4px 15px rgba(0, 0, 0, 0.2); }
    100% { box-shadow: 0 0 30px rgba(255, 215, 0, 0.6), 0 4px 15px rgba(0, 0, 0, 0.2); }
}

/* Animations */
@keyframes slideInFromTop {
    0% {
        opacity: 0;
        transform: translateY(-50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromBottom {
    0% {
        opacity: 0;
        transform: translateY(50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Back Button */
.rpg-back-area {
    text-align: center;
    margin-top: 3rem;
    padding-bottom: 2rem;
}

.rpg-back-btn {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: bold;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    position: relative;
    overflow: hidden;
}

.rpg-back-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    transition: left 0.5s ease;
}

.rpg-back-btn:hover::before {
    left: 100%;
}

.rpg-back-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .rpg-title {
        font-size: 2rem;
    }
    
    .title-decoration {
        width: 150px;
    }
    
    .wealth-card {
        padding: 1rem;
        flex-direction: column;
        text-align: center;
    }
    
    .wealth-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }
    
    .wealth-amount {
        font-size: 1.5rem;
    }
    
    .rpg-items-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 0 0.5rem;
    }
    
    .rpg-card-header {
        padding: 0.75rem;
    }
    
    .ability-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        margin-right: 0.75rem;
    }
    
    .ability-name {
        font-size: 1rem;
    }
    
    .rpg-info-btn {
        width: 30px;
        height: 30px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .rpg-title {
        font-size: 1.5rem;
    }
    
    .wealth-amount {
        font-size: 1.25rem;
    }
    
    .rpg-card-body {
        padding: 0.75rem;
    }
    
    .rpg-description {
        padding: 0.75rem;
        font-size: 0.85rem;
    }
}

/* Dark mode enhancements */
@media (prefers-color-scheme: dark) {
    .rpg-store-container {
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #000000 100%);
    }
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
