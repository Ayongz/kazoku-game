@extends('layouts.app')

@section('content')
<div class="rpg-dashboard-container @if($isNightTime) night-theme @else day-theme @endif">
    <!-- RPG Background Elements -->
    <div class="rpg-background @if($isNightTime) night-particles @else day-particles @endif">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container pt-1" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                
                <!-- RPG Header -->
                <div class="rpg-header text-center mb-4">
                    @if($isNightTime)
                        <!-- Night Mode Awesome Header -->
                        <div class="rpg-night-header-container">
                            <div class="mystical-background-overlay"></div>
                            <div class="floating-runes">
                                <span class="rune rune-1">🌙</span>
                                <span class="rune rune-2">⭐</span>
                                <span class="rune rune-3">🔮</span>
                                <span class="rune rune-4">✨</span>
                                <span class="rune rune-5">🌟</span>
                            </div>
                            <div class="night-crown-container">
                                <i class="fas fa-crown night-crown-icon"></i>
                                <div class="crown-glow-effect"></div>
                            </div>
                            <h1 class="rpg-title-night-enhanced">
                                <span class="title-main">{{ __('nav.the_game_dashboard') }}</span>
                            </h1>
                            <div class="night-subtitle">
                                <span class="mystical-text" style="color: white !important;">🌙 {{ __('nav.opening_treasures_risk') }} 🌙</span>
                            </div>
                            <div class="night-title-decoration">
                                <div class="magic-line left-line"></div>
                                <div class="center-crystal">💎</div>
                                <div class="magic-line right-line"></div>
                            </div>
                        </div>
                    @else
                        <!-- Day Mode Header -->
                        <div class="store-title-container">
                            <h1 class="rpg-title-enhanced">
                                <i class="fas fa-crown me-2"></i>{{ __('nav.the_game_dashboard') }}
                            </h1>
                            <div class="title-decoration-enhanced"></div>
                        </div>
                    @endif
                </div>

                <!-- RPG Time Mode & Game Actions Row - Optimized -->
                <div class="row mb-3">
                    <!-- RPG Time Mode Indicator - Compact -->
                    <div class="col-12 col-lg-5 mb-3 mb-lg-0">
                        @if($isNightTime)
                            <div class="rpg-time-indicator rpg-night-mode h-100 compact-mode">
                                <div class="time-indicator-content-compact">
                                    <div class="time-header">
                                        <div class="time-info-compact">
                                            <h6 class="time-title-compact" style="color: #ffffff; font-weight: 700;">{{ __('nav.night_mode') }}</h6>
                                            <small class="time-description-compact" style="color: #ffffff; font-weight: 500;">{{ __('nav.opening_treasures_risk') }}</small>
                                        </div>
                                    </div>
                                    <div class="risk-indicators-compact">
                                        <span class="risk-item risk-danger" style="color: #ffffff; font-weight: 600;">25% {{ __('nav.chance_to_lose_money') }}</span><br>
                                        <span class="risk-item risk-success" style="color: #ffffff; font-weight: 600;">25% {{ __('nav.chance_for_bonus') }}</span><br>
                                        <span class="risk-item risk-rare" style="color: #ffffff; font-weight: 600;">5% {{ __('nav.chance_rare_treasure') }}</span><br>
                                        <span class="risk-item risk-normal" style="color: #ffffff; font-weight: 600;">45% {{ __('nav.chance_normal') }}</span>
                                    </div>
                                    <div class="time-action pt-2">
                                        <a href="{{ route('game.logs') }}" class="btn btn-sm btn-outline-light compact-btn">
                                            <i class="fas fa-scroll me-1"></i>{{ __('nav.view_logs') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rpg-time-indicator rpg-day-mode h-100 compact-mode">
                                <div class="time-indicator-content-compact">
                                    <div class="time-header">
                                        <div class="time-info-compact">
                                            <h6 class="time-title-compact" style="color: #000000; font-weight: 700;">{{ __('nav.day_mode') }}</h6>
                                            <small class="time-description-compact" style="color: #000000; font-weight: 500;">{{ __('nav.treasure_opening_safe') }}</small>
                                        </div>
                                    </div>
                                    <div class="time-action">
                                        <a href="{{ route('game.logs') }}" class="btn btn-sm btn-outline-dark compact-btn">
                                            <i class="fas fa-scroll me-1"></i>{{ __('nav.view_logs') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Game Actions Section (Treasure Chamber) - Compact -->
                    <div class="col-12 col-lg-7">
                        <div class="rpg-panel panel-main position-relative overflow-hidden h-100 compact-panel">
                            <!-- Background Pattern -->
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0.03; background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"treasure-pattern\" x=\"0\" y=\"0\" width=\"20\" height=\"20\" patternUnits=\"userSpaceOnUse\"><circle cx=\"10\" cy=\"10\" r=\"2\" fill=\"%23ffd700\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23treasure-pattern)\"/></svg>'); background-repeat: repeat;"></div>
                            
                            <div class="panel-content p-3">
                                <!-- Header Section - Compact -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rpg-section-header">
                                        <h5 class="rpg-title-compact text-white mb-1">
                                            <i class="fas fa-treasure-chest me-2 text-warning"></i>
                                            Treasure Chamber
                                        </h5>
                                    </div>
                                    
                                    <!-- Auto Click Toggle (Level 2+ Required) -->
                                    @if($user->level >= 2)
                                        <div class="rpg-toggle-container-compact">
                                            <div class="form-check form-switch rpg-switch">
                                                <input class="form-check-input rpg-switch-input" type="checkbox" id="autoClickToggle" 
                                                       @if($user->treasure <= 0) disabled @endif>
                                                <label class="form-check-label rpg-switch-label fw-bold" for="autoClickToggle">
                                                    <i class="fas fa-magic me-1"></i>
                                                    <span class="d-none d-md-inline">Auto Click</span>
                                                    <span class="d-md-none">Auto Click</span>
                                                </label>
                                            </div>
                                        </div>
                                    @else
                                        <div class="rpg-locked-feature">
                                            <span class="badge bg-secondary small">
                                                <i class="fas fa-lock me-1"></i>
                                                Auto Click at Level 2
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Description - Compact -->
                                <!-- <div class="rpg-description-panel-compact mb-3">
                                    <div class="text-center">
                                        <p class="rpg-flavor-text-compact mb-2 small">
                                            {{ __('nav.click_to_earn_money') }}
                                        </p>
                                        @if($user->steal_level > 0)
                                            <div class="rpg-bonus-indicator-compact">
                                                <span class="badge bg-info bg-gradient small">
                                                    <i class="fas fa-mask me-1"></i>
                                                    <strong>{{ __('nav.bonus') }}:</strong> {{ __('nav.steal_bonus', ['percent' => $user->steal_level * 5]) }}
                                                </span>
                                            </div>
                                        @endif
                                        @if($user->level < 2)
                                            <div class="rpg-bonus-indicator-compact mt-2">
                                                <span class="badge bg-warning text-dark small">
                                                    <i class="fas fa-lock me-1"></i>
                                                    <strong>Auto-click unlocks at Level 2</strong>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div> -->
                                
                                <!-- Treasure Section -->
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="rpg-treasure-display-compact text-center">
                                            @php
                                                // Treasure rarity configuration with random box chances
                                                $rarityConfig = [
                                                    0 => ['name' => 'Common', 'color' => '#6c757d', 'glow' => 'none', 'icon' => 'fas fa-box', 'chance' => 0],
                                                    1 => ['name' => 'Uncommon', 'color' => '#28a745', 'glow' => '0 0 10px rgba(40, 167, 69, 0.5)', 'icon' => 'fas fa-treasure-chest', 'chance' => 5],
                                                    2 => ['name' => 'Rare', 'color' => '#007bff', 'glow' => '0 0 15px rgba(0, 123, 255, 0.6)', 'icon' => 'fas fa-gem', 'chance' => 7],
                                                    3 => ['name' => 'Epic', 'color' => '#6f42c1', 'glow' => '0 0 20px rgba(111, 66, 193, 0.7)', 'icon' => 'fas fa-crown', 'chance' => 9],
                                                    4 => ['name' => 'Legendary', 'color' => '#fd7e14', 'glow' => '0 0 25px rgba(253, 126, 20, 0.8)', 'icon' => 'fas fa-fire', 'chance' => 11],
                                                    5 => ['name' => 'Mythic', 'color' => '#e83e8c', 'glow' => '0 0 30px rgba(232, 62, 140, 0.9)', 'icon' => 'fas fa-magic', 'chance' => 13],
                                                    6 => ['name' => 'Divine', 'color' => '#ffc107', 'glow' => '0 0 35px rgba(255, 193, 7, 1.0)', 'icon' => 'fas fa-sun', 'chance' => 15],
                                                    7 => ['name' => 'Celestial', 'color' => '#17a2b8', 'glow' => '0 0 40px rgba(23, 162, 184, 1.0)', 'icon' => 'fas fa-star', 'chance' => 17]
                                                ];
                                                $currentRarity = $rarityConfig[$user->treasure_rarity_level] ?? $rarityConfig[0];
                                            @endphp
                                            <!-- Treasure Type Display -->
                                            <div class="rpg-rarity-display-compact mb-3">
                                                <div class="rpg-rarity-badge-compact" style="background: linear-gradient(135deg, {{ $currentRarity['color'] }}, {{ $currentRarity['color'] }}cc);">
                                                    <i class="{{ $currentRarity['icon'] }} me-1"></i>
                                                    <span class="fw-bold">Treasure Type : {{ $currentRarity['name'] }}</span>
                                                </div>
                                                @if($currentRarity['chance'] > 0)
                                                    <div class="rpg-bonus-chance-compact mt-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-gift me-1 text-warning"></i>
                                                            {{ $currentRarity['chance'] }}% Random Box
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Open Treasure Buttons -->
                                            <div class="rpg-action-area-compact">
                                                <!-- Regular Treasure Button -->
                                                <form method="POST" action="{{ route('game.earn') }}" id="earnMoneyForm">
                                                    @csrf
                                                    <button type="submit" id="earnMoneyBtn"
                                                            class="rpg-button rpg-button-primary rpg-button-compact @if($user->treasure <= 0) rpg-button-disabled @endif"
                                                            @if($user->treasure <= 0) disabled @endif>
                                                        <div class="rpg-button-content">
                                                            @if($user->treasure > 0)
                                                                <i class="fas fa-hand-sparkles me-2"></i>
                                                                <span class="d-none d-md-inline">OPEN TREASURE</span>
                                                                <span class="d-md-none">OPEN TREASURE</span>
                                                            @else
                                                                <i class="fas fa-times-circle me-2"></i>
                                                                <span class="d-none d-md-inline">NO TREASURE</span>
                                                                <span class="d-md-none">NO TREASURE</span>
                                                            @endif
                                                        </div>
                                                        <div class="rpg-button-glow"></div>
                                                    </button>
                                                </form>
                                                
                                                <!-- Rare Treasure Button -->
                                                @if(($user->rare_treasures ?? 0) > 0)
                                                    <form method="POST" action="{{ route('game.open-rare-treasure') }}" class="mt-2">
                                                        @csrf
                                                        <button type="submit" class="rpg-button rpg-button-legendary rpg-button-compact">
                                                            <div class="rpg-button-content">
                                                                <i class="fas fa-star me-2"></i>
                                                                <span class="d-none d-md-inline">OPEN RARE TREASUE</span>
                                                                <span class="d-md-none">OPEN RARE TREASURE</span>
                                                            </div>
                                                            <div class="rpg-button-glow"></div>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Steal Success Message -->
                                @if (session('success') && (str_contains(session('success'), 'Heist successful!') || str_contains(session('success'), 'BONUS: Stole')))
                                    <div id="stealSuccessMessage" class="mt-3">
                                        <div class="rpg-alert rpg-alert-success">
                                            <div class="rpg-alert-icon">
                                                <i class="fas fa-mask"></i>
                                            </div>
                                            <div class="rpg-alert-content">
                                                <strong>{{ session('success') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Auto Click Status -->
                                <div id="autoClickStatus" class="mt-3" style="display: none;">
                                    <div class="rpg-alert rpg-alert-info">
                                        <div class="rpg-alert-icon">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <div class="rpg-alert-content">
                                            <strong>Auto Click Active:</strong> <span id="autoClickCounter">0</span> treasures opened
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RPG Status Messages -->
                @if (session('success') && !str_contains(session('success'), 'Heist successful!') && !str_contains(session('success'), 'BONUS: Stole'))
                    <div class="rpg-notification rpg-notification-success mb-4 alert alert-dismissible" role="alert">
                        <div class="rpg-notification-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="rpg-notification-content">
                            <div class="rpg-notification-title">{{ __('nav.success') }}!</div>
                            <div class="rpg-notification-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="rpg-notification-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="rpg-notification rpg-notification-error mb-4 alert alert-dismissible" role="alert">
                        <div class="rpg-notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="rpg-notification-content">
                            <div class="rpg-notification-title">{{ __('nav.error') }}!</div>
                            <div class="rpg-notification-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="rpg-notification-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <!-- RPG Player Stats Grid - Optimized -->
                <div class="row g-2">
                    <!-- Player Money Card -->
                    <div class="col-6 col-md-4 col-lg-2-4 mb-3">
                        <div class="rpg-stat-card-compact stat-money">
                            <div class="rpg-stat-icon-compact">
                                <i class="fas fa-coins"></i>
                            </div>
                            <h6 class="rpg-stat-label-compact">{{ __('nav.money_earned') }}</h6>
                            <h5 class="rpg-stat-value-compact" id="playerMoneyDisplay">
                                <span class="d-none d-sm-inline">IDR </span>{{ number_format($user->money_earned, 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                    <!-- Treasure Card -->
                    <div class="col-6 col-md-4 col-lg-2-4 mb-3">
                        <div class="rpg-stat-card-compact stat-treasure">
                            <div class="rpg-stat-icon-compact">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h6 class="rpg-stat-label-compact">{{ __('nav.current_treasure') }}</h6>
                            <h5 class="rpg-stat-value-compact @if($user->treasure > 0) text-warning @else text-danger @endif" id="playerTreasureDisplay">
                                {{ $user->treasure }}/{{ 20 + ($user->treasure_multiplier_level * 5) }}
                                @if(($user->rare_treasures ?? 0) > 0)
                                    <span class="rare-treasure-indicator-compact ms-1">
                                        <i class="fas fa-star text-warning"></i>{{ $user->rare_treasures }}
                                    </span>
                                @endif
                            </h5>
                            <div class="rpg-stat-details-compact">
                                @php
                                    $fastRecoveryIntervals = [60, 55, 50, 45, 40, 30];
                                    $currentInterval = $fastRecoveryIntervals[$user->fast_recovery_level ?? 0];
                                @endphp
                                <small>+5/{{ $currentInterval }}min</small>
                                @if(($user->rare_treasures ?? 0) > 0)
                                    <br><small class="text-warning">Rare Treasure: {{ $user->rare_treasures }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Random Box Card -->
                    <div class="col-6 col-md-4 col-lg-2-4 mb-3">
                        <div class="rpg-stat-card-compact stat-boxes">
                            <div class="rpg-stat-icon-compact">
                                <i class="fas fa-gift"></i>
                            </div>
                            <h6 class="rpg-stat-label-compact">{{ __('nav.random_boxes') }}</h6>
                            <h5 class="rpg-stat-value-compact" id="playerRandomBoxDisplay">
                                {{ $user->randombox ?? 0 }}
                            </h5>
                            <div class="rpg-stat-details-compact">
                                @if($user->treasure_rarity_level > 0)
                                    <small>Rarity Lv{{ $user->treasure_rarity_level }}</small>
                                @else
                                    <small>Common only</small>
                                @endif
                            </div>
                            @if(($user->randombox ?? 0) > 0)
                                <div class="rpg-stat-action-compact">
                                    <a href="{{ route('game.inventory') }}" class="btn btn-xs btn-outline-dark">
                                        <i class="fas fa-gift me-1"></i>Open
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shield Card -->
                    <div class="col-6 col-md-4 col-lg-2-4 mb-3">
                        <div class="rpg-stat-card-compact stat-shield">
                            <div class="rpg-stat-icon-compact">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h6 class="rpg-stat-label-compact">{{ __('nav.shield_protection') }}</h6>
                            @if($user->shield_expires_at && $user->shield_expires_at > now())
                                <h5 class="rpg-stat-value-compact text-success">
                                    {{ __('nav.active') }}
                                </h5>
                                <div class="rpg-stat-details-compact">
                                    <small>Until {{ $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('H:i') }}</small>
                                </div>
                            @else
                                <h5 class="rpg-stat-value-compact text-secondary">
                                    {{ __('nav.inactive') }}
                                </h5>
                                <div class="rpg-stat-action-compact">
                                    <a href="{{ route('store.index') }}" class="btn btn-xs btn-outline-dark">
                                        <i class="fas fa-shopping-cart me-1"></i>Buy
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Global Prize Pool Card -->
                    <div class="col-12 col-md-4 col-lg-2-4 mb-3">
                        <div class="rpg-stat-card-compact stat-prize">
                            <div class="rpg-stat-icon-compact">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h6 class="rpg-stat-label-compact">{{ __('nav.global_prize_pool') }}</h6>
                            <h5 class="rpg-stat-value-compact" id="globalPrizePoolDisplay">
                                <span class="d-none d-sm-inline">IDR </span>{{ number_format($globalPrizePool, 0, ',', '.') }}
                            </h5>
                            <div class="rpg-stat-details-compact">
                                <small>Daily distributed</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Player Level & Experience and Class System Row -->
                <div class="row">
                    <!-- Player Level & Experience Card - Optimized -->
                    <div class="col-12 col-lg-7">
                        <div class="rpg-panel panel-main">
                            <div class="panel-content p-3">
                                <div class="row align-items-center">
                                    <div class="col-auto text-center">
                                        <!-- Profile Picture - Compact -->
                                        <div class="rpg-profile-picture-compact">
                                            <img src="{{ \App\Http\Controllers\ProfileController::getProfilePictureUrl($user) }}" 
                                                 alt="{{ $user->name }}'s Profile Picture" 
                                                 class="rpg-avatar-compact">
                                            <div class="rpg-avatar-border-compact"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="rpg-title-compact text-white mb-1">
                                                    <i class="fas fa-star me-1 text-warning"></i>{{ $user->name }}
                                                </h5>
                                                <h4 class="rpg-level-compact text-warning mb-2" id="playerLevelDisplay">
                                                    {{ __('nav.level') }} {{ $user->level }}
                                                </h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-light d-block">{{ __('nav.player_level') }}</small>
                                                <small class="text-muted">{{ number_format($user->experience) }} EXP</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Experience Progress - Compact -->
                                        <div class="exp-section-compact">
                                            @php
                                                use App\Services\ExperienceService;
                                                $expToNext = ExperienceService::getExpToNextLevel($user->experience, $user->level);
                                                $expProgress = ExperienceService::getExpProgressPercentage($user->experience, $user->level);
                                            @endphp
                                            <div class="progress progress-compact mb-1" style="height: 8px; border-radius: 6px; background: rgba(255,255,255,0.1);">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $expProgress }}%; background: linear-gradient(90deg, #ffd700, #ffed4e);" 
                                                     aria-valuenow="{{ $expProgress }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-light">{{ number_format($expProgress, 1) }}% Progress</small>
                                                <small class="text-white" id="playerExpDisplay">{{ number_format($expToNext) }} EXP to next</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Class System Section -->
                    @if($user->canSelectClass() || $user->canAdvanceClass() || $user->selected_class || $user->level < 4)
                    <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                        <div class="rpg-panel panel-class position-relative overflow-hidden h-100">
                            <!-- Magical Background Effect -->
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; opacity: 0.05; background: radial-gradient(circle at 20% 30%, #6f42c1 0%, transparent 50%), radial-gradient(circle at 80% 70%, #e83e8c 0%, transparent 50%), radial-gradient(circle at 40% 80%, #fd7e14 0%, transparent 50%);"></div>
                            
                            <div class="panel-content p-3">
                                @if($user->selected_class)
                                    <!-- Current Class Display -->
                                    <div class="rpg-class-display">
                                        <div class="d-flex flex-column">
                                            <div class="rpg-class-info flex-grow-1 mb-3">
                                                <div class="rpg-class-header mb-3">
                                                    <h3 class="rpg-class-title text-white mb-2">
                                                        <i class="fas fa-shield-alt me-2 text-warning"></i>
                                                        {{ $user->getClassDisplayName() }}
                                                    </h3>
                                                    <p class="rpg-class-description text-light mb-2 opacity-90">
                                                        {{ $user->getClassDescription() }}
                                                    </p>
                                                    @if($user->class_selected_at)
                                                        <small class="text-light opacity-60">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Class selected on {{ $user->class_selected_at->format('M d, Y') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="rpg-class-actions text-center">
                                                @if($user->canAdvanceClass())
                                                    <form action="{{ route('game.advance-class') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="rpg-button rpg-button-legendary rpg-button-large">
                                                            <div class="rpg-button-content">
                                                                <i class="fas fa-star me-2"></i>
                                                                Advance Class
                                                            </div>
                                                            <div class="rpg-button-glow"></div>
                                                        </button>
                                                    </form>
                                                    <div class="mt-2">
                                                        <small class="text-light opacity-75">
                                                            <i class="fas fa-magic me-1"></i>
                                                            Unlock enhanced abilities!
                                                        </small>
                                                    </div>
                                                @elseif($user->has_advanced_class)
                                                    <div class="rpg-advanced-badge">
                                                        <div class="badge bg-warning bg-gradient text-dark px-3 py-2" style="font-size: 1rem;">
                                                            <i class="fas fa-crown me-1"></i>
                                                            ADVANCED CLASS
                                                            <i class="fas fa-crown ms-1"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @elseif($user->canSelectClass())
                                    <!-- Class Selection Available -->
                                    <div class="rpg-class-selection text-center">
                                        <div class="rpg-section-header mb-4">
                                            <h3 class="rpg-title text-white mb-3">
                                                <i class="fas fa-star me-2 text-warning" style="animation: pulse 2s infinite;"></i>
                                                Class Selection Available!
                                            </h3>
                                            <p class="rpg-subtitle text-light opacity-90 mb-4">
                                                You've reached level {{ $user->level }}! Choose a class to unlock special abilities.
                                            </p>
                                        </div>
                                        
                                        <div class="rpg-action-area">
                                            <a href="{{ route('game.class-selection') }}" class="rpg-button rpg-button-epic rpg-button-large">
                                                <div class="rpg-button-content">
                                                    <i class="fas fa-magic me-2"></i>
                                                    Choose Your Destiny
                                                </div>
                                                <div class="rpg-button-glow"></div>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <!-- Class Requirement Not Met -->
                                    <div class="rpg-class-locked text-center">
                                        <div class="rpg-section-header mb-4">
                                            <h3 class="rpg-title text-white mb-3">
                                                <i class="fas fa-lock me-2 text-secondary"></i>
                                                Class System
                                            </h3>
                                            <p class="rpg-subtitle text-light opacity-90 mb-3">
                                                Unlock powerful class abilities and enhance your treasure hunting journey!
                                            </p>
                                        </div>
                                        
                                        <div class="rpg-requirement-info">
                                            <div class="rpg-requirement-badge">
                                                <i class="fas fa-star text-warning me-2"></i>
                                                <strong class="text-white">Level 4 Required</strong>
                                            </div>
                                            <!-- <div class="mt-3">
                                                <p class="text-light opacity-75 small mb-2">
                                                    Current Level: <strong class="text-warning">{{ $user->level }}</strong>
                                                </p>
                                                <p class="text-light opacity-75 small">
                                                    Levels to go: <strong class="text-info">{{ 4 - $user->level }}</strong>
                                                </p>
                                            </div> -->
                                        </div>
                                        
                                        <!-- <div class="rpg-class-preview">
                                            <small class="text-light opacity-60">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Classes provide unique abilities like enhanced treasure finding, combat skills, and special bonuses!
                                            </small>
                                        </div> -->
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                </br>
        </div>
    </div>
</div>

<!-- Auto Click JavaScript -->
<style>
    /* === RPG THEME STYLING === */
    
    /* Remove all shadow effects globally */
    * {
        text-shadow: none !important;
        box-shadow: none !important;
        filter: none !important;
    }
    
    /* Main Container Background */
    .container-fluid {
        position: relative;
        min-height: 100vh;
    }
    
    .container-fluid::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(59,130,246,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(139,92,246,0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(245,158,11,0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
        animation: backgroundShift 20s ease-in-out infinite;
    }
    
    @keyframes backgroundShift {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 0.8; }
    }
    
    /* Rare Treasure Indicator Styling */
    .rare-treasure-indicator {
        font-size: 0.8em;
        padding: 2px 6px;
        background: linear-gradient(45deg, #ffd700, #ffed4e);
        border-radius: 12px;
        color: #333;
    }

    @keyframes rareTreasureGlow {
        from { opacity: 1; }
        to { opacity: 0.8; }
    }
    
    /* Time Indicator Content Visibility Fix */
    .time-indicator-content {
        background-color: #6f42c1;
        color: #000000dc !important;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: space-between;
    }

    .time-indicator-content .time-icon, .time-indicator-content .time-info, .time-indicator-content .time-badge {
        padding: 5px;
    }

    .time-indicator-content .time-title {
        color: black !important;
        font-weight: 600 !important;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }
    
    .time-indicator-content .time-description {
        color: black !important;
        font-weight: 500 !important;
        font-size: 0.875rem;
        line-height: 1.4;
    }
    
    .time-indicator-content .mode-label {
        color: black !important;
        font-weight: 600 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .time-icon {
        text-align: center;
        margin-bottom: 0.75rem;
    }
    
    .time-icon i {
        font-size: 2rem;
        color: #ffd700;
    }
    
    .time-badge {
        text-align: center;
        margin-top: 0.75rem;
    }
    
    .risk-indicators span {
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }
    
    .risk-danger, .risk-success, .risk-normal, .risk-rare {
        font-weight: 600 !important;
        color: black !important;
    }
    
    /* Responsive adjustments for side-by-side layout */
    @media (max-width: 991.98px) {
        .time-indicator-content {
            padding: 1rem;
        }
        
        .time-icon i {
            font-size: 1.5rem;
        }
        
        .time-indicator-content .time-title {
            font-size: 0.9rem;
        }
        
        .time-indicator-content .time-description {
            font-size: 0.8rem;
        }
    }
    
    /* Time Indicator Content Compact Styles */
    .time-indicator-content-compact {
        padding: 1rem;
        border-radius: 10px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .rpg-night-mode .time-indicator-content-compact {
        background: linear-gradient(135deg, #c5ceddff 0%, #1a202c 100%);
        border: 2px solid #738096ff;
        color: black !important;
    }
    
    .rpg-day-mode .time-indicator-content-compact {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: 2px solid #cbd5e0;
        color: #1a202c !important;
    }
    
    .rpg-night-mode .time-indicator-content-compact * {
        color: black !important;
    }
    
    .rpg-day-mode .time-indicator-content-compact * {
        color: #1a202c !important;
    }
    
    .container-fluid > .container {
        position: relative;
        z-index: 10;
    }
    
    /* General Text Visibility Improvements */
    .rpg-dashboard-container {
        color: #1a202c;
        position: relative;
        padding: 1rem 0;
        transition: background 0.5s ease;
    }

    /* Day Theme Background */
    .rpg-dashboard-container.day-theme {
        background: linear-gradient(135deg, 
            #f8fafc 0%, 
            #e2e8f0 25%, 
            #cbd5e0 50%, 
            #a0aec0 75%, 
            #718096 100%
        );
    }

    /* Night Theme Background */
    .rpg-dashboard-container.night-theme {
        background: linear-gradient(135deg, 
            #1a202c 0%, 
            #2d3748 25%, 
            #4a5568 50%, 
            #2d3748 75%, 
            #1a202c 100%
        );
    }

    /* Enhanced background effects for day/night - contained within dashboard */
    .rpg-dashboard-container.day-theme::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(255,193,7,0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(59,130,246,0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(16,185,129,0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
        animation: dayBackgroundShift 25s ease-in-out infinite;
    }

    .rpg-dashboard-container.night-theme::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(139,92,246,0.2) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(59,130,246,0.15) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(6,182,212,0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
        animation: nightBackgroundShift 30s ease-in-out infinite;
    }

    @keyframes dayBackgroundShift {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 0.9; }
    }

    @keyframes nightBackgroundShift {
        0%, 100% { opacity: 0.8; }
        50% { opacity: 1.0; }
    }

    /* Day/Night Particle Themes */
    .rpg-background.day-particles .floating-particles::before {
        background-image: 
            radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.6), transparent),
            radial-gradient(2px 2px at 40px 70px, rgba(34,197,94,0.4), transparent),
            radial-gradient(1px 1px at 90px 40px, rgba(59,130,246,0.5), transparent),
            radial-gradient(3px 3px at 160px 30px, rgba(245,158,11,0.3), transparent);
    }

    .rpg-background.night-particles .floating-particles::before {
        background-image: 
            radial-gradient(2px 2px at 20px 30px, rgba(139,92,246,0.6), transparent),
            radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.5), transparent),
            radial-gradient(1px 1px at 90px 40px, rgba(6,182,212,0.4), transparent),
            radial-gradient(3px 3px at 160px 30px, rgba(147,51,234,0.3), transparent);
    }

    .rpg-background.day-particles .magic-orbs::before,
    .rpg-background.day-particles .magic-orbs::after {
        background: radial-gradient(circle, #fbbf24 0%, #f59e0b 100%);
        box-shadow: 0 0 15px #fbbf24;
    }

    .rpg-background.night-particles .magic-orbs::before,
    .rpg-background.night-particles .magic-orbs::after {
        background: radial-gradient(circle, #8b5cf6 0%, #7c3aed 100%);
        box-shadow: 0 0 15px #8b5cf6;
    }
    
    .rpg-header {
        color: #1a202c !important;
    }

    /* === AWESOME NIGHT MODE HEADER STYLING === */
    .rpg-night-header-container {
        position: relative;
        padding: 2rem 1rem;
        margin: 0 0 2rem 0;
        background: linear-gradient(135deg, 
            rgba(17,24,39,0.9) 0%, 
            rgba(31,41,55,0.95) 25%, 
            rgba(55,65,81,0.9) 50%, 
            rgba(31,41,55,0.95) 75%, 
            rgba(17,24,39,0.9) 100%
        );
        border-radius: 20px;
        border: 2px solid rgba(139,92,246,0.3);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .mystical-background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 30%, rgba(139,92,246,0.1) 0%, transparent 40%),
            radial-gradient(circle at 80% 70%, rgba(99,102,241,0.08) 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, rgba(168,85,247,0.05) 0%, transparent 60%);
        animation: mysticalPulse 8s ease-in-out infinite;
    }

    @keyframes mysticalPulse {
        0%, 100% { opacity: 0.5; }
        50% { opacity: 1; }
    }

    /* Floating Runes */
    .floating-runes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }

    .rune {
        position: absolute;
        font-size: 1.5rem;
        opacity: 0.6;
        animation: floatRune 6s ease-in-out infinite;
    }

    .rune-1 {
        top: 15%;
        left: 10%;
        animation-delay: 0s;
        filter: drop-shadow(0 0 10px rgba(139,92,246,0.8));
    }

    .rune-2 {
        top: 20%;
        right: 15%;
        animation-delay: 1.2s;
        filter: drop-shadow(0 0 8px rgba(99,102,241,0.7));
    }

    .rune-3 {
        bottom: 25%;
        left: 20%;
        animation-delay: 2.4s;
        filter: drop-shadow(0 0 12px rgba(168,85,247,0.9));
    }

    .rune-4 {
        bottom: 20%;
        right: 25%;
        animation-delay: 3.6s;
        filter: drop-shadow(0 0 6px rgba(147,51,234,0.6));
    }

    .rune-5 {
        top: 50%;
        left: 5%;
        animation-delay: 4.8s;
        filter: drop-shadow(0 0 14px rgba(79,70,229,0.8));
    }

    @keyframes floatRune {
        0%, 100% { 
            transform: translateY(0px) rotate(0deg); 
            opacity: 0.6; 
        }
        50% { 
            transform: translateY(-15px) rotate(180deg); 
            opacity: 1; 
        }
    }

    /* Night Crown */
    .night-crown-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .night-crown-icon {
        font-size: 3rem;
        color: #fbbf24;
        z-index: 3;
        position: relative;
        filter: drop-shadow(0 0 20px rgba(251,191,36,0.8));
        animation: crownPulse 3s ease-in-out infinite;
    }

    .crown-glow-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(251,191,36,0.3) 0%, transparent 70%);
        animation: crownGlow 4s ease-in-out infinite;
    }

    @keyframes crownPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    @keyframes crownGlow {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.5; 
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.3);
            opacity: 0.8; 
        }
    }

    /* Enhanced Night Title */
    .rpg-title-night-enhanced {
        position: relative;
        font-size: 2.5rem;
        font-weight: 900;
        letter-spacing: 3px;
        margin: 1rem 0;
        z-index: 2;
    }

    .title-main {
        position: relative;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 50%, #e2e8f0 100%);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        z-index: 2;
        filter: drop-shadow(0 0 10px rgba(226,232,240,0.5));
    }

    .title-glow {
        position: absolute;
        top: 0;
        left: 0;
        color: rgba(139,92,246,0.4);
        z-index: 0;
        animation: titleGlow 4s ease-in-out infinite;
    }

    @keyframes titleGlow {
        0%, 100% { 
            transform: scale(1);
            opacity: 0.4; 
        }
        50% { 
            transform: scale(1.02);
            opacity: 0.7; 
        }
    }

    /* Night Subtitle */
    .night-subtitle {
        margin: 1rem 0;
    }

    .mystical-text {
        font-size: 1.1rem;
        color: #ffffffff !important;
        font-style: italic;
        font-weight: 600;
        letter-spacing: 1px;
        filter: drop-shadow(0 0 8px rgba(167,139,250,0.6));
        animation: mysticalGlow 3s ease-in-out infinite;
    }

    @keyframes mysticalGlow {
        0%, 100% { opacity: 0.8; }
        50% { opacity: 1; }
    }

    /* Night Title Decoration */
    .night-title-decoration {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1.5rem;
        gap: 1rem;
    }

    .magic-line {
        height: 2px;
        flex: 1;
        max-width: 150px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(139,92,246,0.8) 20%, 
            rgba(168,85,247,1) 50%, 
            rgba(139,92,246,0.8) 80%, 
            transparent 100%
        );
        animation: magicLineGlow 4s ease-in-out infinite;
    }

    .center-crystal {
        font-size: 1.5rem;
        filter: drop-shadow(0 0 15px rgba(168,85,247,0.8));
        animation: crystalSpin 8s linear infinite;
    }

    @keyframes magicLineGlow {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 1; }
    }

    @keyframes crystalSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .rpg-night-header-container {
            padding: 1.5rem 0.5rem;
            margin: -0.5rem -0.5rem 1.5rem -0.5rem;
        }
        
        .rpg-title-night-enhanced {
            font-size: 1.8rem;
            letter-spacing: 2px;
        }
        
        .night-crown-icon {
            font-size: 2.5rem;
        }
        
        .rune {
            font-size: 1.2rem;
        }
        
        .mystical-text {
            font-size: 1rem;
        }
    }
    
    .rpg-header * {
        color: #1a202c !important;
    }
    
    /* Default text colors - black for light backgrounds */
    .rpg-dashboard-container,
    .rpg-dashboard-container h1,
    .rpg-dashboard-container h2,
    .rpg-dashboard-container h3,
    .rpg-dashboard-container h4,
    .rpg-dashboard-container h5,
    .rpg-dashboard-container h6,
    .rpg-dashboard-container p,
    .rpg-dashboard-container div,
    .rpg-dashboard-container span,
    .rpg-dashboard-container small,
    .rpg-dashboard-container strong,
    .rpg-dashboard-container label {
        color: #000000 !important;
    }
    
    /* Stat cards text - black for light background */
    .rpg-stat-card-compact,
    .rpg-stat-card-compact *,
    .rpg-stat-label-compact,
    .rpg-stat-value-compact,
    .rpg-stat-details-compact {
        color: #000000 !important;
    }
    
    /* Notifications text - black */
    .rpg-notification-title,
    .rpg-notification-message {
        color: #000000 !important;
    }
    
    /* Dark background panels - keep white text */
    .rpg-panel:not(.panel-main),
    .rpg-panel:not(.panel-main) *,
    .panel-class,
    .panel-class * {
        color: #ffffff !important;
    }
    
    /* Time indicator night mode - white text on dark background */
    .rpg-night-mode,
    .rpg-night-mode * {
        color: #ffffff !important;
    }
    
    /* Time indicator day mode - black text on light background */
    .rpg-day-mode,
    .rpg-day-mode * {
        color: #000000 !important;
    }
    
    /* Class system panels - white text on dark background */
    .rpg-class-display,
    .rpg-class-display *,
    .rpg-class-selection,
    .rpg-class-selection *,
    .rpg-class-locked,
    .rpg-class-locked * {
        color: #ffffff !important;
    }
    
    /* Override specific utility classes when needed */
    .rpg-panel:not(.panel-main) .text-white,
    .panel-class .text-white,
    .rpg-night-mode .text-white {
        color: #ffffff !important;
    }
    
    /* Icons and warnings should keep their colors */
    .text-warning,
    .text-danger,
    .text-success,
    .text-info {
        color: inherit !important;
    }
    
    /* Floating Mystical Elements */
    .container-fluid::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
            radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
            radial-gradient(1px 1px at 90px 40px, rgba(139,92,246,0.4), transparent),
            radial-gradient(1px 1px at 130px 80px, rgba(245,158,11,0.3), transparent),
            radial-gradient(2px 2px at 160px 30px, rgba(34,197,94,0.3), transparent);
        background-repeat: repeat;
        background-size: 200px 100px;
        animation: mysticFloat 15s linear infinite;
        pointer-events: none;
        z-index: 0;
    }
    
    @keyframes mysticFloat {
        0% { transform: translateY(0px) translateX(0px); }
        25% { transform: translateY(-10px) translateX(5px); }
        50% { transform: translateY(-20px) translateX(0px); }
        75% { transform: translateY(-10px) translateX(-5px); }
        100% { transform: translateY(0px) translateX(0px); }
    }
    
    /* RPG Panels */
    .rpg-panel {
        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        border: 2px solid #4a5568;
        border-radius: 15px;
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
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .rpg-panel:hover::before {
        opacity: 1;
    }
    
    .panel-main {
        background: linear-gradient(135deg, #f5f5f5 0%, #e5e5e5 100%);
        border-color: #4299e1;
        color: #000000 !important;
    }
    
    .panel-main * {
        color: #000000 !important;
    }
    
    .panel-main .text-white {
        color: #000000 !important;
    }
    
    .panel-main .text-warning {
        color: #f59e0b !important;
    }
    
    .panel-class {
        background: linear-gradient(135deg, #553c9a 0%, #6b46c1 50%, #7c3aed 100%);
        border-color: #8b5cf6;
    }
    
    .panel-content {
        position: relative;
        z-index: 1;
    }
    
    /* RPG Typography */
    .rpg-title {
        font-family: 'Segoe UI', system-ui, sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        color: #000000;
    }
    
    .rpg-subtitle {
        font-size: 0.9rem;
        color: #a0aec0;
        font-style: italic;
    }
    
    .rpg-flavor-text {
        color: #cbd5e0;
        font-size: 0.95rem;
        line-height: 1.4;
    }
    
    /* Section Headers */
    .rpg-section-header {
        margin-bottom: 1rem;
    }
    
    /* RPG Buttons */
    .rpg-button {
        position: relative;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        outline: none;
    }
    
    .rpg-button-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .rpg-button-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .rpg-button:hover .rpg-button-glow {
        transform: translateX(100%);
    }
    
    .rpg-button-large {
        padding: 12px 30px;
        font-size: 1rem;
    }
    
    .rpg-button-primary {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
    }
    
    .rpg-button-primary:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .rpg-button-epic {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }
    
    .rpg-button-epic:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .rpg-button-legendary {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .rpg-button-legendary:hover {
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .rpg-button-disabled {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #9ca3af;
        cursor: not-allowed;
    }
    
    .rpg-button-disabled:hover {
        transform: none;
    }
    
    /* Toggle Switch */
    .rpg-toggle-container {
        padding: 8px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }
    
    .rpg-switch-input {
        background-color: #4b5563;
        border-color: #6b7280;
    }
    
    .rpg-switch-input:checked {
        background-color: #4299e1;
        border-color: #3182ce;
    }
    
    .rpg-switch-label {
        color: #e2e8f0;
        margin-left: 0.5rem;
    }
    
    /* Locked Features */
    .rpg-locked-feature .badge {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        padding: 6px 12px;
        border-radius: 6px;
    }
    
    /* Description Panel */
    .rpg-description-panel {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .rpg-bonus-indicator .badge {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        padding: 6px 12px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(6,182,212,0.3);
        word-break: break-word;
        text-align: center;
        max-width: 100%;
        display: inline-block;
    }
    
    /* Treasure Display */
    .rpg-treasure-display {
        padding: 1rem;
    }
    
    .rpg-rarity-display {
        margin-bottom: 1.5rem;
    }
    
    .rpg-rarity-badge {
        display: inline-block;
        padding: 12px 20px;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border: 2px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(5px);
    }
    
    .rpg-bonus-chance {
        margin-top: 0.5rem;
    }
    
    .rpg-action-area {
        margin-top: 1.5rem;
    }
    
    /* Alerts */
    .rpg-alert {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        align-items: center;
        backdrop-filter: blur(10px);
    }
    
    .rpg-alert-success {
        background: rgba(34,197,94,0.2);
        border-color: rgba(34,197,94,0.3);
        color: #bbf7d0;
    }
    
    .rpg-alert-info {
        background: rgba(59,130,246,0.2);
        border-color: rgba(59,130,246,0.3);
        color: #bfdbfe;
    }
    
    .rpg-alert-icon {
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }
    
    .rpg-alert-content {
        flex: 1;
    }
    
    /* Enhanced RPG Notifications */
    .rpg-notification {
        background: linear-gradient(135deg, rgba(45,55,72,0.95) 0%, rgba(26,32,44,0.95) 100%);
        border: 2px solid #4a5568;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
    }
    
    .rpg-notification::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.05) 50%, transparent 70%);
        pointer-events: none;
    }
    
    .rpg-notification-success {
        border-color: #22c55e;
        background: linear-gradient(135deg, rgba(34,197,94,0.2) 0%, rgba(22,163,74,0.2) 100%);
    }
    
    .rpg-notification-success::before {
        background: linear-gradient(45deg, transparent 30%, rgba(34,197,94,0.1) 50%, transparent 70%);
    }
    
    .rpg-notification-error {
        border-color: #ef4444;
        background: linear-gradient(135deg, rgba(239,68,68,0.2) 0%, rgba(220,38,38,0.2) 100%);
    }
    
    .rpg-notification-error::before {
        background: linear-gradient(45deg, transparent 30%, rgba(239,68,68,0.1) 50%, transparent 70%);
    }
    
    .rpg-notification-icon {
        margin-right: 1rem;
        font-size: 1.5rem;
        position: relative;
        z-index: 1;
    }
    
    .rpg-notification-success .rpg-notification-icon {
        color: #22c55e;
    }
    
    .rpg-notification-error .rpg-notification-icon {
        color: #ef4444;
    }
    
    .rpg-notification-content {
        flex: 1;
        position: relative;
        z-index: 1;
    }
    
    .rpg-notification-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #000000;
    }
    
    .rpg-notification-message {
        font-size: 0.95rem;
        color: #000000;
        line-height: 1.4;
    }
    
    .rpg-notification-close {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 1.2rem;
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .rpg-notification-close:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.1);
        transform: scale(1.1);
    }
    
    /* RPG Profile Picture Styles */
    .rpg-profile-picture {
        position: relative;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    
    .rpg-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffd700;
        box-shadow: 
            0 0 15px rgba(255,215,0,0.4),
            0 4px 15px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    
    .rpg-avatar:hover {
        transform: scale(1.05);
        box-shadow: 
            0 0 20px rgba(255,215,0,0.6),
            0 6px 20px rgba(0,0,0,0.4);
    }
    
    .rpg-avatar-border {
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .rpg-profile-picture:hover .rpg-avatar-border {
        opacity: 1;
        animation: rotate 3s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .rpg-player-name {
        font-weight: 600;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    
    /* Responsive adjustments for profile picture */
    @media (max-width: 768px) {
        .rpg-avatar {
            width: 60px;
            height: 60px;
        }
        
        .rpg-player-name {
            font-size: 0.85rem;
        }
    }
    
    /* Class System Styles */
    .rpg-class-display {
        color: white;
    }
    
    .rpg-class-info {
        min-width: 0;
    }
    
    .rpg-class-header {
        margin-bottom: 1rem;
    }
    
    .rpg-class-title {
        font-size: 1.4rem;
        margin-bottom: 0.5rem;
    }
    
    .rpg-class-description {
        font-size: 1rem;
        line-height: 1.4;
    }
    
    .rpg-class-actions {
        flex-shrink: 0;
    }
    
    .rpg-class-selection {
        padding: 2rem 1rem;
    }
    
    /* .rpg-class-locked {
        padding: 2rem 1rem;
    } */
    
    .rpg-requirement-badge {
        background: linear-gradient(135deg, rgba(108,117,125,0.3) 0%, rgba(73,80,87,0.3) 100%);
        border: 2px solid #6c757d;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .rpg-class-preview {
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .rpg-advanced-badge {
        animation: glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes glow {
        from { filter: drop-shadow(0 0 5px rgba(255,193,7,0.3)); }
        to { filter: drop-shadow(0 0 15px rgba(255,193,7,0.7)); }
    }
    
    /* Stat Cards (Updated styles) */
    .rpg-stat-card {
        background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
        border: 2px solid #4b5563;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: white;
        height: 100%;
    }
    
    .rpg-stat-card:hover {
        transform: translateY(-5px);
        border-color: #6b7280;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    
    .rpg-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .rpg-stat-card:hover::before {
        opacity: 1;
    }
    
    .rpg-stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem auto;
        font-size: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .rpg-stat-icon::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .rpg-stat-card:hover .rpg-stat-icon::before {
        transform: translateX(100%);
    }
    
    .rpg-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    
    .rpg-stat-label {
        font-size: 0.875rem;
        color: #d1d5db;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }
    
    .rpg-stat-details {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }
    
    .rpg-stat-action {
        margin-top: auto;
    }
    
    .rpg-stat-action .btn {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    /* Specific stat card colors */
    .stat-money .rpg-stat-icon { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
    .stat-treasure .rpg-stat-icon { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); }
    .stat-boxes .rpg-stat-icon { background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); }
    .stat-shield .rpg-stat-icon { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
    .stat-prize .rpg-stat-icon { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .rpg-title {
            font-size: 1.3rem;
        }
        
        .rpg-button-large {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        
        .rpg-stat-card {
            margin-bottom: 1rem;
        }
        
        .rpg-bonus-indicator .badge {
            font-size: 0.7rem;
            padding: 4px 8px;
            line-height: 1.3;
        }
        
        .rpg-class-display .d-flex {
            flex-direction: column;
        }
        
        .rpg-class-actions {
            margin-top: 1rem;
            margin-left: 0 !important;
        }
    }
    
    /* Animation Classes */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% { transform: translate3d(0,0,0); }
        40%, 43% { transform: translate3d(0,-10px,0); }
        70% { transform: translate3d(0,-5px,0); }
        90% { transform: translate3d(0,-2px,0); }
    }
    
    /* 5-column responsive layout */
    @media (min-width: 992px) {
        .col-lg-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

    /* Auto-click specific animations */
    .money-update-animation {
        transition: all 0.5s ease;
    }
    
    .prize-pool-pulse {
        animation: pulse 0.5s ease-in-out;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .treasure-warning {
        animation: warning-blink 0.5s ease-in-out;
    }
    
    @keyframes warning-blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    @keyframes floatUp {
        0% {
            transform: translateY(0px);
            opacity: 1;
        }
        100% {
            transform: translateY(-50px);
            opacity: 0;
        }
    }
    
    @keyframes floatUpInCard {
        0% {
            transform: translateX(-50%) translateY(0px);
            opacity: 1;
        }
        100% {
            transform: translateX(-50%) translateY(-30px);
            opacity: 0;
        }
    }
    
    .floating-money-indicator {
        position: fixed !important;
        z-index: 9999 !important;
        font-weight: bold !important;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3) !important;
        color: #28a745 !important;
    }

    /* === COMPACT MODE STYLES === */
    
    /* Enhanced Title Styling */
    .rpg-title-enhanced {
        background: linear-gradient(135deg, #1f2937 0%, #374151 50%, #1f2937 100%);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
        letter-spacing: 2px;
        position: relative;
        z-index: 2;
        margin-bottom: 0;
        color: #1f2937 !important;
    }
    
    .rpg-title-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%, rgba(255,255,255,0.1) 100%);
        border-radius: 10px;
        z-index: -1;
    }
    
    /* Night Mode Title Styling */
    .rpg-title-enhanced.rpg-title-night {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #ffffff !important;
    }
    
    .rpg-title-enhanced.rpg-title-night::before {
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%, rgba(255,255,255,0.2) 100%);
    }
    
    /* Compact Mode Layouts */
    .compact-mode {
        padding: 0.5rem !important;
        margin: 0.25rem 0 !important;
    }
    
    .compact-mode h6 {
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
        color: #ffffff !important;
        font-weight: 600;
    }
    
    .compact-mode .small-time {
        font-size: 0.7rem;
        line-height: 1.2;
    }
    
    /* Compact Mode Night Time Text Visibility */
    .compact-mode .time-header {
        color: #ffffff !important;
    }
    
    .compact-mode .time-icon-compact {
        color: #ffffff !important;
    }
    
    .compact-mode .time-info-compact {
        color: #ffffff !important;
    }
    
    .compact-mode .time-title-compact {
        font-weight: 700;
    }
    
    /* .compact-mode .time-description-compact {
        color: #ffffff !important;
        font-weight: 500;
    } */
    
    .compact-mode .risk-indicators-compact {
        color: #ffffff !important;
    }
    
    .compact-mode .risk-item {
        color: #ffffff !important;
        font-weight: 600;
    }
    
    /* Compact Title Styles */
    .rpg-title-compact {
        font-size: 1rem !important;
        font-weight: 700;
        margin-bottom: 0.5rem !important;
    }
    
    /* Compact Toggle Container */
    .rpg-toggle-container-compact {
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    /* Compact Description Panel */
    .rpg-description-panel-compact {
        background: rgba(0,0,0,0.3);
        border-radius: 8px;
        padding: 0.75rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .rpg-flavor-text-compact {
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 0.5rem !important;
        color: #ffffff !important;
        font-weight: 600;
    }
    
    .rpg-bonus-indicator-compact {
        background: rgba(40, 167, 69, 0.2);
        border: 1px solid rgba(40, 167, 69, 0.3);
        border-radius: 6px;
        padding: 0.3rem 0.5rem;
    }
    
    .rpg-bonus-indicator-compact small {
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* Compact Treasure Display */
    .rpg-treasure-display-compact {
        margin: 1rem 0;
    }
    
    .rpg-rarity-display-compact {
        margin-bottom: 1rem !important;
    }
    
    .rpg-rarity-badge-compact {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    .rpg-bonus-chance-compact {
        margin-top: 0.5rem !important;
    }
    
    .rpg-action-area-compact {
        margin: 1rem 0;
    }
    
    /* Compact Button Styles */
    .rpg-button-compact {
        padding: 0.5rem 1rem !important;
        font-size: 0.9rem !important;
        min-height: 40px;
        border-radius: 8px;
    }
    
    .rpg-button-compact .rpg-button-content {
        font-size: 0.85rem;
    }
    
    /* Compact Stat Cards */
    .rpg-stat-card-compact {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 0.75rem;
        backdrop-filter: blur(10px);
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: #000000 !important;
    }
    
    .rpg-stat-card-compact * {
        color: #000000 !important;
    }
    
    .rpg-stat-card-compact:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        border-color: rgba(255,255,255,0.3);
    }
    
    .rpg-stat-icon-compact {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: rgba(255,255,255,0.9);
    }
    
    .rpg-stat-label-compact {
        font-size: 0.7rem;
        font-weight: 600;
        color: #000000 !important;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .rpg-stat-value-compact {
        font-size: 0.9rem;
        font-weight: 700;
        color: #000000 !important;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }
    
    .rpg-stat-details-compact {
        font-size: 0.65rem;
        color: #000000 !important;
        margin-top: 0.25rem;
    }
    
    .rpg-stat-action-compact {
        margin-top: 0.5rem;
    }
    
    .btn-xs {
        padding: 0.2rem 0.4rem;
        font-size: 0.7rem;
        border-radius: 4px;
    }
    
    .rare-treasure-indicator-compact {
        font-size: 0.7rem;
        color: #ffc107;
    }
    
    /* Class System Compact Styles */
    .rpg-class-panel-compact {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.1) 0%, rgba(232, 62, 140, 0.1) 100%);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
        padding: 1rem;
        backdrop-filter: blur(10px);
    }
    
    .rpg-section-title-compact {
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.75rem;
        text-align: center;
    }
    
    .rpg-class-card-compact {
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    
    .rpg-class-card-compact:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        border-color: rgba(255,255,255,0.3);
    }
    
    .rpg-class-icon-compact {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: rgba(255,255,255,0.9);
    }
    
    .rpg-class-name-compact {
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .rpg-class-level-compact {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }
    
    .level-badge-compact {
        padding: 0.2rem 0.5rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .level-badge-compact.level-active {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }
    
    .level-badge-compact.level-inactive {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        opacity: 0.7;
    }
    
    .rpg-class-level-compact small {
        font-size: 0.65rem;
        color: rgba(255,255,255,0.8);
        text-align: center;
    }
    
    /* Mobile Responsive Adjustments */
    @media (max-width: 576px) {
        .rpg-title-enhanced {
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        
        .compact-mode {
            padding: 0.3rem !important;
        }
        
        .rpg-stat-card-compact {
            padding: 0.5rem;
        }
        
        .rpg-stat-icon-compact {
            font-size: 1rem;
        }
        
        .rpg-stat-value-compact {
            font-size: 0.8rem;
        }
        
        .rpg-stat-label-compact {
            font-size: 0.65rem;
        }
        
        .rpg-class-card-compact {
            padding: 0.5rem;
        }
        
        .rpg-class-icon-compact {
            font-size: 1.2rem;
        }
        
        .rpg-class-name-compact {
            font-size: 0.75rem;
        }
    }
    
    /* Player Level & Experience Compact Styles */
    .rpg-profile-picture-compact {
        position: relative;
        display: inline-block;
        margin-right: 0.75rem;
    }
    
    .rpg-avatar-compact {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffd700;
        box-shadow: 
            0 0 10px rgba(255,215,0,0.3),
            0 2px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    
    .rpg-avatar-compact:hover {
        transform: scale(1.05);
        box-shadow: 
            0 0 15px rgba(255,215,0,0.5),
            0 3px 12px rgba(0,0,0,0.3);
    }
    
    .rpg-avatar-border-compact {
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        border-radius: 50%;
        background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .rpg-profile-picture-compact:hover .rpg-avatar-border-compact {
        opacity: 1;
        animation: rotate 3s linear infinite;
    }
    
    .rpg-title-compact {
        font-size: 1rem !important;
        font-weight: 600;
        margin-bottom: 0.25rem !important;
    }
    
    .rpg-level-compact {
        font-size: 1.25rem !important;
        font-weight: 700;
        margin-bottom: 0.5rem !important;
    }
    
    .exp-section-compact {
        margin-top: 0.5rem;
    }
    
    .progress-compact {
        height: 6px !important;
        border-radius: 4px !important;
    }
    
    /* Ultra compact for very small screens */
    @media (max-width: 400px) {
        .rpg-stat-label-compact {
            font-size: 0.6rem;
        }
        
        .rpg-stat-value-compact {
            font-size: 0.75rem;
        }
        
        .rpg-stat-details-compact {
            font-size: 0.6rem;
        }
        
        .btn-xs {
            padding: 0.15rem 0.3rem;
            font-size: 0.65rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const autoClickToggle = document.getElementById('autoClickToggle');
    const earnMoneyForm = document.getElementById('earnMoneyForm');
    const earnMoneyBtn = document.getElementById('earnMoneyBtn');
    const autoClickStatus = document.getElementById('autoClickStatus');
    const autoClickCounter = document.getElementById('autoClickCounter');
    
    // Get current treasure from the page
    let currentTreasure = {{ $user->treasure }};
    let currentMoney = {{ $user->money_earned }};
    
    let autoClickInterval = null;
    let clickCount = 0;
    let isProcessing = false;
    
    // Auto click toggle event (only if element exists - Level 3+ requirement)
    if (autoClickToggle) {
        autoClickToggle.addEventListener('change', function() {
            if (this.checked) {
                startAutoClick();
            } else {
                stopAutoClick();
            }
        });
    }
    
    function startAutoClick() {
        if (!autoClickToggle || currentTreasure <= 0) {
            if (autoClickToggle) autoClickToggle.checked = false;
            return;
        }
        
        // Clear any previous messages (steal success, general success, errors)
        const stealSuccessMessage = document.getElementById('stealSuccessMessage');
        if (stealSuccessMessage) {
            stealSuccessMessage.style.display = 'none';
        }
        
        // Hide general alert messages
        const alertMessages = document.querySelectorAll('.alert-dismissible');
        alertMessages.forEach(alert => {
            alert.style.display = 'none';
        });
        
        if (autoClickStatus) autoClickStatus.style.display = 'block';
        clickCount = 0;
        updateAutoClickStatus();
        
        // Auto click every 4 seconds to avoid overwhelming the server
        autoClickInterval = setInterval(() => {
            if (!isProcessing && currentTreasure > 0) {
                performAutoClick();
            } else if (currentTreasure <= 0) {
                stopAutoClickWithMessage();
            }
        }, 4000);
    }
    
    function stopAutoClick() {
        if (autoClickInterval) {
            clearInterval(autoClickInterval);
            autoClickInterval = null;
        }
        if (autoClickStatus) autoClickStatus.style.display = 'none';
    }
    
    function stopAutoClickWithMessage() {
        stopAutoClick();
        autoClickToggle.checked = false;
        autoClickToggle.disabled = true;
        
        // Update treasure display to show 0 immediately
        const treasureDisplay = document.getElementById('playerTreasureDisplay');
        if (treasureDisplay) {
            // Get the max treasure capacity from current display or calculate it
            const currentText = treasureDisplay.textContent;
            const maxTreasure = currentText.includes('/') ? currentText.split('/')[1].trim() : '25';
            treasureDisplay.textContent = `0 / ${maxTreasure}`;
            treasureDisplay.className = 'rpg-stat-value-compact text-danger';
            treasureDisplay.classList.add('treasure-warning');
        }
        
        // Update button state
        earnMoneyBtn.innerHTML = `
            <div class="rpg-button-content">
                <i class="fas fa-times-circle me-2"></i>
                <span class="d-none d-sm-inline">OUT OF TREASURE</span>
                <span class="d-sm-none">NO TREASURE</span>
            </div>
            <div class="rpg-button-glow"></div>
        `;
        earnMoneyBtn.className = 'rpg-button rpg-button-disabled rpg-button-large';
        earnMoneyBtn.disabled = true;
        
        // Show completion message (without spinner)
        autoClickStatus.style.display = 'block';
        autoClickStatus.innerHTML = `
            <div class="rpg-alert rpg-alert-warning">
                <div class="rpg-alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="rpg-alert-content">
                    <strong>Auto Click Completed:</strong> All treasure used! Completed ${clickCount} clicks total.
                </div>
            </div>
        `;
    }
    
    function updateAutoClickStatus() {
        autoClickCounter.textContent = clickCount;
    }
    
    function updateUIDisplays(data) {
        // Update local treasure count immediately
        if (data.treasure_remaining !== undefined) {
            currentTreasure = data.treasure_remaining;
        }
        
        // Update treasure display
        const treasureDisplay = document.getElementById('playerTreasureDisplay');
        if (treasureDisplay && data.treasure_remaining !== undefined) {
            // Calculate max treasure capacity (should come from server data or use current display)
            const maxTreasure = data.max_treasure_capacity || (20 + (data.treasure_multiplier_level || 0) * 5);
            treasureDisplay.textContent = `${data.treasure_remaining} / ${maxTreasure}`;
            
            // Update treasure color based on remaining count
            if (data.treasure_remaining > 0) {
                treasureDisplay.className = 'rpg-stat-value-compact text-warning';
            } else {
                treasureDisplay.className = 'rpg-stat-value-compact text-danger';
                treasureDisplay.classList.add('treasure-warning');
            }
        }
        
        // If treasure becomes 0 and auto-click is active, stop it after UI update
        if (currentTreasure <= 0 && autoClickInterval) {
            setTimeout(() => {
                stopAutoClickWithMessage();
            }, 100); // Small delay to ensure UI updates first
        }
        
        // Update money display with animation
        const moneyDisplay = document.getElementById('playerMoneyDisplay');
        if (moneyDisplay) {
            // Add money update class for transition
            moneyDisplay.classList.add('money-update-animation');
            
            // Update text
            moneyDisplay.textContent = `IDR ${data.formatted_money}`;
            
            // Add scale and color animation
            moneyDisplay.style.transform = 'scale(1.1)';
            moneyDisplay.style.color = '#28a745';
            
            setTimeout(() => {
                moneyDisplay.style.transform = 'scale(1)';
                moneyDisplay.style.color = '#ffffff'; // White color for better visibility
            }, 600);
        }
        
        // Update level display with animation
        const levelDisplay = document.getElementById('playerLevelDisplay');
        if (levelDisplay && data.level_up) {
            levelDisplay.textContent = `Level ${data.current_level}`;
            
            // Add level up animation
            levelDisplay.style.transform = 'scale(1.2)';
            levelDisplay.style.color = '#ffc107';
            
            setTimeout(() => {
                levelDisplay.style.transform = 'scale(1)';
                levelDisplay.style.color = '#0d6efd'; // Bootstrap primary color
            }, 1000);
        } else if (levelDisplay) {
            levelDisplay.textContent = `Level ${data.current_level}`;
        }
        
        // Update experience display
        const expDisplay = document.getElementById('playerExpDisplay');
        if (expDisplay && data.total_experience !== undefined) {
            const formattedExp = new Intl.NumberFormat().format(data.total_experience);
            const formattedExpToNext = new Intl.NumberFormat().format(data.exp_to_next_level);
            
            expDisplay.innerHTML = `
                ${formattedExp} EXP<br>
                <small>${formattedExpToNext} EXP to next level</small>
                @if($user->level < 3)
                    <br><small class="text-warning">Auto-click unlocks at Level 2</small>
                @endif
            `;
            
            // Add EXP gain animation
            expDisplay.style.transform = 'scale(1.05)';
            expDisplay.style.color = '#17a2b8';
            
            setTimeout(() => {
                expDisplay.style.transform = 'scale(1)';
                expDisplay.style.color = '#6c757d'; // Bootstrap muted color
            }, 500);
        }
        
        // Update experience progress bar
        if (data.exp_progress_percentage !== undefined) {
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = `${data.exp_progress_percentage}%`;
                progressBar.setAttribute('aria-valuenow', data.exp_progress_percentage);
            }
        }
        
        // Update global prize pool display with pulse animation
        const prizePoolDisplay = document.getElementById('globalPrizePoolDisplay');
        if (prizePoolDisplay) {
            // Format the number consistently with PHP number_format
            const formattedAmount = new Intl.NumberFormat('id-ID').format(data.global_prize_pool || data.formatted_global_prize_pool?.replace(/[^\d]/g, '') || 0);
            prizePoolDisplay.textContent = `IDR ${formattedAmount}`;
            
            // Add pulse animation
            prizePoolDisplay.classList.add('prize-pool-pulse');
            
            // Remove animation class after animation completes
            setTimeout(() => {
                prizePoolDisplay.classList.remove('prize-pool-pulse');
            }, 500);
        }
        
        // Show floating money indicator
        showFloatingMoneyIndicator(data.earned_amount);
        
        // Show floating EXP indicator
        if (data.experience_gained > 0) {
            showFloatingExpIndicator(data.experience_gained);
        }
    }
    
    function showFloatingMoneyIndicator(amount) {
        // Find the money card container instead of just the display element
        const moneyCard = document.querySelector('.stat-money');
        if (!moneyCard) return;
        
        // Skip if amount is 0
        if (amount === 0) return;
        
        // Make sure the money card has relative positioning for containment
        moneyCard.style.position = 'relative';
        moneyCard.style.overflow = 'hidden';
        
        const indicator = document.createElement('div');
        indicator.className = 'floating-money-indicator';
        
        // Handle positive and negative amounts properly
        if (amount > 0) {
            indicator.textContent = `+IDR ${new Intl.NumberFormat('id-ID').format(amount)}`;
            indicator.style.color = '#28a745'; // Green for gains
        } else {
            indicator.textContent = `-IDR ${new Intl.NumberFormat('id-ID').format(Math.abs(amount))}`;
            indicator.style.color = '#dc3545'; // Red for losses
        }
        
        indicator.style.cssText += `
            position: absolute;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 10;
            pointer-events: none;
            animation: floatUpInCard 2s ease-out forwards;
            opacity: 1;
            left: 50%;
            top: 60%;
            transform: translateX(-50%);
            text-align: center;
            white-space: nowrap;
        `;
        
        // Append to the money card instead of document body
        moneyCard.appendChild(indicator);
        
        // Remove after animation
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 2000);
    }
    
    function showFloatingExpIndicator(expAmount) {
        // Create floating EXP indicator
        const levelDisplay = document.getElementById('playerLevelDisplay');
        if (!levelDisplay) return;
        
        const indicator = document.createElement('div');
        indicator.className = 'floating-exp-indicator';
        indicator.textContent = `+${expAmount} EXP`;
        indicator.style.cssText = `
            position: fixed;
            color: #ffd700;
            font-weight: bold;
            font-size: 1.1rem;
            z-index: 9999;
            pointer-events: none;
            animation: floatUp 2s ease-out forwards;
            opacity: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        `;
        
        // Position relative to Level display (above the level text)
        const rect = levelDisplay.getBoundingClientRect();
        indicator.style.left = rect.left + 'px';
        indicator.style.top = (rect.top - 30) + 'px';
        
        document.body.appendChild(indicator);
        
        // Remove after animation
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 2000);
    }
    
    function performAutoClick() {
        if (isProcessing || currentTreasure <= 0) return;
        
        // Check rate limiting for auto-click as well
        const currentTime = Date.now();
        const timeDifference = currentTime - lastTreasureOpenTime;
        
        if (timeDifference < treasureOpenDelay) {
            // Wait for the remaining time before next auto-click
            const remainingDelay = treasureOpenDelay - timeDifference;
            setTimeout(performAutoClick, remainingDelay);
            return;
        }
        
        lastTreasureOpenTime = currentTime;
        isProcessing = true;
        
        // Show processing state
        earnMoneyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        earnMoneyBtn.disabled = true;
        
        // Submit form via AJAX
        const formData = new FormData(earnMoneyForm);
        
        fetch(earnMoneyForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update local state
                clickCount++;
                currentTreasure = data.treasure_remaining;
                currentMoney = data.total_money;
                
                // Update UI displays with animation
                updateUIDisplays(data);
                updateAutoClickStatus();
                
                // Reset button for next click
                setTimeout(() => {
                    isProcessing = false;
                    
                    if (currentTreasure > 0) {
                        earnMoneyBtn.innerHTML = '<i class="fas fa-coins me-2"></i> {{ __('nav.open_treasure') }}';
                        earnMoneyBtn.className = 'btn btn-lg w-100 w-sm-auto fw-bold text-uppercase btn-primary';
                        earnMoneyBtn.disabled = false;
                    } else {
                        stopAutoClickWithMessage();
                    }
                }, 1000);
                
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        })
        .catch(error => {
            console.error('Auto click error:', error);
            isProcessing = false;
            
            // Stop auto click on error
            stopAutoClick();
            autoClickToggle.checked = false;
            
            // Reset button
            earnMoneyBtn.innerHTML = '<i class="fas fa-coins me-2"></i> {{ __('nav.earn_money_now') }}';
            earnMoneyBtn.disabled = false;
        });
    }
    
    // Add rate limiting for treasure opening
    let lastTreasureOpenTime = 0;
    const treasureOpenDelay = 2000; // 2 seconds in milliseconds
    
    // Override form submission to add rate limiting
    earnMoneyForm.addEventListener('submit', function(e) {
        const currentTime = Date.now();
        const timeDifference = currentTime - lastTreasureOpenTime;
        
        if (timeDifference < treasureOpenDelay) {
            e.preventDefault();
            const remainingSeconds = Math.ceil((treasureOpenDelay - timeDifference) / 1000);
            
            // Show rate limit message
            const errorMessage = `{{ __('nav.treasure_opening_too_fast', ['seconds' => '__SECONDS__']) }}`.replace('__SECONDS__', remainingSeconds);
            
            // Create temporary error notification
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-warning alert-dismissible fade show mt-3';
            errorDiv.innerHTML = `
                <i class="fas fa-clock me-2"></i>
                <strong>${errorMessage}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insert error message before the form
            earnMoneyForm.parentNode.insertBefore(errorDiv, earnMoneyForm);
            
            // Auto-dismiss after the remaining time
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, remainingSeconds * 1000);
            
            return false;
        }
        
        lastTreasureOpenTime = currentTime;
    });
    
    // Add event listener to earn money button to hide steal success message
    earnMoneyBtn.addEventListener('click', function() {
        const stealSuccessMessage = document.getElementById('stealSuccessMessage');
        if (stealSuccessMessage) {
            stealSuccessMessage.style.display = 'none';
        }
    });
    
    // Check initial state
    if (currentTreasure <= 0 && autoClickToggle) {
        autoClickToggle.disabled = true;
    }
});
</script>

<style>
/* Night/Day Mode Indicators */
.night-risk-alert {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    border-radius: 15px;
}

.night-mode-badge, .day-mode-badge {
    padding: 10px;
    border-radius: 10px;
}

.night-mode-badge {
    background: rgba(255, 255, 255, 0.1);
}

.day-mode-badge {
    background: rgba(255, 193, 7, 0.1);
}

/* Night time styling */
@if($isNightTime)
body {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    background-attachment: fixed;
}

.card {
    box-shadow: 0 8px 32px rgba(0,0,0,0.3) !important;
}
@endif

/* Animated icons */
.fa-moon {
    animation: moonGlow 2s ease-in-out infinite alternate;
}

.fa-sun {
    animation: sunShine 1.5s ease-in-out infinite alternate;
}

@keyframes moonGlow {
    from { text-shadow: 0 0 5px rgba(255, 255, 255, 0.5); }
    to { text-shadow: 0 0 20px rgba(255, 255, 255, 0.8); }
}

@keyframes sunShine {
    from { text-shadow: 0 0 10px rgba(255, 193, 7, 0.5); }
    to { text-shadow: 0 0 25px rgba(255, 193, 7, 0.8); }
}

/* Floating indicators animation */
@keyframes floatUp {
    0% {
        opacity: 1;
        transform: translateY(0px);
    }
    100% {
        opacity: 0;
        transform: translateY(-50px);
    }
}

/* Floating money and EXP indicators */
.floating-money-indicator,
.floating-exp-indicator {
    position: fixed;
    font-weight: bold;
    z-index: 1000;
    pointer-events: none;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
</style>

@endsection
