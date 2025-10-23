@extends('layouts.app')

@section('content')
<div class="login-wrapper min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="login-card">
                    <!-- Language Switcher -->
                    <div class="language-switcher mb-3">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle shadow-sm" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe me-2"></i>
                                @if(app()->getLocale() == 'id')
                                    {{ __('auth.indonesian') }}
                                @else
                                    {{ __('auth.english') }}
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                <li>
                                    <a class="dropdown-item @if(app()->getLocale() == 'en') active @endif" 
                                       href="{{ route('language.switch', 'en') }}">
                                        <i class="fas fa-flag-usa me-2"></i>{{ __('auth.english') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item @if(app()->getLocale() == 'id') active @endif" 
                                       href="{{ route('language.switch', 'id') }}">
                                        <i class="fas fa-flag me-2"></i>{{ __('auth.indonesian') }}
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
                        <div class="row">
                            <div class="feature col-6">
                                <span>🏴‍☠️ Treasure Hunt</span>
                            </div>
                            <div class="feature col-6">
                                <span>⚡ Level & Experience</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>🛡️ PvP Combat</span>
                            </div>
                            <div class="feature col-6">
                                <span>📦 Inventory System</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>👑 Prestige System</span>
                            </div>
                            <div class="feature col-6">
                                <span>🎰 Gambling Hall</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="feature col-6">
                                <span>☀️ Time Strategy</span>
                            </div>
                            <div class="feature col-6">
                                <span>🏪 Upgrade Store</span>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.login-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="50" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="30" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.6;
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
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
