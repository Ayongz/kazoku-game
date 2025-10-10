@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h2 style="color:black;">🌟 {{ __('nav.class_path_tree') }} 🌟</h2>
                    <p class="mb-0" style="color:black;">{{ __('nav.class_path_overview') }}</p>
                </div>
                <div class="card-body">
                    <!-- Class Selection Info -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>📋 {{ __('nav.class_system_overview') }}:</strong><br>
                                • <strong>{{ __('nav.level') }} 4:</strong> {{ __('nav.level_4_choose') }}<br>
                                • <strong>{{ __('nav.level') }} 8:</strong> {{ __('nav.level_8_advance') }}<br>
                                • <strong>{{ __('nav.selection_permanent') }}:</strong> {{ __('nav.selection_permanent') }}
                            </div>
                            <div class="col-md-6">
                                <strong>🎯 {{ __('nav.your_status') }}:</strong><br>
                                • <strong>{{ __('nav.current_level') }}:</strong> {{ $user->level }}<br>
                                • <strong>{{ __('nav.current_class') }}:</strong> {{ $user->selected_class ? $user->getClassDisplayName() : __('nav.none') }}<br>
                                • <strong>{{ __('nav.can_select') }}:</strong> {{ $user->canSelectClass() ? __('nav.yes') : __('nav.no') }}
                                @if($user->canAdvanceClass())
                                    <br>• <strong style="color: #ffc107;">⭐ {{ __('nav.ready_to_advance') }} ⭐</strong>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Class Tree Grid -->
                    <div class="row">
                        @foreach($classData as $classKey => $classInfo)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 border-2 
                                @if($user->selected_class === $classKey) 
                                    border-success bg-light-success
                                @else 
                                    border-light hover-shadow
                                @endif
                            ">
                                <!-- Basic Class Header -->
                                <div class="card-header text-center 
                                    @if($user->selected_class === $classKey) 
                                        bg-success text-white
                                    @else 
                                        bg-light
                                    @endif
                                ">
                                    <h4 class="mb-0">{{ $classInfo['icon'] }} 
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
                                        <small class="badge bg-white text-success mt-1">✓ {{ __('nav.your_class') }}</small>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <p class="text-muted mb-3">
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
                                    
                                    <!-- Basic Class Abilities -->
                                    <div class="mb-3">
                                        <h6 class="text-primary fw-bold">🔹 {{ __('nav.basic_class_level_4') }}</h6>
                                        <div class="basic-abilities p-2 bg-light rounded">
                                            @if($classKey === 'treasure_hunter')
                                                <div class="ability-item">
                                                    <i class="fas fa-key text-warning me-2"></i>
                                                    {{ __('nav.chance_free_attempts', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'proud_merchant')
                                                <div class="ability-item">
                                                    <i class="fas fa-coins text-warning me-2"></i>
                                                    {{ __('nav.bonus_earnings', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'fortune_gambler')
                                                <div class="ability-item">
                                                    <i class="fas fa-dice text-success me-2"></i>
                                                    {{ __('nav.chance_double_earnings', ['percent' => $classInfo['basic_double_chance']]) }}
                                                </div>
                                                <div class="ability-item">
                                                    <i class="fas fa-skull text-danger me-2"></i>
                                                    {{ __('nav.chance_lose_everything', ['percent' => $classInfo['basic_lose_chance']]) }}
                                                </div>
                                            @elseif($classKey === 'moon_guardian')
                                                <div class="ability-item">
                                                    <i class="fas fa-moon text-info me-2"></i>
                                                    {{ __('nav.chance_random_box_night', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'day_breaker')
                                                <div class="ability-item">
                                                    <i class="fas fa-sun text-warning me-2"></i>
                                                    {{ __('nav.chance_random_box_day', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'box_collector')
                                                <div class="ability-item">
                                                    <i class="fas fa-boxes text-primary me-2"></i>
                                                    {{ __('nav.chance_2_random_boxes', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'divine_scholar')
                                                <div class="ability-item">
                                                    <i class="fas fa-graduation-cap text-info me-2"></i>
                                                    {{ __('nav.bonus_experience', ['percent' => $classInfo['basic_percentage']]) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Advancement Arrow -->
                                    <div class="text-center mb-3">
                                        <div class="advancement-arrow">
                                            <i class="fas fa-arrow-down text-muted"></i>
                                            <small class="text-muted d-block">{{ __('nav.advance_at_level_8') }}</small>
                                            <i class="fas fa-arrow-down text-muted"></i>
                                        </div>
                                    </div>

                                    <!-- Advanced Class Abilities -->
                                    <div class="mb-3">
                                        <h6 class="text-warning fw-bold">⭐ {{ __('nav.advanced_class_level_8') }}</h6>
                                        <div class="text-center mb-2">
                                            <span class="badge bg-warning text-dark px-3 py-1">
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
                                            </span>
                                        </div>
                                        <div class="advanced-abilities p-2 bg-warning bg-opacity-10 rounded border border-warning">
                                            @if($classKey === 'treasure_hunter')
                                                <div class="ability-item">
                                                    <i class="fas fa-key text-warning me-2"></i>
                                                    {{ __('nav.chance_free_attempts', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'proud_merchant')
                                                <div class="ability-item">
                                                    <i class="fas fa-coins text-warning me-2"></i>
                                                    {{ __('nav.bonus_earnings', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'fortune_gambler')
                                                <div class="ability-item">
                                                    <i class="fas fa-dice text-success me-2"></i>
                                                    {{ __('nav.chance_double_earnings', ['percent' => $classInfo['advanced_double_chance']]) }}
                                                </div>
                                                <div class="ability-item">
                                                    <i class="fas fa-skull text-danger me-2"></i>
                                                    {{ __('nav.chance_lose_everything', ['percent' => $classInfo['advanced_lose_chance']]) }}
                                                </div>
                                            @elseif($classKey === 'moon_guardian')
                                                <div class="ability-item">
                                                    <i class="fas fa-moon text-info me-2"></i>
                                                    {{ __('nav.chance_random_box_night', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'day_breaker')
                                                <div class="ability-item">
                                                    <i class="fas fa-sun text-warning me-2"></i>
                                                    {{ __('nav.chance_random_box_day', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'box_collector')
                                                <div class="ability-item">
                                                    <i class="fas fa-boxes text-primary me-2"></i>
                                                    {{ __('nav.chance_2_random_boxes', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @elseif($classKey === 'divine_scholar')
                                                <div class="ability-item">
                                                    <i class="fas fa-graduation-cap text-info me-2"></i>
                                                    {{ __('nav.bonus_experience', ['percent' => $classInfo['advanced_percentage']]) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Improvement Summary -->
                                    <div class="improvement-summary p-2 bg-secondary bg-opacity-10 rounded">
                                        <small class="text-muted">
                                            <i class="fas fa-chart-line me-1"></i>
                                            <strong>{{ __('nav.improvement') }}:</strong>
                                            @if($classKey === 'fortune_gambler')
                                                +{{ $classInfo['advanced_double_chance'] - $classInfo['basic_double_chance'] }}% {{ __('nav.double_chance') }}, 
                                                +{{ $classInfo['advanced_lose_chance'] - $classInfo['basic_lose_chance'] }}% {{ __('nav.risk') }}
                                            @else
                                                +{{ $classInfo['advanced_percentage'] - $classInfo['basic_percentage'] }}{{ $classKey === 'proud_merchant' || $classKey === 'divine_scholar' ? '% ' . __('nav.more') : '% ' . __('nav.higher_chance') }}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="card-footer text-center">
                                    @if(!$user->selected_class && $user->canSelectClass())
                                        <a href="{{ route('game.class-selection') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-hand-pointer me-1"></i>{{ __('nav.select_class') }}
                                        </a>
                                    @elseif($user->selected_class === $classKey && $user->canAdvanceClass())
                                        <form action="{{ route('game.advance-class') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-star me-1"></i>{{ __('nav.advance_class') }}
                                            </button>
                                        </form>
                                    @elseif($user->selected_class === $classKey && $user->has_advanced_class)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-crown me-1"></i>{{ __('nav.fully_advanced') }}
                                        </span>
                                    @elseif($user->selected_class === $classKey)
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>{{ __('nav.advance_at_level_8') }}
                                        </span>
                                    @elseif($user->selected_class)
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-lock me-1"></i>{{ __('nav.class_already_selected') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-level-up-alt me-1"></i>{{ __('nav.reach_level_requirement', ['level' => 4]) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Actions -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <a href="{{ route('game.dashboard') }}" class="btn btn-secondary btn-lg me-3">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('nav.back_to_dashboard') }}
                            </a>
                            @if($user->canSelectClass())
                                <a href="{{ route('game.class-selection') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-hand-pointer me-2"></i>{{ __('nav.select_class') }} Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.bg-light-success {
    background-color: #f8fff9 !important;
}

.ability-item {
    margin-bottom: 8px;
    padding: 4px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.ability-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.advancement-arrow {
    padding: 10px 0;
}

.improvement-summary {
    border-left: 4px solid #6c757d;
}

@media (max-width: 768px) {
    .col-lg-6.col-xl-4 {
        padding-left: 8px;
        padding-right: 8px;
    }
}
</style>
@endsection