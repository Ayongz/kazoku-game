@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h2 style="color:black;">🌟 Class Path Tree 🌟</h2>
                    <p class="mb-0" style="color:black;">Complete overview of all available classes and their progression paths</p>
                </div>
                <div class="card-body">
                    <!-- Class Selection Info -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>📋 Class System Overview:</strong><br>
                                • <strong>Level 4:</strong> Choose your first class<br>
                                • <strong>Level 8:</strong> Advance to enhanced version<br>
                                • <strong>Selection:</strong> Permanent choice
                            </div>
                            <div class="col-md-6">
                                <strong>🎯 Your Status:</strong><br>
                                • <strong>Current Level:</strong> {{ $user->level }}<br>
                                • <strong>Current Class:</strong> {{ $user->selected_class ? $user->getClassDisplayName() : 'None' }}<br>
                                • <strong>Can Select:</strong> {{ $user->canSelectClass() ? 'Yes' : 'No' }}
                                @if($user->canAdvanceClass())
                                    <br>• <strong style="color: #ffc107;">⭐ Ready to Advance! ⭐</strong>
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
                                    <h4 class="mb-0">{{ $classInfo['icon'] }} {{ $classInfo['name'] }}</h4>
                                    @if($user->selected_class === $classKey)
                                        <small class="badge bg-white text-success mt-1">✓ YOUR CLASS</small>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <p class="text-muted mb-3">{{ $classInfo['description'] }}</p>
                                    
                                    <!-- Basic Class Abilities -->
                                    <div class="mb-3">
                                        <h6 class="text-primary fw-bold">🔹 Basic Class (Level 4)</h6>
                                        <div class="basic-abilities p-2 bg-light rounded">
                                            @if($classKey === 'treasure_hunter')
                                                <div class="ability-item">
                                                    <i class="fas fa-key text-warning me-2"></i>
                                                    <strong>{{ $classInfo['basic_percentage'] }}%</strong> chance for free treasure attempts
                                                </div>
                                            @elseif($classKey === 'proud_merchant')
                                                <div class="ability-item">
                                                    <i class="fas fa-coins text-warning me-2"></i>
                                                    <strong>+{{ $classInfo['basic_percentage'] }}%</strong> bonus earnings from treasure
                                                </div>
                                            @elseif($classKey === 'fortune_gambler')
                                                <div class="ability-item">
                                                    <i class="fas fa-dice text-success me-2"></i>
                                                    <strong>{{ $classInfo['basic_double_chance'] }}%</strong> chance to double earnings
                                                </div>
                                                <div class="ability-item">
                                                    <i class="fas fa-skull text-danger me-2"></i>
                                                    <strong>{{ $classInfo['basic_lose_chance'] }}%</strong> chance to lose everything
                                                </div>
                                            @elseif($classKey === 'moon_guardian')
                                                <div class="ability-item">
                                                    <i class="fas fa-moon text-info me-2"></i>
                                                    <strong>{{ $classInfo['basic_percentage'] }}%</strong> chance for random box (6 PM - 6 AM)
                                                </div>
                                            @elseif($classKey === 'day_breaker')
                                                <div class="ability-item">
                                                    <i class="fas fa-sun text-warning me-2"></i>
                                                    <strong>{{ $classInfo['basic_percentage'] }}%</strong> chance for random box (6 AM - 6 PM)
                                                </div>
                                            @elseif($classKey === 'box_collector')
                                                <div class="ability-item">
                                                    <i class="fas fa-boxes text-primary me-2"></i>
                                                    <strong>{{ $classInfo['basic_percentage'] }}%</strong> chance for 2 random boxes
                                                </div>
                                            @elseif($classKey === 'divine_scholar')
                                                <div class="ability-item">
                                                    <i class="fas fa-graduation-cap text-info me-2"></i>
                                                    <strong>+{{ $classInfo['basic_percentage'] }}%</strong> bonus experience from treasure
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Advancement Arrow -->
                                    <div class="text-center mb-3">
                                        <div class="advancement-arrow">
                                            <i class="fas fa-arrow-down text-muted"></i>
                                            <small class="text-muted d-block">Advance at Level 8</small>
                                            <i class="fas fa-arrow-down text-muted"></i>
                                        </div>
                                    </div>

                                    <!-- Advanced Class Abilities -->
                                    <div class="mb-3">
                                        <h6 class="text-warning fw-bold">⭐ Advanced Class (Level 8)</h6>
                                        <div class="text-center mb-2">
                                            <span class="badge bg-warning text-dark px-3 py-1">{{ $classInfo['advanced_name'] }}</span>
                                        </div>
                                        <div class="advanced-abilities p-2 bg-warning bg-opacity-10 rounded border border-warning">
                                            @if($classKey === 'treasure_hunter')
                                                <div class="ability-item">
                                                    <i class="fas fa-key text-warning me-2"></i>
                                                    <strong>{{ $classInfo['advanced_percentage'] }}%</strong> chance for free treasure attempts
                                                </div>
                                            @elseif($classKey === 'proud_merchant')
                                                <div class="ability-item">
                                                    <i class="fas fa-coins text-warning me-2"></i>
                                                    <strong>+{{ $classInfo['advanced_percentage'] }}%</strong> bonus earnings from treasure
                                                </div>
                                            @elseif($classKey === 'fortune_gambler')
                                                <div class="ability-item">
                                                    <i class="fas fa-dice text-success me-2"></i>
                                                    <strong>{{ $classInfo['advanced_double_chance'] }}%</strong> chance to double earnings
                                                </div>
                                                <div class="ability-item">
                                                    <i class="fas fa-skull text-danger me-2"></i>
                                                    <strong>{{ $classInfo['advanced_lose_chance'] }}%</strong> chance to lose everything
                                                </div>
                                            @elseif($classKey === 'moon_guardian')
                                                <div class="ability-item">
                                                    <i class="fas fa-moon text-info me-2"></i>
                                                    <strong>{{ $classInfo['advanced_percentage'] }}%</strong> chance for random box (6 PM - 6 AM)
                                                </div>
                                            @elseif($classKey === 'day_breaker')
                                                <div class="ability-item">
                                                    <i class="fas fa-sun text-warning me-2"></i>
                                                    <strong>{{ $classInfo['advanced_percentage'] }}%</strong> chance for random box (6 AM - 6 PM)
                                                </div>
                                            @elseif($classKey === 'box_collector')
                                                <div class="ability-item">
                                                    <i class="fas fa-boxes text-primary me-2"></i>
                                                    <strong>{{ $classInfo['advanced_percentage'] }}%</strong> chance for 2 random boxes
                                                </div>
                                            @elseif($classKey === 'divine_scholar')
                                                <div class="ability-item">
                                                    <i class="fas fa-graduation-cap text-info me-2"></i>
                                                    <strong>+{{ $classInfo['advanced_percentage'] }}%</strong> bonus experience from treasure
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Improvement Summary -->
                                    <div class="improvement-summary p-2 bg-secondary bg-opacity-10 rounded">
                                        <small class="text-muted">
                                            <i class="fas fa-chart-line me-1"></i>
                                            <strong>Improvement:</strong>
                                            @if($classKey === 'fortune_gambler')
                                                +{{ $classInfo['advanced_double_chance'] - $classInfo['basic_double_chance'] }}% double chance, 
                                                +{{ $classInfo['advanced_lose_chance'] - $classInfo['basic_lose_chance'] }}% risk
                                            @else
                                                +{{ $classInfo['advanced_percentage'] - $classInfo['basic_percentage'] }}{{ $classKey === 'proud_merchant' || $classKey === 'divine_scholar' ? '% more' : '% higher chance' }}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="card-footer text-center">
                                    @if(!$user->selected_class && $user->canSelectClass())
                                        <a href="{{ route('game.class-selection') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-hand-pointer me-1"></i>Choose This Class
                                        </a>
                                    @elseif($user->selected_class === $classKey && $user->canAdvanceClass())
                                        <form action="{{ route('game.advance-class') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-star me-1"></i>Advance Now
                                            </button>
                                        </form>
                                    @elseif($user->selected_class === $classKey && $user->has_advanced_class)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-crown me-1"></i>Fully Advanced
                                        </span>
                                    @elseif($user->selected_class === $classKey)
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Advance at Level 8
                                        </span>
                                    @elseif($user->selected_class)
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-lock me-1"></i>Class Already Selected
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-level-up-alt me-1"></i>Reach Level 4
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
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            @if($user->canSelectClass())
                                <a href="{{ route('game.class-selection') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-hand-pointer me-2"></i>Select Class Now
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