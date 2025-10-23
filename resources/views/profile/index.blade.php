@extends('layouts.app')

@section('content')
<div class="rpg-profile-container">
    <!-- RPG Background Elements -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
    </div>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                
                <!-- Header -->
                <div class="rpg-header text-center mb-5">
                    <div class="store-title-container">
                        <h1 class="rpg-title"><i class="fas fa-user-circle me-2"></i>{{ __('nav.profile_settings') }}</h1>
                        <div class="title-decoration"></div>
                    </div>
                    <p class="text-light fs-5 mt-3">{{ __('nav.customize_your_avatar') }}</p>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="rpg-alert rpg-alert-success mb-4 alert alert-dismissible" role="alert">
                        <div class="alert-icon">⚔️</div>
                        <div class="alert-content">
                            <div class="alert-title">{{ __('nav.success') }}!</div>
                            <div class="alert-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="rpg-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rpg-alert rpg-alert-danger mb-4 alert alert-dismissible" role="alert">
                        <div class="alert-icon">🔥</div>
                        <div class="alert-content">
                            <div class="alert-title">{{ __('nav.error') }}!</div>
                            <div class="alert-message">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="rpg-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                <!-- Current Profile Display -->
                <div class="rpg-wealth-display mb-4">
                    <div class="wealth-card" style="background: linear-gradient(135deg, rgba(106, 90, 205, 0.2) 0%, rgba(138, 43, 226, 0.1) 100%); border-color: #6A5ACD;">
                        <div class="current-avatar-display">
                            <img src="{{ \App\Http\Controllers\ProfileController::getProfilePictureUrl($user) }}" 
                                 alt="Current Avatar" class="current-avatar-img">
                        </div>
                        <div class="wealth-content">
                            <h3 class="wealth-title" style="color: #6A5ACD;">{{ __('nav.current_avatar') }}</h3>
                            <h2 class="wealth-amount">{{ $user->name }}</h2>
                        </div>
                        <div class="wealth-decoration"></div>
                    </div>
                </div>

                <!-- Profile Picture Selection -->
                <div class="rpg-panel">
                    <div class="rpg-panel-header">
                        <div class="ability-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="ability-info">
                            <h3 class="ability-name">{{ __('nav.choose_your_avatar') }}</h3>
                        </div>
                    </div>
                    <div class="rpg-panel-body">
                        <form method="POST" action="{{ route('profile.update-picture') }}" id="profileForm">
                            @csrf
                            
                            <!-- Avatar Grid -->
                            <div class="avatar-grid mb-4">
                                <!-- Default Avatar -->
                                <div class="avatar-option {{ !$user->profile_picture ? 'selected' : '' }}" 
                                     data-value="default">
                                    <img src="/images/profile/default.png" 
                                         alt="{{ __('nav.default') }} Avatar" class="avatar-img">
                                    <div class="avatar-label">{{ __('nav.default') }}</div>
                                    @if(!$user->profile_picture)
                                        <div class="selection-indicator">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Available Profile Pictures -->
                                @foreach($availableProfiles as $profile)
                                    <div class="avatar-option {{ $user->profile_picture === $profile['filename'] ? 'selected' : '' }}" 
                                         data-value="{{ $profile['filename'] }}">
                                        <img src="{{ $profile['path'] }}" 
                                             alt="{{ __('nav.avatar_number', ['number' => $profile['id']]) }}" class="avatar-img">
                                        <div class="avatar-label">{{ __('nav.avatar_number', ['number' => $profile['id']]) }}</div>
                                        @if($user->profile_picture === $profile['filename'])
                                            <div class="selection-indicator">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" name="profile_picture" id="selectedAvatar" value="{{ $user->profile_picture ?? 'default' }}">
                            
                            <div class="text-center">
                                <button type="submit" class="rpg-btn rpg-primary-btn px-5 py-3">
                                    <span class="btn-text">
                                        <i class="fas fa-save me-2"></i>
                                        {{ __('nav.save_changes') }}
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="rpg-back-area">
                    <a href="{{ route('game.dashboard') }}" class="rpg-back-btn">
                        <i class="fas fa-arrow-left"></i> &nbsp; {{ __('nav.back_to_dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== RPG PROFILE INTERFACE STYLES ===== */

/* Background & Container */
.rpg-profile-container {
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

/* Alert Styles */
.rpg-alert {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 15px;
    border: 2px solid;
    position: relative;
    backdrop-filter: blur(10px);
    animation: slideInFromTop 0.5s ease-out;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.rpg-alert-success {
    background: rgba(46, 204, 113, 0.2);
    border-color: #2ecc71;
    color: #27ae60;
}

.rpg-alert-danger {
    background: rgba(231, 76, 60, 0.2);
    border-color: #e74c3c;
    color: #c0392b;
}

.alert-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
    animation: pulse 2s infinite;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.alert-message {
    font-size: 0.9rem;
    opacity: 0.9;
}

.rpg-close {
    background: none;
    border: none;
    color: inherit;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    margin-left: 1rem;
    transition: all 0.3s ease;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.rpg-close:hover {
    transform: scale(1.2);
    color: #ff6b6b;
    background: rgba(255, 107, 107, 0.1);
}

/* Wealth Display for Current Avatar */
.rpg-wealth-display {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.wealth-card {
    background: linear-gradient(135degrees, rgba(255, 215, 0, 0.1) 0%, rgba(255, 215, 0, 0.05) 100%);
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

.current-avatar-display {
    margin-right: 1.5rem;
}

.current-avatar-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ffd700;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
}

.wealth-content {
    text-align: center;
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

@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0); }
    50% { opacity: 1; transform: scale(1); }
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

/* Avatar Grid */
.avatar-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.avatar-option {
    position: relative;
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    border: 2px solid rgba(106, 90, 205, 0.3);
    border-radius: 15px;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.avatar-option:hover {
    transform: translateY(-5px);
    border-color: #6A5ACD;
    box-shadow: 0 10px 30px rgba(106, 90, 205, 0.4);
}

.avatar-option.selected {
    border-color: #ffd700;
    background: linear-gradient(145deg, rgba(255, 215, 0, 0.2) 0%, rgba(255, 215, 0, 0.1) 100%);
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
}

.avatar-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 0.5rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.avatar-option:hover .avatar-img {
    border-color: #6A5ACD;
    transform: scale(1.1);
}

.avatar-option.selected .avatar-img {
    border-color: #ffd700;
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
}

.avatar-label {
    color: white;
    font-size: 0.9rem;
    font-weight: 600;
}

.selection-indicator {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #ffd700 0%, #ff8c00 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.7);
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

/* Back Button */
.rpg-back-area {
    text-align: center;
    margin-top: 3rem;
    padding-bottom: 2rem;
}

.rpg-back-btn {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: bold;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    position: relative;
    overflow: hidden;
}

.rpg-back-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
    transition: left 0.5s ease;
}

.rpg-back-btn:hover::before {
    left: 100%;
}

.rpg-back-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
    color: white;
    text-decoration: none;
}

/* Animations */
@keyframes slideInFromTop {
    0% {
        opacity: 0;
        transform: translateY(-50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Mobile Responsive */
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
    
    .current-avatar-display {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
    
    .current-avatar-img {
        width: 60px;
        height: 60px;
    }
    
    .wealth-amount {
        font-size: 1.5rem;
    }
    
    .avatar-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
    }
    
    .avatar-img {
        width: 60px;
        height: 60px;
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
    
    .avatar-grid {
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }
    
    .avatar-img {
        width: 50px;
        height: 50px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarOptions = document.querySelectorAll('.avatar-option');
    const selectedInput = document.getElementById('selectedAvatar');
    
    avatarOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            avatarOptions.forEach(opt => {
                opt.classList.remove('selected');
                const indicator = opt.querySelector('.selection-indicator');
                if (indicator) {
                    indicator.remove();
                }
            });
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Add selection indicator
            const indicator = document.createElement('div');
            indicator.className = 'selection-indicator';
            indicator.innerHTML = '<i class="fas fa-check"></i>';
            this.appendChild(indicator);
            
            // Update hidden input
            selectedInput.value = this.dataset.value;
        });
    });
    
    // Handle alert close buttons
    const closeButtons = document.querySelectorAll('.rpg-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const alert = this.closest('.rpg-alert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            }
        });
    });
});
</script>
@endsection