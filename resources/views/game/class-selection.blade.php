@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>🏅 Class Selection - Level {{ $user->level }}</h2>
                    <p class="mb-0">Choose your path and unlock special abilities!</p>
                </div>
                <div class="card-body">
                    <div class="alert alert-info text-center mb-4">
                        <strong>Congratulations!</strong> You've reached level {{ $user->level }} and can now choose a class.
                        Each class provides unique abilities that will enhance your treasure hunting experience.
                    </div>

                    <form action="{{ route('game.select-class') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            @foreach($availableClasses as $classKey => $classInfo)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 class-card" style="cursor: pointer;" onclick="selectClassCard('{{ $classKey }}')">
                                    <div class="card-header text-center bg-light">
                                        <h4 class="mb-0">{{ $classInfo['icon'] }} {{ $classInfo['name'] }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $classInfo['description'] }}</p>
                                        
                                        <h6 class="text-primary">Class Abilities:</h6>
                                        <ul class="list-unstyled small">
                                            @foreach($classInfo['abilities'] as $ability)
                                            <li>✓ {{ $ability }}</li>
                                            @endforeach
                                        </ul>
                                        
                                        @if($user->level >= 8)
                                        <div class="mt-3 p-2 bg-warning bg-opacity-10 rounded">
                                            <h6 class="text-warning mb-1">Advanced Version Available</h6>
                                            <small class="text-muted">Enhanced abilities when you advance this class at level 8!</small>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-footer text-center">
                                        <input type="radio" name="class" value="{{ $classKey }}" id="class_{{ $classKey }}" class="form-check-input" required>
                                        <label for="class_{{ $classKey }}" class="form-check-label ms-2">
                                            <strong>Select {{ $classInfo['name'] }}</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    🎯 Confirm Class Selection
                                </button>
                                <a href="{{ route('game.dashboard') }}" class="btn btn-secondary btn-lg px-5 ms-3">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="alert alert-warning mt-4">
                        <strong>Important:</strong> Class selection is permanent! Choose carefully as you cannot change your class later.
                        @if($user->level >= 8)
                        However, you can advance your class to unlock enhanced abilities.
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