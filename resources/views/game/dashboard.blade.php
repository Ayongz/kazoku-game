@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-3">
                {{ __('nav.the_game_dashboard') }}
            </h1>

            <!-- Night-time Risk Indicator -->
            @if($isNightTime)
                <div class="alert alert-info border-0 shadow-sm mb-4 night-risk-alert">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-1">{{ __('nav.night_time_risk_active') }}</h6>
                            <p class="mb-0 small">
                                {{ __('nav.opening_treasures_risk') }}
                                <span class="fw-bold text-danger">{{ __('nav.chance_to_lose_money') }}</span> |
                                <span class="fw-bold text-success">{{ __('nav.chance_for_bonus') }}</span> |
                                <span class="fw-bold text-primary">{{ __('nav.chance_normal') }}</span>
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="night-mode-badge">
                                <i class="fas fa-moon fa-2x text-warning"></i>
                                <div class="small fw-bold text-muted mt-1">{{ __('nav.night_mode') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-light border-0 shadow-sm mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-1">{{ __('nav.day_time_safe_mode') }}</h6>
                            <p class="mb-0 small text-muted">
                                {{ __('nav.treasure_opening_safe') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="day-mode-badge">
                                <i class="fas fa-sun fa-2x text-warning"></i>
                                <div class="small fw-bold text-muted mt-1">{{ __('nav.day_mode') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Messages -->
            @if (session('success') && !str_contains(session('success'), 'Heist successful!') && !str_contains(session('success'), 'BONUS: Stole'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">{{ __('nav.success') }}!</p>
                    <p class="mb-0">{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">{{ __('nav.error') }}!</p>
                    <p class="mb-0">{{ session('error') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Player & Global Stats - Responsive Grid -->
            <div class="row g-4 mb-5">
                <!-- Player Money Card -->
                <div class="col-12 col-md-6 col-lg-2-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-primary">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">{{ __('nav.money_earned') }}</p>
                            <h2 class="card-title h3 fw-bolder text-dark" id="playerMoneyDisplay">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Treasure Card -->
                <div class="col-12 col-md-6 col-lg-2-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-warning">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">{{ __('nav.current_treasure') }}</p>
                            <h2 class="card-title h3 fw-bolder @if($user->treasure > 0) text-warning @else text-danger @endif" id="playerTreasureDisplay">
                                {{ $user->treasure }} / {{ 20 + ($user->treasure_multiplier_level * 5) }}
                            </h2>
                            <p class="text-muted small mb-0">
                                @php
                                    $fastRecoveryIntervals = [60, 55, 50, 45, 40, 30];
                                    $currentInterval = $fastRecoveryIntervals[$user->fast_recovery_level ?? 0];
                                @endphp
                                {{ __('nav.treasure_every_minutes', ['minutes' => $currentInterval]) }}
                                @if($user->fast_recovery_level > 0)
                                    {{ __('nav.fast_recovery_level', ['level' => $user->fast_recovery_level]) }}
                                @endif
                                <br>
                                @if($user->treasure_multiplier_level > 0)
                                    {{ __('nav.max_treasure_multiplier', ['max' => 20 + ($user->treasure_multiplier_level * 5), 'level' => $user->treasure_multiplier_level]) }}
                                @else
                                    {{ __('nav.max_treasure_default') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Random Box Card -->
                <div class="col-12 col-md-6 col-lg-2-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-info">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">{{ __('nav.random_boxes') }}</p>
                            <h2 class="card-title h3 fw-bolder text-info" id="playerRandomBoxDisplay">
                                {{ $user->randombox ?? 0 }}
                            </h2>
                            <p class="text-muted small mb-3">
                                @if($user->treasure_rarity_level > 0)
                                    {{ __('nav.chance_per_treasure', ['percent' => $user->getRandomBoxChance()]) }}
                                    <br><small class="text-info">{{ __('nav.from_treasure_type', ['type' => $rarityConfig[$user->treasure_rarity_level]['name'] ?? 'Common']) }}</small>
                                @else
                                    {{ __('nav.upgrade_treasure_rarity') }}
                                    <br><small class="text-muted">{{ __('nav.to_get_random_boxes') }}</small>
                                @endif
                            </p>
                            @if(($user->randombox ?? 0) > 0)
                                <a href="{{ route('game.inventory') }}" class="btn btn-info btn-sm w-100">
                                    <i class="fas fa-gift me-1"></i>{{ __('nav.open_boxes') }}
                                </a>
                            @else
                                <a href="{{ route('game.inventory') }}" class="btn btn-outline-info btn-sm w-100">
                                    <i class="fas fa-box me-1"></i>{{ __('nav.view_inventory') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Shield Protection Card -->
                <div class="col-12 col-md-6 col-lg-2-4">
                    <div class="card h-100 shadow-lg border-start border-5 @if($user->shield_expires_at && $user->shield_expires_at > now()) border-success @else border-secondary @endif">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">{{ __('nav.shield_status') }}</p>
                            @if($user->shield_expires_at && $user->shield_expires_at > now())
                                <h2 class="card-title h4 fw-bolder text-success mb-2">
                                    <i class="fas fa-shield-alt me-1"></i>{{ __('nav.active') }}
                                </h2>
                                <p class="text-muted small mb-0">
                                    {{ __('nav.protected_until') }}<br>
                                    <strong>{{ $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('M d, H:i:s') }}</strong>
                                </p>
                            @else
                                <h2 class="card-title h4 fw-bolder text-secondary mb-2">
                                    <i class="fas fa-shield-alt me-1"></i>{{ __('nav.inactive') }}
                                </h2>
                                <p class="text-muted small mb-0">
                                    <a href="{{ route('store.index') }}" class="text-decoration-none">{{ __('nav.visit_store') }}</a> {{ __('nav.to_activate') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Player Level & Experience Card -->
                <div class="col-12 col-md-6 col-lg-2-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-primary">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">{{ __('nav.player_level') }}</p>
                            <h2 class="card-title h3 fw-bolder text-primary" id="playerLevelDisplay">
                                {{ __('nav.level') }} {{ $user->level }}
                            </h2>
                            <div class="mb-2">
                                @php
                                    use App\Services\ExperienceService;
                                    $expToNext = ExperienceService::getExpToNextLevel($user->experience, $user->level);
                                    $expProgress = ExperienceService::getExpProgressPercentage($user->experience, $user->level);
                                @endphp
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ $expProgress }}%" 
                                         aria-valuenow="{{ $expProgress }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mb-0" id="playerExpDisplay">
                                {{ number_format($user->experience) }} EXP<br>
                                <small>{{ number_format($expToNext) }} EXP to next level</small>
                                @if($user->level < 3)
                                    <br><small class="text-warning">Auto-click unlocks at Level 3</small>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game Actions Section -->
            <div class="row justify-content-center">
                <!-- EARN MONEY ACTION -->
                <div class="col-12 col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-3 p-md-4">
                            <!-- Header Section -->
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                                <h2 class="h3 fw-bold text-primary mb-2 mb-md-0">Daily Grind</h2>
                                
                                <!-- Auto Click Toggle (Level 3+ Required) -->
                                @if($user->level >= 3)
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="autoClickToggle" 
                                               @if($user->treasure <= 0) disabled @endif>
                                        <label class="form-check-label fw-bold text-primary" for="autoClickToggle">
                                            <i class="fas fa-robot me-1"></i><span class="d-none d-sm-inline">Auto Click</span>
                                        </label>
                                    </div>
                                @else
                                    <div class="text-muted">
                                        <small><i class="fas fa-lock me-1"></i>Auto Click unlocks at Level 3</small>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Description -->
                            <div class="row justify-content-center mb-4">
                                <div class="col-12 col-md-10">
                                    <p class="text-muted text-center mb-0">
                                        {{ __('nav.click_to_earn_money') }}
                                        @if($user->steal_level > 0)
                                            <br><small class="text-info"><i class="fas fa-mask me-1"></i><strong>{{ __('nav.bonus') }}:</strong> {{ __('nav.steal_bonus', ['percent' => $user->steal_level * 5]) }}</small>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Treasure Section -->
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-8 col-md-6">
                                    <div class="text-center">
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
                                        <div class="mb-3">
                                            <span class="badge fs-6 px-3 py-2" style="background-color: {{ $currentRarity['color'] }}; box-shadow: {{ $currentRarity['glow'] }}; color: white; max-width: 100%; word-wrap: break-word;">
                                                <i class="{{ $currentRarity['icon'] }} me-1"></i>{{ $currentRarity['name'] }} Treasure
                                            </span>
                                            @if($currentRarity['chance'] > 0)
                                                <br>
                                                <small class="text-muted mt-1 d-block">
                                                    <i class="fas fa-gift me-1"></i>{{ $currentRarity['chance'] }}% chance for Random Box
                                                </small>
                                            @endif
                                        </div>
                                        
                                        <!-- Open Treasure Button -->
                                        <form method="POST" action="{{ route('game.earn') }}" id="earnMoneyForm" class="d-inline-block">
                                            @csrf
                                            <button type="submit" id="earnMoneyBtn"
                                                    class="btn btn-md fw-bold text-uppercase @if($user->treasure > 0) btn-primary @else btn-secondary disabled @endif"
                                                    style="border-radius: 12px; padding: 10px 20px; min-width: 160px;"
                                                    @if($user->treasure <= 0) disabled @endif>
                                                @if($user->treasure > 0)
                                                    <i class="fas fa-coins me-2"></i><span class="d-none d-sm-inline">OPEN </span>TREASURE
                                                @else
                                                    <span class="d-none d-sm-inline">OUT OF </span>TREASURE
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Steal Success Message (shows below earn money button) -->
                            @if (session('success') && (str_contains(session('success'), 'Heist successful!') || str_contains(session('success'), 'BONUS: Stole')))
                                <div id="stealSuccessMessage" class="mt-3">
                                    <div class="alert alert-success d-flex align-items-center">
                                        <i class="fas fa-mask me-2"></i>
                                        <div>
                                            <strong>{{ session('success') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Auto Click Status -->
                            <div id="autoClickStatus" class="mt-3" style="display: none;">
                                <div class="alert alert-info d-flex align-items-center">
                                    <div class="spinner-border spinner-border-sm me-2" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <small class="mb-0">
                                        <strong>Auto Click Active:</strong> <span id="autoClickCounter">0</span> clicks completed
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class System Section -->
            @if($user->canSelectClass() || $user->canAdvanceClass() || $user->selected_class)
            <div class="row justify-content-center mt-4" >
                <div class="col-12 col-lg-8">
                    <div class="card shadow-lg border-0 bg-gradient-primary text-white">
                        <div class="card-body p-4">
                            @if($user->selected_class)
                                <!-- Current Class Display -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center" style="color: black;">
                                    <div>
                                        <h4 class="mb-2">
                                            <i class="fas fa-shield-alt me-2"></i>{{ $user->getClassDisplayName() }}
                                        </h4>
                                        <p class="mb-0 opacity-75">{{ $user->getClassDescription() }}</p>
                                        @if($user->class_selected_at)
                                            <small class="opacity-50">Class selected on {{ $user->class_selected_at->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                    
                                    @if($user->canAdvanceClass())
                                        <div class="text-center mt-3 mt-md-0">
                                            <form action="{{ route('game.advance-class') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-lg px-4">
                                                    ⭐ Advance Class
                                                </button>
                                            </form>
                                            <div class="small mt-2 opacity-75">
                                                Unlock enhanced abilities!
                                            </div>
                                        </div>
                                    @elseif($user->has_advanced_class)
                                        <div class="text-center mt-3 mt-md-0">
                                            <div class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                ⭐ ADVANCED CLASS ⭐
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @elseif($user->canSelectClass())
                                <!-- Class Selection Available -->
                                <div class="text-center" style="color:black;">
                                    <h4 class="mb-3">
                                        <i class="fas fa-star me-2"></i>Class Selection Available!
                                    </h4>
                                    <p class="mb-4 opacity-75">
                                        You've reached level {{ $user->level }}! Choose a class to unlock special abilities and enhance your treasure hunting experience.
                                    </p>
                                    <a href="{{ route('game.class-selection') }}" class="btn btn-light btn-lg px-5">
                                        🎯 Choose Your Class
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Auto Click JavaScript -->
<style>
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
    
    .floating-money-indicator {
        position: fixed !important;
        z-index: 9999 !important;
        font-weight: bold !important;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3) !important;
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
        
        // Update button state
        earnMoneyBtn.innerHTML = 'OUT OF TREASURE';
        earnMoneyBtn.className = 'btn btn-lg w-100 w-sm-auto fw-bold text-uppercase btn-secondary disabled';
        earnMoneyBtn.disabled = true;
        
        // Show completion message
        autoClickStatus.style.display = 'block';
        const alertDiv = autoClickStatus.querySelector('.alert');
        alertDiv.className = 'alert alert-warning d-flex align-items-center';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-triangle me-2"></i>
            <small class="mb-0">
                <strong>Auto Click Completed:</strong> All treasure used! Completed ${clickCount} clicks total.
            </small>
        `;
    }
    
    function updateAutoClickStatus() {
        autoClickCounter.textContent = clickCount;
    }
    
    function updateUIDisplays(data) {
        // Update treasure display
        const treasureDisplay = document.getElementById('playerTreasureDisplay');
        if (treasureDisplay) {
            // Calculate max treasure capacity (should come from server data or use current display)
            const maxTreasure = data.max_treasure_capacity || (20 + (data.treasure_multiplier_level || 0) * 5);
            treasureDisplay.textContent = `${data.treasure_remaining} / ${maxTreasure}`;
            
            // Update treasure color based on remaining count
            if (data.treasure_remaining > 0) {
                treasureDisplay.className = 'card-title h3 fw-bolder text-warning';
            } else {
                treasureDisplay.className = 'card-title h3 fw-bolder text-danger';
                treasureDisplay.classList.add('treasure-warning');
            }
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
                moneyDisplay.style.color = '#212529'; // Bootstrap dark color
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
                    <br><small class="text-warning">Auto-click unlocks at Level 3</small>
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
            prizePoolDisplay.textContent = `IDR ${data.formatted_global_prize_pool}`;
            
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
        // Create floating money indicator
        const moneyDisplay = document.getElementById('playerMoneyDisplay');
        if (!moneyDisplay) return;
        
        const indicator = document.createElement('div');
        indicator.className = 'floating-money-indicator';
        indicator.textContent = `+IDR ${new Intl.NumberFormat('id-ID').format(amount)}`;
        indicator.style.cssText = `
            position: absolute;
            color: #28a745;
            font-weight: bold;
            font-size: 1.2rem;
            z-index: 1000;
            pointer-events: none;
            animation: floatUp 2s ease-out forwards;
            opacity: 1;
        `;
        
        // Position relative to money display
        const rect = moneyDisplay.getBoundingClientRect();
        indicator.style.left = rect.left + 'px';
        indicator.style.top = rect.top + 'px';
        
        document.body.appendChild(indicator);
        
        // Remove after animation
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 2000);
    }
    
    function showFloatingExpIndicator(expAmount) {
        // Create floating EXP indicator
        const expDisplay = document.getElementById('playerExpDisplay');
        if (!expDisplay) return;
        
        const indicator = document.createElement('div');
        indicator.className = 'floating-exp-indicator';
        indicator.textContent = `+${expAmount} EXP`;
        indicator.style.cssText = `
            position: absolute;
            color: #17a2b8;
            font-weight: bold;
            font-size: 1rem;
            z-index: 1000;
            pointer-events: none;
            animation: floatUp 2s ease-out forwards;
            opacity: 1;
        `;
        
        // Position relative to EXP display
        const rect = expDisplay.getBoundingClientRect();
        indicator.style.left = (rect.left + 20) + 'px';
        indicator.style.top = rect.top + 'px';
        
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
