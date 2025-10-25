@extends('layouts.app')

@section('content')
<div class="login-wrapper min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="login-card">
                    <!-- Language Switcher -->
                    <div class="language-switcher mb-3 text-start" style="position: absolute; left: 1.5rem; top: 1.5rem; z-index: 3; font-size: 0.72rem;">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle shadow-sm" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: inherit; padding: 0.22rem 0.55rem;">
                                <i class="fas fa-globe me-2" style="font-size: 0.8em;"></i>
                                @if(app()->getLocale() == 'id')
                                    <span style="font-size: inherit;">{{ __('auth.indonesian') }}</span>
                                @else
                                    <span style="font-size: inherit;">{{ __('auth.english') }}</span>
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                <li>
                                    <a class="dropdown-item @if(app()->getLocale() == 'en') active @endif" 
                                       href="{{ route('language.switch', 'en') }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-flag-usa me-2" style="font-size: 0.8em;"></i>{{ __('auth.english') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item @if(app()->getLocale() == 'id') active @endif" 
                                       href="{{ route('language.switch', 'id') }}" style="font-size: 0.72rem;">
                                        <i class="fas fa-flag me-2" style="font-size: 0.8em;"></i>{{ __('auth.indonesian') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Game Logo/Header -->
                    <div class="text-center mb-4">
                        <div class="login-logo">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h2 class="login-title">Kazoku Game</h2>
                        <p class="login-subtitle">{{ __('auth.login_subtitle') }}</p>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" 
                                   class="form-control custom-input @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" 
                                   placeholder="{{ __('auth.email_address') }}"
                                   required autocomplete="email" autofocus>
                            <label for="email">
                                <i class="fas fa-envelope me-2"></i>{{ __('auth.email_address') }}
                            </label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-3">
                            <input id="password" type="password" 
                                   class="form-control custom-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="{{ __('auth.password_label') }}"
                                   required autocomplete="current-password">
                            <label for="password">
                                <i class="fas fa-lock me-2"></i>{{ __('auth.password_label') }}
                            </label>
                            <div class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-login btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                {{ __('auth.login') }}
                            </button>
                        </div>
                    </form>

                    <!-- Game Features Preview -->
                    <div class="features-preview">
                        <div class="row" style="margin-top: 10px;">
                            <div class="feature col-6">
                                <span>🏴‍☠️ {{ __('auth.treasure_hunt') }}</span>
                            </div>
                            <div class="feature col-6">
                                <span>⚡ {{ __('auth.level_experience') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>🛡️ {{ __('auth.pvp_combat') }}</span>
                            </div>
                            <div class="feature col-6">
                                <span>📦 {{ __('auth.inventory_system') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>👑 {{ __('auth.prestige_system') }}</span>
                            </div>
                            <div class="feature col-6">
                                <span>🎰 {{ __('auth.gambling_hall') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>☀️ {{ __('auth.time_strategy') }}</span>
                            </div>
                            <div class="feature col-6">
                                <span>🏪 {{ __('auth.upgrade_store') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.login-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #1a1a2e 75%, #16213e 100%);
    background-size: 400% 400%;
    animation: backgroundShift 20s ease-in-out infinite;
    position: relative;
    overflow: hidden;
}


.login-wrapper::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    pointer-events: none;
    z-index: 1;
    background-image:
        radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
        radial-gradient(1px 1px at 90px 40px, rgba(147,51,234,0.4), transparent),
        radial-gradient(1px 1px at 130px 80px, rgba(34,197,94,0.3), transparent),
        radial-gradient(2px 2px at 160px 30px, rgba(239,68,68,0.3), transparent);
    background-repeat: repeat;
    background-size: 200px 100px;
    opacity: 0.7;
    animation: starParallax 18s linear infinite;
}

@keyframes starParallax {
    0% { background-position: 0 0, 0 0, 0 0, 0 0, 0 0; }
    20% { background-position: 40px 20px, 80px 40px, 60px 30px, 100px 50px, 120px 60px; }
    40% { background-position: 80px 40px, 160px 80px, 120px 60px, 200px 100px, 240px 120px; }
    60% { background-position: 120px 60px, 240px 120px, 180px 90px, 300px 150px, 360px 180px; }
    80% { background-position: 160px 80px, 320px 160px, 240px 120px, 400px 200px, 480px 240px; }
    100% { background-position: 0 0, 0 0, 0 0, 0 0, 0 0; }
}

@keyframes backgroundShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 50%; }
    50% { background-position: 100% 100%; }
    75% { background-position: 0% 100%; }
}

@keyframes floatingStars {
    0% { transform: translateY(0px) translateX(0px); }
    25% { transform: translateY(-10px) translateX(5px); }
    50% { transform: translateY(0px) translateX(-5px); }
    75% { transform: translateY(5px) translateX(5px); }
    100% { transform: translateY(0px) translateX(0px); }
}

.rpg-glow {
    box-shadow: 0 0 30px 10px #3b82f6, 0 0 60px 20px #7c3aed;
    animation: glowPulse 2.5s infinite alternate;
}

@keyframes glowPulse {
    from { box-shadow: 0 0 30px 10px #3b82f6, 0 0 60px 20px #7c3aed; }
    to { box-shadow: 0 0 60px 20px #7c3aed, 0 0 30px 10px #3b82f6; }
}

.rpg-floating {
    animation: float 3s ease-in-out infinite;
}

.rpg-animated-logo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 0 40px 10px #7c3aed;
    position: relative;
    z-index: 2;
}

.rpg-animated-logo i {
    font-size: 2.5rem;
    color: #fff;
    filter: drop-shadow(0 0 10px #fff);
}

/* Add animated sparkles around logo */
.rpg-animated-logo::after {
    content: '';
    position: absolute;
    top: 10px; left: 10px; right: 10px; bottom: 10px;
    pointer-events: none;
    background: url('data:image/svg+xml;utf8,<svg width="80" height="80" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="2" fill="%23fff" opacity="0.5"/><circle cx="70" cy="20" r="1.5" fill="%23fff" opacity="0.3"/><circle cx="40" cy="70" r="1.2" fill="%23fff" opacity="0.4"/><circle cx="60" cy="60" r="1.8" fill="%23fff" opacity="0.3"/></svg>');
    background-size: cover;
    animation: sparkle 2.5s infinite alternate;
}

@keyframes sparkle {
    from { opacity: 0.7; }
    to { opacity: 1; }
}

.login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 1;
    animation: slideUp 0.8s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-logo {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.login-logo i {
    font-size: 2rem;
    color: white;
}

.login-title {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
}

.login-subtitle {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 0;
}

.custom-input {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1rem 1rem 3rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.custom-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.form-floating > label {
    padding-left: 3rem;
    color: #718096;
    font-weight: 500;
}

.form-floating > .custom-input:focus ~ label,
.form-floating > .custom-input:not(:placeholder-shown) ~ label {
    color: #667eea;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #718096;
    transition: color 0.3s ease;
    z-index: 5;
}

.password-toggle:hover {
    color: #667eea;
}

.btn-login {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 12px;
    padding: 1rem;
    font-weight: 600;
    font-size: 1.1rem;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.features-preview {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.70rem;
    font-weight: 500;
}

.feature i {
    color: #667eea;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .login-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }
    
    .login-title {
        font-size: 1.5rem;
    }
    
    .features-preview {
        grid-template-columns: 1fr;
    }
}

/* Language Switcher Styles */
.language-switcher {
    text-align: right;
}

.language-switcher .dropdown-toggle {
    background: white;
    border: 1px solid #dee2e6;
    color: #495057;
    font-size: 0.85rem;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.language-switcher .dropdown-toggle:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    transform: translateY(-1px);
}

.language-switcher .dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.language-switcher .dropdown-menu {
    border: none;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    padding: 0.5rem 0;
}

.language-switcher .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    transition: background-color 0.2s ease;
}

.language-switcher .dropdown-item:hover {
    background-color: #f8f9fa;
}

.language-switcher .dropdown-item.active {
    background-color: #667eea;
    color: white;
}

.language-switcher .dropdown-item.active:hover {
    background-color: #5a6fd8;
}

@media (max-width: 576px) {
    .language-switcher {
        text-align: center;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}

// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Add focus animations to inputs
    const inputs = document.querySelectorAll('.custom-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
