@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>🏅 {{ __('nav.class_selection_level', ['level' => $user->level]) }}</h2>
                    <p class="mb-0">{{ __('nav.choose_path_unlock') }}</p>
                </div>
                <div class="card-body">
                    <div class="alert alert-info text-center mb-4">
                        <strong>{{ __('nav.congratulations_reached', ['level' => $user->level]) }}</strong>
                        {{ __('nav.class_enhance_experience') }}
                    </div>

                    <form action="{{ route('game.select-class') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            @foreach($availableClasses as $classKey => $classInfo)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 class-card" style="cursor: pointer;" onclick="selectClassCard('{{ $classKey }}')">
                                    <div class="card-header text-center bg-light">
                                        <h4 class="mb-0">{{ $classInfo['icon'] }} 
                                            @if($classKey == 'treasure_hunter')
                                                {{ __('nav.treasure_hunter') }}
                                            @elseif($classKey == 'proud_merchant')
                                                {{ __('nav.proud_merchant') }}
                                            @elseif($classKey == 'skilled_pirate')
                                                {{ __('nav.skilled_pirate') }}
                                            @elseif($classKey == 'swift_explorer')
                                                {{ __('nav.swift_explorer') }}
                                            @elseif($classKey == 'lucky_adventurer')
                                                {{ __('nav.lucky_adventurer') }}
                                            @elseif($classKey == 'fortune_seeker')
                                                {{ __('nav.fortune_seeker') }}
                                            @elseif($classKey == 'master_collector')
                                                {{ __('nav.master_collector') }}
                                            @else
                                                {{ $classInfo['name'] }}
                                            @endif
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            @if($classKey == 'treasure_hunter')
                                                {{ __('nav.treasure_hunter_desc') }}
                                            @elseif($classKey == 'proud_merchant')
                                                {{ __('nav.proud_merchant_desc') }}
                                            @elseif($classKey == 'skilled_pirate')
                                                {{ __('nav.skilled_pirate_desc') }}
                                            @elseif($classKey == 'swift_explorer')
                                                {{ __('nav.swift_explorer_desc') }}
                                            @elseif($classKey == 'lucky_adventurer')
                                                {{ __('nav.lucky_adventurer_desc') }}
                                            @elseif($classKey == 'fortune_seeker')
                                                {{ __('nav.fortune_seeker_desc') }}
                                            @elseif($classKey == 'master_collector')
                                                {{ __('nav.master_collector_desc') }}
                                            @else
                                                {{ $classInfo['description'] }}
                                            @endif
                                        </p>
                                        
                                        <h6 class="text-primary">{{ __('nav.class_abilities') }}:</h6>
                                        <ul class="list-unstyled small">
                                            @foreach($classInfo['abilities'] as $ability)
                                            <li>✓ {{ $ability }}</li>
                                            @endforeach
                                        </ul>
                                        
                                        @if($user->level >= 8)
                                        <div class="mt-3 p-2 bg-warning bg-opacity-10 rounded">
                                            <h6 class="text-warning mb-1">{{ __('nav.advanced_version_available') }}</h6>
                                            <small class="text-muted">{{ __('nav.enhanced_abilities_level_8') }}</small>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-footer text-center">
                                        <input type="radio" name="class" value="{{ $classKey }}" id="class_{{ $classKey }}" class="form-check-input" required>
                                        <label for="class_{{ $classKey }}" class="form-check-label ms-2">
                                            <strong>{{ __('nav.select_class_name', ['class' => $classInfo['name']]) }}</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    🎯 {{ __('nav.confirm_selection') }}
                                </button>
                                <a href="{{ route('game.dashboard') }}" class="btn btn-secondary btn-lg px-5 ms-3">
                                    {{ __('nav.cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-warning mt-4">
                        <strong>{{ __('nav.warning_permanent') }}</strong> {{ __('nav.cannot_change_later') }}
                        @if($user->level >= 8)
                        {{ __('nav.can_advance_class') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.class-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.class-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    border-color: #007bff;
}

.class-card.selected {
    border-color: #28a745;
    background-color: #f8fff9;
}

.form-check-input:checked + .form-check-label {
    color: #28a745;
    font-weight: bold;
}
</style>

<script>
function selectClassCard(classKey) {
    // Remove selected class from all cards
    document.querySelectorAll('.class-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Select the radio button
    document.getElementById('class_' + classKey).checked = true;
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
}

// Add click handler for radio buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="class"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.class-card').forEach(card => {
                card.classList.remove('selected');
            });
            this.closest('.class-card').classList.add('selected');
        });
    });
});
</script>
@endsection