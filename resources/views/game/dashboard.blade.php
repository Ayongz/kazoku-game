@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-5">
                The Game Dashboard
            </h1>

            <!-- Status Messages -->
            @if (session('success') && !str_contains(session('success'), 'Heist successful!') && !str_contains(session('success'), 'BONUS: Stole'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">Success!</p>
                    <p class="mb-0">{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">Error!</p>
                    <p class="mb-0">{{ session('error') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Player & Global Stats - Responsive Grid -->
            <div class="row g-4 mb-5">
                <!-- Player Money Card -->
                <div class="col-12 col-md-3">
                    <div class="card h-100 shadow-lg border-start border-5 border-primary">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Money Earned</p>
                            <h2 class="card-title h3 fw-bolder text-dark" id="playerMoneyDisplay">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Treasure Card -->
                <div class="col-12 col-md-3">
                    <div class="card h-100 shadow-lg border-start border-5 border-warning">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Current Treasure</p>
                            <h2 class="card-title h3 fw-bolder @if($user->treasure > 0) text-warning @else text-danger @endif" id="playerTreasureDisplay">
                                {{ $user->treasure }} / {{ 20 + ($user->treasure_multiplier_level * 5) }}
                            </h2>
                            <p class="text-muted small mb-0">
                                +5 treasure every hour 
                                @if($user->treasure_multiplier_level > 0)
                                    (max {{ 20 + ($user->treasure_multiplier_level * 5) }} - Level {{ $user->treasure_multiplier_level }})
                                @else
                                    (max 20)
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Shield Protection Card -->
                <div class="col-12 col-md-3">
                    <div class="card h-100 shadow-lg border-start border-5 @if($user->shield_expires_at && $user->shield_expires_at > now()) border-success @else border-secondary @endif">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Shield Status</p>
                            @if($user->shield_expires_at && $user->shield_expires_at > now())
                                <h2 class="card-title h4 fw-bolder text-success mb-2">
                                    <i class="fas fa-shield-alt me-1"></i>ACTIVE
                                </h2>
                                <p class="text-muted small mb-0">
                                    Protected until<br>
                                    <strong>{{ $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('M d, H:i:s') }}</strong>
                                </p>
                            @else
                                <h2 class="card-title h4 fw-bolder text-secondary mb-2">
                                    <i class="fas fa-shield-alt me-1"></i>INACTIVE
                                </h2>
                                <p class="text-muted small mb-0">
                                    <a href="{{ route('store.index') }}" class="text-decoration-none">Visit Store</a> to activate
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Global Prize Pool Card -->
                <div class="col-12 col-md-3">
                    <div class="card h-100 shadow-lg border-start border-5 border-info">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Global Prize Pool</p>
                            <h2 class="card-title h3 fw-bolder text-info" id="globalPrizePoolDisplay">
                                IDR {{ $globalPrizePool }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game Actions Section -->
            <div class="row g-5">
                
                <!-- 1. EARN MONEY ACTION -->
                <div class="col-12">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="h3 fw-bold text-primary mb-0">Daily Grind</h2>
                                
                                <!-- Auto Click Toggle -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="autoClickToggle" 
                                           @if($user->treasure <= 0) disabled @endif>
                                    <label class="form-check-label fw-bold text-primary" for="autoClickToggle">
                                        <i class="fas fa-robot me-1"></i>Auto Click
                                    </label>
                                </div>
                            </div>
                            
                            <p class="text-muted mb-4">
                                Click below to try and earn money. Uses one treasure.
                                @if($user->steal_level > 0)
                                    <br><small class="text-info"><i class="fas fa-mask me-1"></i><strong>Bonus:</strong> Also attempts to steal from other players ({{ $user->steal_level * 5 }}% chance)!</small>
                                @endif
                            </p>
                            
                            <form method="POST" action="{{ route('game.earn') }}" id="earnMoneyForm">
                                @csrf
                                <button type="submit" id="earnMoneyBtn"
                                        class="btn btn-lg w-100 w-sm-auto fw-bold text-uppercase @if($user->treasure > 0) btn-primary @else btn-secondary disabled @endif"
                                        @if($user->treasure <= 0) disabled @endif>
                                    @if($user->treasure > 0)
                                        <i class="fas fa-coins me-2"></i> OPEN TREASURE NOW
                                    @else
                                        OUT OF TREASURE
                                    @endif
                                </button>
                            </form>
                            
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
        </div>
    </div>
</div>

<!-- Auto Click JavaScript -->
<style>
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
    
    // Auto click toggle event
    autoClickToggle.addEventListener('change', function() {
        if (this.checked) {
            startAutoClick();
        } else {
            stopAutoClick();
        }
    });
    
    function startAutoClick() {
        if (currentTreasure <= 0) {
            autoClickToggle.checked = false;
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
        
        autoClickStatus.style.display = 'block';
        clickCount = 0;
        updateAutoClickStatus();
        
        // Auto click every 2.5 seconds to avoid overwhelming the server
        autoClickInterval = setInterval(() => {
            if (!isProcessing && currentTreasure > 0) {
                performAutoClick();
            } else if (currentTreasure <= 0) {
                stopAutoClickWithMessage();
            }
        }, 2500);
    }
    
    function stopAutoClick() {
        if (autoClickInterval) {
            clearInterval(autoClickInterval);
            autoClickInterval = null;
        }
        autoClickStatus.style.display = 'none';
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
            treasureDisplay.textContent = data.treasure_remaining;
            
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
                        earnMoneyBtn.innerHTML = '<i class="fas fa-coins me-2"></i> OPEN TREASURE NOW';
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
            earnMoneyBtn.innerHTML = '<i class="fas fa-coins me-2"></i> EARN MONEY NOW';
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
    if (currentTreasure <= 0) {
        autoClickToggle.disabled = true;
    }
});
</script>

@endsection
