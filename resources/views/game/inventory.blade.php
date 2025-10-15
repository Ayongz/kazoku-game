@extends('layouts.app')

@section('content')
<div class="rpg-inventory-container">
    <!-- RPG Background Elements -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
    </div>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <!-- RPG Header -->
                <div class="rpg-header text-center mb-5">
                    <div class="store-title-container">
                        <h1 class="rpg-title">🎒 {{ __('nav.player_inventory') }}</h1>
                        <div class="title-decoration"></div>
                    </div>
                    <p class="text-light fs-5 mt-3">{{ __('nav.open_random_boxes_and_view_stats') }}</p>
                    <div class="rpg-wealth-display mb-0">
                        <div class="wealth-card" style="background: linear-gradient(135deg, rgba(106, 90, 205, 0.2) 0%, rgba(138, 43, 226, 0.1) 100%); border-color: #6A5ACD;">
                            <div class="wealth-icon" style="color: #6A5ACD;">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="wealth-content">
                                <h3 class="wealth-title" style="color: #6A5ACD;">{{ __('nav.random_box') }}</h3>
                                <h2 class="wealth-amount">{{ $randomBoxCount }}</h2>
                            </div>
                            <div class="wealth-decoration"></div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="rpg-inventory-grid">
                    <!-- Random Box Opening Area -->
                    <div class="rpg-main-panel">
                        <div class="rpg-panel">
                            <div class="rpg-panel-header">
                                <div class="ability-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="ability-info">
                                    <h4 class="ability-name">🎁 {{ __('nav.random_box_opening') }}</h4>
                                </div>
                            </div>
                            
                            <div class="rpg-panel-body text-center p-5">
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
                                    <button class="rpg-btn rpg-primary-btn px-5 pt-3" id="openBoxBtn" onclick="openRandomBox()">
                                        <span class="btn-text">
                                            <i class="fas fa-gift me-2"></i>
                                            {{ __('nav.open_random_box') }}
                                        </span>
                                    </button>
                                    
                                    <!-- Remaining Boxes -->
                                    <p class="text-light mt-3 mb-0 inventory-info">
                                        {!! __('nav.you_have_boxes', ['count' => $randomBoxCount]) !!}
                                    </p>
                                @else
                                    <!-- No Boxes State -->
                                    <div class="rpg-empty-state py-1">
                                        <div class="empty-state-icon mb-4">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <h4 class="text-light mb-3">{{ __('nav.no_random_boxes') }}</h4>
                                        <p class="text-light mb-4 opacity-75">
                                            {{ __('nav.no_boxes_message') }}<br>
                                            {{ __('nav.get_boxes_tip') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Panels -->
                    <div class="rpg-sidebar-panels">
                        <!-- Reward History -->
                        <div class="rpg-panel mb-4">
                            <div class="rpg-panel-header">
                                <div class="ability-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="ability-info">
                                    <h5 class="ability-name">🏆 {{ __('nav.recent_rewards') }}</h5>
                                </div>
                            </div>
                            <div class="rpg-panel-body" id="rewardHistory">
                                <p class="text-light text-center py-3 opacity-75">
                                    {{ __('nav.open_boxes_to_see_rewards') }}
                                </p>
                            </div>
                        </div>

                        <!-- Drop Rates Info -->
                        <div class="rpg-panel">
                            <div class="rpg-panel-header">
                                <div class="ability-icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="ability-info">
                                    <h5 class="ability-name">🎯 Drop Rates</h5>
                                </div>
                            </div>
                            <div class="rpg-panel-body">
                                <div class="drop-rate-item mb-3">
                                    <div class="drop-rate-header">
                                        <span class="drop-rate-name text-secondary">Common</span>
                                        <span class="drop-rate-badge bg-secondary">70%</span>
                                    </div>
                                    <small class="drop-rate-description">Money, Treasures, Experience</small>
                                </div>
                                <div class="drop-rate-item mb-3">
                                    <div class="drop-rate-header">
                                        <span class="drop-rate-name text-primary">Rare</span>
                                        <span class="drop-rate-badge bg-primary">25%</span>
                                    </div>
                                    <small class="drop-rate-description">Better rewards + Shield</small>
                                </div>
                                <div class="drop-rate-item mb-0">
                                    <div class="drop-rate-header">
                                        <span class="drop-rate-name text-warning">Legendary</span>
                                        <span class="drop-rate-badge bg-warning text-dark">5%</span>
                                    </div>
                                    <small class="drop-rate-description">Jackpot + Bonus boxes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reward Display Modal -->
<div class="modal fade" id="rewardModal" tabindex="-1" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rpg-modal">
            <div class="modal-header border-0 text-center rpg-modal-header">
                <h4 class="modal-title w-100 text-light" id="rewardModalLabel">🎉 Random Box Opened!</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 rpg-modal-body">
                <div id="rewardTierDisplay" class="mb-4">
                    <!-- Tier display will be populated by JavaScript -->
                </div>
                <div id="rewardItemsDisplay" class="row g-3">
                    <!-- Reward items will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center rpg-modal-footer">
                <button type="button" class="rpg-btn rpg-primary-btn" data-bs-dismiss="modal">
                    <span class="btn-text">Awesome!</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== RPG INVENTORY INTERFACE STYLES ===== */

/* Background & Container */
.rpg-inventory-container {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
    overflow-x: hidden;
}

.rpg-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
}

/* Animated Particles */
.floating-particles::before,
.floating-particles::after {
    content: '';
    position: absolute;
    width: 4px;
    height: 4px;
    background: #ffd700;
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
    box-shadow: 0 0 10px #ffd700;
}

.floating-particles::before {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-particles::after {
    top: 60%;
    right: 15%;
    animation-delay: 3s;
}

.magic-orbs::before,
.magic-orbs::after {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    background: radial-gradient(circle, #00d4ff 0%, #0099cc 100%);
    border-radius: 50%;
    animation: orbit 8s linear infinite;
    box-shadow: 0 0 15px #00d4ff;
}

.magic-orbs::before {
    top: 30%;
    right: 10%;
}

.magic-orbs::after {
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

@keyframes orbit {
    0% { transform: rotate(0deg) translateX(50px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(50px) rotate(-360deg); }
}

/* Header Styles */
.rpg-header {
    position: relative;
    margin-bottom: 2rem;
}

.store-title-container {
    position: relative;
    display: inline-block;
}

.rpg-title {
    font-size: 2.5rem;
    color: #ffd700;
    text-shadow: 
        0 0 10px #ffd700,
        0 0 20px #ffd700,
        0 0 30px #ffd700;
    font-family: 'Cinzel', serif;
    font-weight: bold;
    margin: 0;
    position: relative;
    z-index: 2;
}

.title-decoration {
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 4px;
    background: linear-gradient(90deg, transparent 0%, #ffd700 50%, transparent 100%);
    box-shadow: 0 0 10px #ffd700;
}

/* Wealth Display */
.rpg-wealth-display {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.wealth-card {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 215, 0, 0.05) 100%);
    border: 2px solid #ffd700;
    border-radius: 20px;
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    position: relative;
    backdrop-filter: blur(10px);
    box-shadow: 
        0 0 30px rgba(255, 215, 0, 0.3),
        inset 0 0 30px rgba(255, 215, 0, 0.1);
    animation: goldGlow 3s ease-in-out infinite alternate;
}

.wealth-icon {
    font-size: 2.5rem;
    color: #ffd700;
    margin-right: 1.5rem;
    animation: coinSpin 4s linear infinite;
}

.wealth-content {
    text-align: left;
}

.wealth-title {
    color: #ffd700;
    font-size: 1.2rem;
    margin: 0 0 0.5rem 0;
    font-weight: 600;
}

.wealth-amount {
    color: #fff;
    font-size: 2rem;
    margin: 0;
    font-weight: bold;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

.wealth-decoration {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 20px;
    height: 20px;
    background: radial-gradient(circle, #ffd700 0%, transparent 70%);
    border-radius: 50%;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes goldGlow {
    0% { box-shadow: 0 0 30px rgba(255, 215, 0, 0.3), inset 0 0 30px rgba(255, 215, 0, 0.1); }
    100% { box-shadow: 0 0 50px rgba(255, 215, 0, 0.5), inset 0 0 50px rgba(255, 215, 0, 0.2); }
}

@keyframes coinSpin {
    0% { transform: rotateY(0deg); }
    100% { transform: rotateY(360deg); }
}

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0); }
    50% { opacity: 1; transform: scale(1); }
}

/* Inventory Grid Layout */
.rpg-inventory-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 3rem;
}

/* Panel Styles */
.rpg-panel {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 2px solid #6A5ACD;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    backdrop-filter: blur(15px);
    box-shadow: 0 0 20px rgba(106, 90, 205, 0.4);
}

.rpg-panel-header {
    padding: 1rem;
    background: linear-gradient(135deg, #6A5ACD 0%, rgba(0, 0, 0, 0.2) 100%);
    display: flex;
    align-items: center;
    position: relative;
}

.ability-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 1rem;
    position: relative;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.ability-icon::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: #6A5ACD;
    z-index: -1;
    animation: iconPulse 3s ease-in-out infinite;
}

.ability-info {
    flex: 1;
}

.ability-name {
    color: white;
    font-size: 1.1rem;
    font-weight: bold;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

@keyframes iconPulse {
    0%, 100% { box-shadow: 0 0 10px #6A5ACD; }
    50% { box-shadow: 0 0 20px #6A5ACD, 0 0 30px rgba(106, 90, 205, 0.4); }
}

.rpg-panel-body {
    padding: 1.5rem;
    color: white;
}

/* Buttons */
.rpg-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.rpg-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    transition: left 0.5s ease;
}

.rpg-btn:hover::before {
    left: 100%;
}

.rpg-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    color: white;
    text-decoration: none;
}

.rpg-btn:active {
    transform: translateY(0px);
}

.btn-text {
    position: relative;
    z-index: 2;
}

.rpg-primary-btn {
    background: linear-gradient(135deg, #6A5ACD 0%, #9370DB 100%);
}

.rpg-secondary-btn {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

.rpg-success-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

/* Empty State */
.rpg-empty-state {
    text-align: center;
}

.empty-state-icon {
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.3);
    margin-bottom: 1rem;
}

.rpg-action-buttons {
    margin-top: 2rem;
}

/* Drop Rate Items */
.drop-rate-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem;
    border-radius: 10px;
    border-left: 4px solid #6A5ACD;
}

.drop-rate-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 0.25rem;
}

.drop-rate-name {
    font-weight: bold;
    flex: 1;
}

.drop-rate-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
}

.drop-rate-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.8rem;
}

/* Inventory Info */
.inventory-info {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}

/* Modal Styles */
.rpg-modal .modal-content {
    background: linear-gradient(145deg, rgba(30, 30, 60, 0.95) 0%, rgba(20, 20, 40, 0.95) 100%);
    border: 2px solid #6A5ACD;
    border-radius: 20px;
    backdrop-filter: blur(15px);
}

.rpg-modal-header {
    background: linear-gradient(135deg, #6A5ACD 0%, rgba(0, 0, 0, 0.2) 100%);
}

.rpg-modal-body {
    color: white;
}

.rpg-modal-footer {
    background: rgba(255, 255, 255, 0.05);
}

/* Mobile Responsive */
@media (max-width: 992px) {
    .rpg-inventory-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .rpg-sidebar-panels {
        order: -1;
    }
}

@media (max-width: 768px) {
    .rpg-title {
        font-size: 2rem;
    }
    
    .title-decoration {
        width: 150px;
    }
    
    .wealth-card {
        padding: 1rem;
        flex-direction: column;
        text-align: center;
    }
    
    .wealth-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }
    
    .wealth-amount {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .rpg-title {
        font-size: 1.5rem;
    }
    
    .wealth-amount {
        font-size: 1.25rem;
    }
    
    .rpg-panel-body {
        padding: 1rem;
    }
}

/* Random Box 3D Animation - Enhanced */
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
    animation: boxFloat 3s ease-in-out infinite;
    cursor: pointer;
    transition: transform 0.3s ease;
    filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.5));
}

