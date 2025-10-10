@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    🎒 {{ __('nav.player_inventory') }}
                </h1>
                <p class="text-muted fs-5">{{ __('nav.open_random_boxes_and_view_stats') }}</p>
                <div class="badge bg-info fs-6 px-3 py-2">
                    🎁 {{ $randomBoxCount }} {{ __('nav.random_box') }}
                </div>
            </div>

            <!-- Random Box Opening Area -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Random Box Opening Area -->
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-gradient text-white text-center">
                            <h4 class="mb-0" style="color: black;">🎁 {{ __('nav.random_box_opening') }}</h4>
                        </div>
                                <div class="card-body text-center p-5">
                                    @if($randomBoxCount > 0)
                                        <!-- Box Animation Area -->
                                        <div class="box-animation-area mb-4" id="boxAnimationArea">
                                            <div class="treasure-box-container" id="treasureBoxContainer">
                                                <div class="treasure-box-3d" id="animatedBox">
                                                    <div class="box-face box-front">🎁</div>
                                                    <div class="box-face box-back">🎁</div>
                                                    <div class="box-face box-left">🎁</div>
                                                    <div class="box-face box-right">🎁</div>
                                                    <div class="box-face box-top">🎁</div>
                                                    <div class="box-face box-bottom">🎁</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <button class="btn btn-lg btn-primary px-5 py-3" id="openBoxBtn" onclick="openRandomBox()">
                                            <i class="fas fa-gift me-2"></i>
                                            {{ __('nav.open_random_box') }}
                                        </button>
                                        
                                        <!-- Remaining Boxes -->
                                        <p class="text-muted mt-3 mb-0">
                                            {!! __('nav.you_have_boxes', ['count' => $randomBoxCount]) !!}
                                        </p>
                                    @else
                                        <!-- No Boxes State -->
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="fas fa-box-open fa-5x text-muted"></i>
                                            </div>
                                            <h4 class="text-muted mb-3">{{ __('nav.no_random_boxes') }}</h4>
                                            <p class="text-muted mb-4">
                                                {{ __('nav.no_boxes_message') }}<br>
                                                {{ __('nav.get_boxes_tip') }}
                                            </p>
                                            <a href="{{ route('game.dashboard') }}" class="btn btn-primary">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                {{ __('nav.back_to_dashboard') }}
                                            </a>
                                            <a href="{{ route('store.index') }}" class="btn btn-outline-primary ms-2">
                                                <i class="fas fa-store me-2"></i>
                                                {{ __('nav.visit_store') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Reward History -->
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">🏆 {{ __('nav.recent_rewards') }}</h5>
                                </div>
                                <div class="card-body" id="rewardHistory">
                                    <p class="text-muted text-center py-3">
                                        {{ __('nav.open_boxes_to_see_rewards') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Reward Chances Info -->
                            <div class="card shadow-sm border-0 mt-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">🎯 Drop Rates</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-secondary">Common</span>
                                            <span class="badge bg-secondary">70%</span>
                                        </div>
                                        <small class="text-muted">Money, Treasures, Experience</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary">Rare</span>
                                            <span class="badge bg-primary">25%</span>
                                        </div>
                                        <small class="text-muted">Better rewards + Shield</small>
                                    </div>
                                    <div class="mb-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-warning">Legendary</span>
                                            <span class="badge bg-warning text-dark">5%</span>
                                        </div>
                                        <small class="text-muted">Jackpot + Bonus boxes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="text-center mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('game.dashboard') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('game.status') }}" class="btn btn-primary w-100">
                            <i class="fas fa-chart-line me-2"></i>
                            View Status
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('store.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-store me-2"></i>
                            Visit Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reward Display Modal -->
<div class="modal fade" id="rewardModal" tabindex="-1" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 text-center">
                <h4 class="modal-title w-100" id="rewardModalLabel">🎉 Random Box Opened!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div id="rewardTierDisplay" class="mb-4">
                    <!-- Tier display will be populated by JavaScript -->
                </div>
                <div id="rewardItemsDisplay" class="row g-3">
                    <!-- Reward items will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Awesome!</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Random Box 3D Animation */
.treasure-box-container {
    perspective: 1000px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.treasure-box-3d {
    position: relative;
    width: 120px;
    height: 120px;
    transform-style: preserve-3d;
    animation: float 3s ease-in-out infinite;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.treasure-box-3d:hover {
    transform: rotateY(15deg) rotateX(15deg) scale(1.1);
}

.treasure-box-3d.opening {
    animation: openBox 2s ease-in-out forwards;
}

.box-face {
    position: absolute;
    width: 120px;
    height: 120px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    border: 3px solid #b8860b;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 3rem;
    box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
}

.box-front { transform: translateZ(60px); }
.box-back { transform: translateZ(-60px) rotateY(180deg); }
.box-left { transform: rotateY(-90deg) translateZ(60px); }
.box-right { transform: rotateY(90deg) translateZ(60px); }
.box-top { transform: rotateX(90deg) translateZ(60px); }
.box-bottom { transform: rotateX(-90deg) translateZ(60px); }

@keyframes float {
    0%, 100% { transform: translateY(0px) rotateY(0deg); }
    50% { transform: translateY(-20px) rotateY(180deg); }
}

@keyframes openBox {
    0% { transform: rotateY(0deg) rotateX(0deg); }
    25% { transform: rotateY(90deg) rotateX(45deg) scale(1.2); }
    50% { transform: rotateY(180deg) rotateX(90deg) scale(1.5); }
    75% { transform: rotateY(270deg) rotateX(135deg) scale(1.2); }
    100% { transform: rotateY(360deg) rotateX(180deg) scale(0.8); opacity: 0.8; }
}

/* Gradient Background */
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Tab Pills Styling */
.nav-pills .nav-link {
    border-radius: 50px;
    margin: 0 5px;
    font-weight: 600;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Reward Animation */
.reward-item {
    animation: slideIn 0.5s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading Button */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
let isOpening = false;

function openRandomBox() {
    if (isOpening) return;
    
    const btn = document.getElementById('openBoxBtn');
    const box = document.getElementById('animatedBox');
    
    // Start loading state
    isOpening = true;
    btn.classList.add('btn-loading');
    btn.disabled = true;
    
    // Start box opening animation
    box.classList.add('opening');
    
    // Make API call
    fetch('/game/inventory/open-random-box', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        setTimeout(() => {
            if (data.success) {
                showRewards(data.reward);
                updateBoxCount(data.remaining_boxes);
                addToRewardHistory(data.reward);
            } else {
                alert(data.message);
            }
            
            // Reset states
            resetBoxAnimation();
            resetButton();
        }, 2000); // Wait for animation
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while opening the box: ' + error.message);
        resetBoxAnimation();
        resetButton();
    });
}

function showRewards(reward) {
    const tierDisplay = document.getElementById('rewardTierDisplay');
    const itemsDisplay = document.getElementById('rewardItemsDisplay');
    
    // Show tier
    tierDisplay.innerHTML = `
        <h3 class="${reward.tier_class} mb-3">
            ${reward.tier} Tier!
        </h3>
    `;
    
    // Show reward items
    itemsDisplay.innerHTML = '';
    reward.rewards.forEach((item, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-6 reward-item';
        col.style.animationDelay = `${index * 0.2}s`;
        
        col.innerHTML = `
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="display-4 mb-2">${item.icon}</div>
                    <h5 class="card-title">${item.display}</h5>
                </div>
            </div>
        `;
        
        itemsDisplay.appendChild(col);
    });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('rewardModal'));
    modal.show();
}

function updateBoxCount(remaining) {
    const remainingElement = document.getElementById('remainingBoxes');
    
    if (remainingElement) {
        remainingElement.textContent = remaining;
    }
    
    // If no boxes left, reload page to show empty state
    if (remaining === 0) {
        setTimeout(() => {
            location.reload();
        }, 3000);
    }
}

function addToRewardHistory(reward) {
    const historyContainer = document.getElementById('rewardHistory');
    
    if (historyContainer.children.length === 1 && historyContainer.children[0].textContent.includes('Open random boxes')) {
        historyContainer.innerHTML = '';
    }
    
    const historyItem = document.createElement('div');
    historyItem.className = 'border-bottom pb-2 mb-2';
    historyItem.innerHTML = `
        <small class="text-muted">${new Date().toLocaleTimeString()}</small>
        <div class="${reward.tier_class} fw-bold">${reward.tier} Box</div>
        <div class="small">
            ${reward.rewards.map(item => `${item.icon} ${item.display}`).join(', ')}
        </div>
    `;
    
    historyContainer.insertBefore(historyItem, historyContainer.firstChild);
    
    // Keep only last 5 items
    while (historyContainer.children.length > 5) {
        historyContainer.removeChild(historyContainer.lastChild);
    }
}

function resetBoxAnimation() {
    const box = document.getElementById('animatedBox');
    box.classList.remove('opening');
}

function resetButton() {
    const btn = document.getElementById('openBoxBtn');
    btn.classList.remove('btn-loading');
    btn.disabled = false;
    isOpening = false;
}
</script>
@endsection