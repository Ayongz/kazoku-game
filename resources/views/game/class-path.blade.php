@extends('layouts.app')

@section('content')
<div class="rpg-class-path-container">
    <!-- RPG Background Elements -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container pt-1">
        <div class="row justify-content-center">
            <div class="col-12">
                
                <!-- RPG Header -->
                <div class="rpg-header text-center mb-4">
                    <div class="store-title-container">
                        <h1 class="rpg-title-enhanced">
                            <i class="fas fa-scroll me-2"></i>{{ __('nav.class_path_tree') }}
                        </h1>
                        <div class="title-decoration-enhanced"></div>
                        <p class="rpg-subtitle mt-2 mb-0">{{ __('nav.class_path_overview') }}</p>
                    </div>
                </div>

                <!-- RPG Status Overview - Compact -->
                <div class="row mb-4">
                    <!-- Class System Overview -->
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                        <div class="rpg-panel panel-info h-100">
                            <div class="panel-content p-3">
                                <h5 class="rpg-section-title text-white mb-3">
                                    <i class="fas fa-info-circle me-2 text-info"></i>{{ __('nav.class_system_overview') }}
                                </h5>
                                <div class="rpg-info-list">
                                    <div class="rpg-info-item">
                                        <i class="fas fa-star text-warning me-2"></i>
                                        <strong>{{ __('nav.level') }} 4: &nbsp; </strong> {{ __('nav.level_4_choose') }}
                                    </div>
                                    <div class="rpg-info-item">
                                        <i class="fas fa-crown text-warning me-2"></i>
                                        <strong>{{ __('nav.level') }} 8: &nbsp; </strong> {{ __('nav.level_8_advance') }}
                                    </div>
                                    <div class="rpg-info-item">
                                        <i class="fas fa-lock text-danger me-2"></i>
                                        <strong>{{ __('nav.selection_permanent') }}: &nbsp; </strong> {{ __('nav.selection_permanent') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Player Status -->
                    <div class="col-12 col-lg-6">
                        <div class="rpg-panel panel-status h-100">
                            <div class="panel-content p-3">
                                <h5 class="rpg-section-title text-white mb-3">
                                    <i class="fas fa-user me-2 text-success"></i>{{ __('nav.your_status') }}
                                </h5>
                                <div class="rpg-status-grid">
                                    <div class="rpg-status-item">
                                        <span class="status-label">{{ __('nav.current_level') }}:</span>
                                        <span class="status-value text-warning">{{ $user->level }}</span>
                                    </div>
                                    <div class="rpg-status-item">
                                        <span class="status-label">{{ __('nav.current_class') }}:</span>
                                        <span class="status-value text-info">{{ $user->selected_class ? $user->getClassDisplayName() : __('nav.none') }}</span>
                                    </div>
                                    <div class="rpg-status-item">
                                        <span class="status-label">{{ __('nav.can_select') }}:</span>
                                        <span class="status-value {{ $user->canSelectClass() ? 'text-success' : 'text-danger' }}">
                                            {{ $user->canSelectClass() ? __('nav.yes') : __('nav.no') }}
                                        </span>
                                    </div>
                                    @if($user->canAdvanceClass())
                                        <div class="rpg-status-item special">
                                            <span class="status-special">
                                                <i class="fas fa-star text-warning me-1"></i>{{ __('nav.ready_to_advance') }}<i class="fas fa-star text-warning ms-1"></i>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RPG Class Tree Grid -->
                <div class="rpg-class-grid">
                    @foreach($classData as $classKey => $classInfo)
                    <div class="rpg-class-card-wrapper">
                        <div class="rpg-class-card 
                            @if($user->selected_class === $classKey) 
                                selected-class
                            @else 
                                available-class
                            @endif
                        ">
                            <!-- Class Header -->
                            <div class="rpg-class-header">
                                <div class="class-icon-large">{{ $classInfo['icon'] }}</div>
                                <h4 class="class-name">
                                    @if($classKey === 'treasure_hunter')
                                        {{ __('nav.treasure_hunter') }}
                                    @elseif($classKey === 'proud_merchant')
                                        {{ __('nav.proud_merchant') }}
                                    @elseif($classKey === 'fortune_gambler')
                                        {{ __('nav.fortune_gambler') }}
                                    @elseif($classKey === 'moon_guardian')
                                        {{ __('nav.moon_guardian') }}
                                    @elseif($classKey === 'day_breaker')
                                        {{ __('nav.day_breaker') }}
                                    @elseif($classKey === 'box_collector')
                                        {{ __('nav.box_collector') }}
                                    @elseif($classKey === 'divine_scholar')
                                        {{ __('nav.divine_scholar') }}
                                    @else
                                        {{ $classInfo['name'] }}
                                    @endif
                                </h4>
                                @if($user->selected_class === $classKey)
                                    <div class="selected-badge">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('nav.your_class') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Class Description -->
                            <div class="rpg-class-description">
                                <p class="class-desc-text">
                                    @if($classKey === 'treasure_hunter')
                                        {{ __('nav.treasure_hunter_desc') }}
                                    @elseif($classKey === 'proud_merchant')
                                        {{ __('nav.proud_merchant_desc') }}
                                    @elseif($classKey === 'fortune_gambler')
                                        {{ __('nav.fortune_gambler_desc') }}
                                    @elseif($classKey === 'moon_guardian')
                                        {{ __('nav.moon_guardian_desc') }}
                                    @elseif($classKey === 'day_breaker')
                                        {{ __('nav.day_breaker_desc') }}
                                    @elseif($classKey === 'box_collector')
                                        {{ __('nav.box_collector_desc') }}
                                    @elseif($classKey === 'divine_scholar')
                                        {{ __('nav.divine_scholar_desc') }}
                                    @else
                                        {{ $classInfo['description'] }}
                                    @endif
                                </p>
                            </div>

                            <!-- Basic Class Abilities -->
                            <div class="rpg-abilities-section">
                                <h6 class="ability-title basic">
                                    <i class="fas fa-star me-2"></i>{{ __('nav.basic_class_level_4') }}
                                </h6>
                                <div class="abilities-container basic">
                                    @if($classKey === 'treasure_hunter')
                                        <div class="ability-item">
                                            <i class="fas fa-key ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_free_attempts', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'proud_merchant')
                                        <div class="ability-item">
                                            <i class="fas fa-coins ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.bonus_earnings', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'fortune_gambler')
                                        <div class="ability-item">
                                            <i class="fas fa-dice ability-icon text-success"></i>
                                            <span class="ability-text">{{ __('nav.chance_double_earnings', ['percent' => $classInfo['basic_double_chance']]) }}</span>
                                        </div>
                                        <div class="ability-item">
                                            <i class="fas fa-skull ability-icon text-danger"></i>
                                            <span class="ability-text">{{ __('nav.chance_lose_everything', ['percent' => $classInfo['basic_lose_chance']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'moon_guardian')
                                        <div class="ability-item">
                                            <i class="fas fa-moon ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_random_box_night', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'day_breaker')
                                        <div class="ability-item">
                                            <i class="fas fa-sun ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_random_box_day', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'box_collector')
                                        <div class="ability-item">
                                            <i class="fas fa-boxes ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_2_random_boxes', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'divine_scholar')
                                        <div class="ability-item">
                                            <i class="fas fa-graduation-cap ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.bonus_experience', ['percent' => $classInfo['basic_percentage']]) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Advancement Arrow -->
                            <div class="advancement-divider">
                                <div class="advancement-line"></div>
                                <div class="advancement-badge">
                                    <i class="fas fa-arrow-down"></i>
                                    <span>{{ __('nav.advance_at_level_8') }}</span>
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="advancement-line"></div>
                            </div>

                            <!-- Advanced Class Abilities -->
                            <div class="rpg-abilities-section">
                                <h6 class="ability-title advanced">
                                    <i class="fas fa-crown me-2"></i>{{ __('nav.advanced_class_level_8') }}
                                </h6>
                                <div class="advanced-class-name">
                                    @if($classKey === 'treasure_hunter')
                                        {{ __('nav.master_treasure_hunter') }}
                                    @elseif($classKey === 'proud_merchant')
                                        {{ __('nav.elite_merchant') }}
                                    @elseif($classKey === 'fortune_gambler')
                                        {{ __('nav.grand_gambler') }}
                                    @elseif($classKey === 'moon_guardian')
                                        {{ __('nav.lunar_guardian') }}
                                    @elseif($classKey === 'day_breaker')
                                        {{ __('nav.solar_champion') }}
                                    @elseif($classKey === 'box_collector')
                                        {{ __('nav.grand_collector') }}
                                    @elseif($classKey === 'divine_scholar')
                                        {{ __('nav.sage_scholar') }}
                                    @else
                                        {{ $classInfo['advanced_name'] }}
                                    @endif
                                </div>
                                <div class="abilities-container advanced">
                                    @if($classKey === 'treasure_hunter')
                                        <div class="ability-item">
                                            <i class="fas fa-key ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_free_attempts', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'proud_merchant')
                                        <div class="ability-item">
                                            <i class="fas fa-coins ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.bonus_earnings', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'fortune_gambler')
                                        <div class="ability-item">
                                            <i class="fas fa-dice ability-icon text-success"></i>
                                            <span class="ability-text">{{ __('nav.chance_double_earnings', ['percent' => $classInfo['advanced_double_chance']]) }}</span>
                                        </div>
                                        <div class="ability-item">
                                            <i class="fas fa-skull ability-icon text-danger"></i>
                                            <span class="ability-text">{{ __('nav.chance_lose_everything', ['percent' => $classInfo['advanced_lose_chance']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'moon_guardian')
                                        <div class="ability-item">
                                            <i class="fas fa-moon ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_random_box_night', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'day_breaker')
                                        <div class="ability-item">
                                            <i class="fas fa-sun ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_random_box_day', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'box_collector')
                                        <div class="ability-item">
                                            <i class="fas fa-boxes ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.chance_2_random_boxes', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @elseif($classKey === 'divine_scholar')
                                        <div class="ability-item">
                                            <i class="fas fa-graduation-cap ability-icon"></i>
                                            <span class="ability-text">{{ __('nav.bonus_experience', ['percent' => $classInfo['advanced_percentage']]) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Improvement Summary -->
                            <div class="rpg-improvement-summary">
                                <div class="improvement-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="improvement-text">
                                    <strong>{{ __('nav.improvement') }}:</strong>
                                    @if($classKey === 'fortune_gambler')
                                        +{{ $classInfo['advanced_double_chance'] - $classInfo['basic_double_chance'] }}% {{ __('nav.double_chance') }}, 
                                        +{{ $classInfo['advanced_lose_chance'] - $classInfo['basic_lose_chance'] }}% {{ __('nav.risk') }}
                                    @else
                                        +{{ $classInfo['advanced_percentage'] - $classInfo['basic_percentage'] }}{{ $classKey === 'proud_merchant' || $classKey === 'divine_scholar' ? '% ' . __('nav.more') : '% ' . __('nav.higher_chance') }}
                                    @endif
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div class="rpg-class-footer">
                                @if(!$user->selected_class && $user->canSelectClass())
                                    <a href="{{ route('game.class-selection') }}" class="rpg-button rpg-button-primary rpg-button-compact">
                                        <div class="rpg-button-content">
                                            <i class="fas fa-hand-pointer me-2"></i>{{ __('nav.select_class') }}
                                        </div>
                                        <div class="rpg-button-glow"></div>
                                    </a>
                                @elseif($user->selected_class === $classKey && $user->canAdvanceClass())
                                    <form action="{{ route('game.advance-class') }}" method="POST" class="d-inline w-100">
                                        @csrf
                                        <button type="submit" class="rpg-button rpg-button-legendary rpg-button-compact w-100">
                                            <div class="rpg-button-content">
                                                <i class="fas fa-star me-2"></i>{{ __('nav.advance_class') }}
                                            </div>
                                            <div class="rpg-button-glow"></div>
                                        </button>
                                    </form>
                                @elseif($user->selected_class === $classKey && $user->has_advanced_class)
                                    <div class="status-badge fully-advanced">
                                        <i class="fas fa-crown me-2"></i>{{ __('nav.fully_advanced') }}
                                    </div>
                                @elseif($user->selected_class === $classKey)
                                    <div class="status-badge awaiting-advancement">
                                        <i class="fas fa-clock me-2"></i>{{ __('nav.advance_at_level_8') }}
                                    </div>
                                @elseif($user->selected_class)
                                    <div class="status-badge class-locked">
                                        <i class="fas fa-lock me-2"></i>{{ __('nav.class_already_selected') }}
                                    </div>
                                @else
                                    <div class="status-badge level-requirement">
                                        <i class="fas fa-level-up-alt me-2"></i>{{ __('nav.reach_level_requirement', ['level' => 4]) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- RPG Navigation Actions -->
                <!-- <div class="rpg-navigation-section">
                    <div class="rpg-panel panel-navigation">
                        <div class="panel-content p-3">
                            <div class="navigation-buttons">
                                <a href="{{ route('game.dashboard') }}" class="rpg-button rpg-button-secondary rpg-button-large">
                                    <div class="rpg-button-content">
                                        <i class="fas fa-arrow-left me-2"></i>{{ __('nav.back_to_dashboard') }}
                                    </div>
                                    <div class="rpg-button-glow"></div>
                                </a>
                                
                                @if($user->canSelectClass())
                                    <a href="{{ route('game.class-selection') }}" class="rpg-button rpg-button-epic rpg-button-large">
                                        <div class="rpg-button-content">
                                            <i class="fas fa-hand-pointer me-2"></i>{{ __('nav.select_class') }} Now
                                        </div>
                                        <div class="rpg-button-glow"></div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> 
                <br> -->
            </div>
        </div>
    </div>
</div>

<style>
/* === RPG CLASS PATH STYLING === */

/* Remove all shadow effects globally */
* {
    text-shadow: none !important;
    box-shadow: none !important;
    filter: none !important;
}

/* Main Container Background */
.rpg-class-path-container {
    min-height: 100vh;
    position: relative;
    color: #1a202c;
    background: linear-gradient(135deg, 
        #1a1f2e 0%, 
        #2d3748 25%, 
        #1a202c 50%, 
        #2a4365 75%, 
        #1a1f2e 100%
    );
    background-attachment: fixed;
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
    z-index: -1; /* Ensure it stays behind all content */
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

@keyframes mysticFloat {
    0% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-10px) translateX(5px); }
    50% { transform: translateY(-20px) translateX(0px); }
    75% { transform: translateY(-10px) translateX(-5px); }
    100% { transform: translateY(0px) translateX(0px); }
}

.container {
    position: relative;
    z-index: 10; /* Ensure content stays above background */
}

/* Ensure navigation doesn't get affected */
.navbar {
    position: relative;
    z-index: 1000 !important;
}

/* RPG Header */
.rpg-header {
    color: #1a202c !important;
}

.rpg-title-enhanced {
    color: #ffffff !important;
    font-weight: 900;
    letter-spacing: 2px;
    font-size: 2.5rem;
    margin-bottom: 0;
}

.rpg-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
    font-style: italic;
}

/* RPG Panels */
.rpg-panel {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    border: 2px solid #4a5568;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
}

.panel-info {
    background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
    border-color: #3b82f6;
}

.panel-status {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    border-color: #10b981;
}

.panel-navigation {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    border-color: #9ca3af;
}

.panel-content {
    position: relative;
    z-index: 1;
}

.rpg-section-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

/* Info and Status Lists */
.rpg-info-list,
.rpg-status-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.rpg-info-item,
.rpg-status-item {
    display: flex;
    align-items: center;
    color: #e2e8f0;
    font-size: 0.9rem;
}

.rpg-status-item {
    justify-content: space-between;
}

.status-label {
    color: #cbd5e0;
}

.status-value {
    font-weight: 600;
}

.rpg-status-item.special {
    background: linear-gradient(135deg, rgba(245,158,11,0.2) 0%, rgba(217,119,6,0.2) 100%);
    border-radius: 8px;
    padding: 0.5rem;
    border: 1px solid rgba(245,158,11,0.3);
}

.status-special {
    color: #fbbf24 !important;
    font-weight: 700;
    text-align: center;
    width: 100%;
}

/* Class Grid */
.rpg-class-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.rpg-class-card-wrapper {
    display: flex;
}

.rpg-class-card {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: 2px solid #cbd5e0;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
    color: #1a202c;
}

.rpg-class-card:hover {
    transform: translateY(-5px);
    border-color: #94a3b8;
}

.rpg-class-card.selected-class {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border-color: #22c55e;
}

.rpg-class-card.selected-class:hover {
    border-color: #16a34a;
}

/* Class Header */
.rpg-class-header {
    text-align: center;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid rgba(0,0,0,0.1);
    padding-bottom: 1rem;
}

.class-icon-large {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    display: block;
}

.class-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #1f2937;
}

.selected-badge {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

/* Class Description */
.rpg-class-description {
    margin-bottom: 1.5rem;
}

.class-desc-text {
    color: #4b5563;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

/* Abilities Section */
.rpg-abilities-section {
    margin-bottom: 1.5rem;
}

.ability-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
}

.ability-title.basic {
    color: #3b82f6;
}

.ability-title.advanced {
    color: #f59e0b;
}

.abilities-container {
    border-radius: 8px;
    padding: 1rem;
}

.abilities-container.basic {
    background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(29,78,216,0.1) 100%);
    border: 1px solid rgba(59,130,246,0.2);
}

.abilities-container.advanced {
    background: linear-gradient(135deg, rgba(245,158,11,0.1) 0%, rgba(217,119,6,0.1) 100%);
    border: 1px solid rgba(245,158,11,0.2);
}

.ability-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    padding: 0.25rem 0;
}

.ability-item:last-child {
    margin-bottom: 0;
}

.ability-icon {
    width: 1.2rem;
    margin-right: 0.5rem;
    color: #6b7280;
    flex-shrink: 0;
}

.ability-text {
    font-size: 0.85rem;
    color: #374151;
    line-height: 1.4;
}

/* Advanced Class Name */
.advanced-class-name {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1rem;
    display: inline-block;
    width: 100%;
}

/* Advancement Divider */
.advancement-divider {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
    position: relative;
}

.advancement-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, transparent, #94a3b8, transparent);
}

.advancement-badge {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
    margin: 0 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Improvement Summary */
.rpg-improvement-summary {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(107,114,128,0.1) 0%, rgba(75,85,99,0.1) 100%);
    border: 1px solid rgba(107,114,128,0.2);
    border-radius: 8px;
    padding: 0.75rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #6b7280;
}

.improvement-icon {
    margin-right: 0.75rem;
    color: #6b7280;
    font-size: 1.1rem;
}

.improvement-text {
    font-size: 0.85rem;
    color: #374151;
    line-height: 1.4;
}

/* Class Footer */
.rpg-class-footer {
    text-align: center;
}

.status-badge {
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-block;
    width: 100%;
    text-align: center;
}

.status-badge.fully-advanced {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.status-badge.awaiting-advancement {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.status-badge.class-locked {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}

.status-badge.level-requirement {
    background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
    color: white;
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
    padding: 12px 24px;
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

.rpg-button-compact {
    padding: 8px 16px;
    font-size: 0.9rem;
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

.rpg-button-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}

.rpg-button-secondary:hover {
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

/* Navigation Section */
.rpg-navigation-section {
    margin-top: 2rem;
}

.navigation-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* Responsive Design */
@media (max-width: 768px) {
    .rpg-title-enhanced {
        font-size: 2rem;
        letter-spacing: 1px;
    }
    
    .rpg-class-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .rpg-class-card {
        padding: 1rem;
    }
    
    .class-icon-large {
        font-size: 2.5rem;
    }
    
    .class-name {
        font-size: 1.1rem;
    }
    
    .navigation-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .rpg-button {
        width: 100%;
        max-width: 300px;
    }
    
    .rpg-info-list,
    .rpg-status-grid {
        gap: 0.5rem;
    }
    
    .advancement-badge {
        flex-direction: column;
        gap: 0.25rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .rpg-class-card {
        padding: 0.75rem;
    }
    
    .ability-text {
        font-size: 0.8rem;
    }
    
    .improvement-text {
        font-size: 0.8rem;
    }
}
</style>
@endsection