.treasure-box-3d:hover {
    transform: rotateY(15deg) rotateX(15deg) scale(1.1);
    filter: drop-shadow(0 0 30px rgba(255, 215, 0, 0.8));
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
    box-shadow: 
        inset 0 0 20px rgba(0,0,0,0.1),
        0 0 20px rgba(255, 215, 0, 0.3);
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
}

.box-front { transform: translateZ(60px); }
.box-back { transform: translateZ(-60px) rotateY(180deg); }
.box-left { transform: rotateY(-90deg) translateZ(60px); }
.box-right { transform: rotateY(90deg) translateZ(60px); }
.box-top { transform: rotateX(90deg) translateZ(60px); }
.box-bottom { transform: rotateX(-90deg) translateZ(60px); }

@keyframes boxFloat {
    0%, 100% { 
        transform: translateY(0px) rotateY(0deg);
        filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.5));
    }
    50% { 
        transform: translateY(-20px) rotateY(180deg);
        filter: drop-shadow(0 0 30px rgba(255, 215, 0, 0.8));
    }
}

@keyframes openBox {
    0% { 
        transform: rotateY(0deg) rotateX(0deg);
        filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.5));
    }
    25% { 
        transform: rotateY(90deg) rotateX(45deg) scale(1.2);
        filter: drop-shadow(0 0 40px rgba(255, 215, 0, 1));
    }
    50% { 
        transform: rotateY(180deg) rotateX(90deg) scale(1.5);
        filter: drop-shadow(0 0 60px rgba(255, 215, 0, 1));
    }
    75% { 
        transform: rotateY(270deg) rotateX(135deg) scale(1.2);
        filter: drop-shadow(0 0 40px rgba(255, 215, 0, 0.8));
    }
    100% { 
        transform: rotateY(360deg) rotateX(180deg) scale(0.8); 
        opacity: 0.8;
        filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3));
    }
}

/* Loading Button Enhancement */
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

/* Reward Animation Enhancement */
.reward-item {
    animation: rewardSlideIn 0.5s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

.reward-item .card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 2px solid rgba(106, 90, 205, 0.5);
    backdrop-filter: blur(10px);
    color: white;
}

@keyframes rewardSlideIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* History Item Enhancement */
.history-item {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(106, 90, 205, 0.3);
    border-radius: 10px;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    animation: historySlideIn 0.3s ease-out;
}

@keyframes historySlideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
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
    
    if (historyContainer.children.length === 1 && historyContainer.children[0].textContent.includes('Open')) {
        historyContainer.innerHTML = '';
    }
    
    const historyItem = document.createElement('div');
    historyItem.className = 'history-item';
    historyItem.innerHTML = `
        <small class="text-light opacity-75">${new Date().toLocaleTimeString()}</small>
        <div class="${reward.tier_class} fw-bold">${reward.tier} Box</div>
        <div class="small text-light opacity-75">
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