@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    📚 {{ __('nav.game_guide') }}
                </h1>
                <p class="text-muted fs-5">{{ __('nav.complete_walkthrough') }}</p>
                <div class="alert alert-info border-0 shadow-sm">
                    <p class="mb-0">{{ __('nav.guide_intro') }}</p>
                </div>
            </div>

            <!-- Table of Contents -->
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-list me-2"></i>{{ __('nav.table_of_contents') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><a href="#basic-gameplay" class="text-decoration-none">1. {{ __('nav.basic_gameplay') }}</a></li>
                                <li><a href="#treasure-mechanics" class="text-decoration-none">2. {{ __('nav.treasure_mechanics') }}</a></li>
                                <li><a href="#class-system" class="text-decoration-none">3. {{ __('nav.class_system') }}</a></li>
                                <li><a href="#upgrade-system" class="text-decoration-none">4. {{ __('nav.upgrade_system') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><a href="#random-boxes" class="text-decoration-none">5. {{ __('nav.random_boxes') }}</a></li>
                                <li><a href="#day-night-cycle" class="text-decoration-none">6. {{ __('nav.day_night_cycle') }}</a></li>
                                <li><a href="#pvp-system" class="text-decoration-none">7. {{ __('nav.pvp_system') }}</a></li>
                                <li><a href="#tips-strategies" class="text-decoration-none">8. {{ __('nav.tips_strategies') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1. Basic Gameplay -->
            <div class="card shadow-lg border-0 mb-5" id="basic-gameplay">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="fas fa-play me-2"></i>1. {{ __('nav.basic_gameplay') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="text-success">{{ __('nav.getting_started') }}</h5>
                            <p>{{ __('nav.getting_started_desc') }}</p>
                            
                            <h5 class="text-success mt-4">{{ __('nav.earning_money') }}</h5>
                            <p>{{ __('nav.earning_money_desc') }}</p>
                            
                            <h5 class="text-success mt-4">{{ __('nav.treasure_regeneration') }}</h5>
                            <p>{{ __('nav.treasure_regeneration_desc') }}</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg-light p-3 rounded">
                                <h6 class="fw-bold text-primary">{{ __('nav.how_to_play') }}</h6>
                                <ol class="small">
                                    <li>{{ __('nav.register_and_login') }}</li>
                                    <li>{{ __('nav.open_treasures') }}</li>
                                    <li>{{ __('nav.choose_class_level_4') }}</li>
                                    <li>{{ __('nav.upgrade_abilities') }}</li>
                                    <li>{{ __('nav.compete_leaderboards') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Treasure Mechanics -->
            <div class="card shadow-lg border-0 mb-5" id="treasure-mechanics">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="fas fa-gem me-2"></i>2. {{ __('nav.treasure_mechanics_title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-warning">{{ __('nav.treasure_capacity') }}</h5>
                            <p>{{ __('nav.treasure_capacity_desc') }}</p>
                            
                            <h5 class="text-warning mt-4">{{ __('nav.treasure_multiplier_effect') }}</h5>
                            <p>{{ __('nav.treasure_multiplier_effect_desc') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-warning">{{ __('nav.treasure_rarity_system') }}</h5>
                            <p>{{ __('nav.treasure_rarity_system_desc') }}</p>
                            
                            <div class="mt-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-secondary me-2">{{ __('nav.common') }}</span>
                                    <span class="badge bg-success me-2">{{ __('nav.uncommon') }}</span>
                                    <span class="badge bg-primary me-2">{{ __('nav.rare') }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-purple me-2">{{ __('nav.epic') }}</span>
                                    <span class="badge bg-warning me-2">{{ __('nav.legendary') }}</span>
                                    <span class="badge bg-info me-2">{{ __('nav.mythical') }}</span>
                                    <span class="badge bg-danger">{{ __('nav.divine') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Class System -->
            <div class="card shadow-lg border-0 mb-5" id="class-system">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-tree me-2"></i>3. {{ __('nav.class_system_title') }}</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-primary">{{ __('nav.choosing_class') }}</h5>
                    <p>{{ __('nav.choosing_class_desc') }}</p>
                    
                    <h5 class="text-primary mt-4">{{ __('nav.available_classes') }}</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>�️ {{ __('nav.treasure_hunter') }}:</strong> {{ __('nav.treasure_hunter_guide') }}</li>
                                <li class="mb-2"><strong>� {{ __('nav.proud_merchant') }}:</strong> {{ __('nav.proud_merchant_guide') }}</li>
                                <li class="mb-2"><strong>🎰 {{ __('nav.fortune_gambler') }}:</strong> {{ __('nav.fortune_gambler_guide') }}</li>
                                <li class="mb-2"><strong>� {{ __('nav.moon_guardian') }}:</strong> {{ __('nav.moon_guardian_guide') }}</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>☀️ {{ __('nav.day_breaker') }}:</strong> {{ __('nav.day_breaker_guide') }}</li>
                                <li class="mb-2"><strong>� {{ __('nav.box_collector') }}:</strong> {{ __('nav.box_collector_guide') }}</li>
                                <li class="mb-2"><strong>� {{ __('nav.divine_scholar') }}:</strong> {{ __('nav.divine_scholar_guide') }}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <h6 class="fw-bold">{{ __('nav.class_advancement') }}</h6>
                        <p class="mb-0">{{ __('nav.class_advancement_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- 4. Upgrade System -->
            <div class="card shadow-lg border-0 mb-5" id="upgrade-system">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0"><i class="fas fa-store me-2"></i>4. {{ __('nav.upgrade_system_title') }}</h3>
                </div>
                <div class="card-body">
                    <h5 class="text-info">{{ __('nav.visiting_store') }}</h5>
                    <p>{{ __('nav.visiting_store_desc') }}</p>
                    
                    <h5 class="text-info mt-4">{{ __('nav.available_upgrades') }}</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <h6><span class="badge bg-danger">{{ __('nav.auto_steal') }}</span></h6>
                                <p class="small">{{ __('nav.auto_steal_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-warning text-dark">{{ __('nav.auto_earning') }}</span></h6>
                                <p class="small">{{ __('nav.auto_earning_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-info">{{ __('nav.shield_protection') }}</span></h6>
                                <p class="small">{{ __('nav.shield_protection_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-warning text-dark">{{ __('nav.treasure_multiplier') }}</span></h6>
                                <p class="small">{{ __('nav.treasure_multiplier_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-success">{{ __('nav.lucky_strikes') }}</span></h6>
                                <p class="small">{{ __('nav.lucky_strikes_guide') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <h6><span class="badge bg-dark">{{ __('nav.counter_attack') }}</span></h6>
                                <p class="small">{{ __('nav.counter_attack_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-warning text-dark">{{ __('nav.intimidation') }}</span></h6>
                                <p class="small">{{ __('nav.intimidation_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-primary">{{ __('nav.fast_recovery') }}</span></h6>
                                <p class="small">{{ __('nav.fast_recovery_guide') }}</p>
                            </div>
                            <div class="mb-3">
                                <h6><span class="badge bg-purple text-white">{{ __('nav.treasure_rarity') }}</span></h6>
                                <p class="small">{{ __('nav.treasure_rarity_guide') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Random Boxes -->
            <div class="card shadow-lg border-0 mb-5" id="random-boxes">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0"><i class="fas fa-gift me-2"></i>5. {{ __('nav.random_boxes_title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="text-secondary">{{ __('nav.earning_boxes') }}</h5>
                            <p>{{ __('nav.earning_boxes_desc') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-secondary">{{ __('nav.opening_boxes') }}</h5>
                            <p>{{ __('nav.opening_boxes_desc') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-secondary">{{ __('nav.box_rewards') }}</h5>
                            <p>{{ __('nav.box_rewards_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Day/Night Cycle -->
            <div class="card shadow-lg border-0 mb-5" id="day-night-cycle">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="fas fa-clock me-2"></i>6. {{ __('nav.day_night_cycle_title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border border-warning rounded p-3">
                                <h5 class="text-warning">☀️ {{ __('nav.day_mode') }}</h5>
                                <p>{{ __('nav.day_mode_desc') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border border-primary rounded p-3">
                                <h5 class="text-primary">🌙 {{ __('nav.night_mode') }}</h5>
                                <p>{{ __('nav.night_mode_desc') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-4">
                        <h6 class="fw-bold">{{ __('nav.time_strategy') }}</h6>
                        <p class="mb-0">{{ __('nav.time_strategy_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- 7. PvP System -->
            <div class="card shadow-lg border-0 mb-5" id="pvp-system">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0"><i class="fas fa-sword me-2"></i>7. {{ __('nav.pvp_system_title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-danger">{{ __('nav.steal_mechanics') }}</h5>
                            <p>{{ __('nav.steal_mechanics_desc') }}</p>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="text-danger">{{ __('nav.defense_options') }}</h5>
                            <p>{{ __('nav.defense_options_desc') }}</p>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="text-danger">{{ __('nav.steal_amounts') }}</h5>
                            <p>{{ __('nav.steal_amounts_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. Tips & Strategies -->
            <div class="card shadow-lg border-0 mb-5" id="tips-strategies">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="fas fa-lightbulb me-2"></i>8. {{ __('nav.tips_strategies_title') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <h5 class="text-success">{{ __('nav.beginner_tips') }}</h5>
                            <ul class="small">
                                <li>{{ __('nav.beginner_tip_1') }}</li>
                                <li>{{ __('nav.beginner_tip_2') }}</li>
                                <li>{{ __('nav.beginner_tip_3') }}</li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="text-success">{{ __('nav.intermediate_tips') }}</h5>
                            <ul class="small">
                                <li>{{ __('nav.intermediate_tip_1') }}</li>
                                <li>{{ __('nav.intermediate_tip_2') }}</li>
                                <li>{{ __('nav.intermediate_tip_3') }}</li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="text-success">{{ __('nav.advanced_tips') }}</h5>
                            <ul class="small">
                                <li>{{ __('nav.advanced_tip_1') }}</li>
                                <li>{{ __('nav.advanced_tip_2') }}</li>
                                <li>{{ __('nav.advanced_tip_3') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-star me-2"></i>{{ __('nav.experience_levels') }}</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ __('nav.experience_levels_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>{{ __('nav.leaderboard_competition') }}</h5>
                        </div>
                        <div class="card-body">
                            <p>{{ __('nav.leaderboard_competition_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Game Button -->
            <div class="text-center">
                <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('nav.back_to_game') }}
                </a>
                <a href="{{ route('store.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-store me-2"></i>{{ __('nav.visit_store') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styling for guide page */
.bg-purple {
    background-color: #6f42c1 !important;
}

.text-purple {
    color: #6f42c1 !important;
}

.card-header h3 {
    font-size: 1.5rem;
}

.card-body h5 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.badge {
    font-size: 0.9rem;
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Hover effects for table of contents */
a[href^="#"]:hover {
    color: #0d6efd !important;
    text-decoration: underline !important;
}

/* Card hover effects */
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

/* Badge spacing */
.badge + .badge {
    margin-left: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header h3 {
        font-size: 1.25rem;
    }
    
    .card-body h5 {
        font-size: 1.1rem;
    }
    
    .btn-lg {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
    }
}
</style>
@endsection