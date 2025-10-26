<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kazoku') }}</title>
    <!-- Bootstrap 5 CSS (Local) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons (Local) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background: linear-gradient(135deg, #e0f2ff 0%, #b6e0fe 100%);">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/site/logo.png') }}" style="height:24px;object-fit:contain;" />
                </a>
                <button class="navbar-toggler" style="border:none;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('nav.toggle_navigation') }}">
                    <span class="navbar-toggler-icon custom-treasure-icon">
                        <svg width="40" height="40" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect x="4" y="12" width="20" height="10" rx="3" fill="#fbbf24" stroke="#7c4700" stroke-width="2"/>
                          <rect x="4" y="7" width="20" height="7" rx="3" fill="#e2a700" stroke="#7c4700" stroke-width="2"/>
                          <path d="M4 12 Q14 2 24 12" fill="#ffe066" stroke="#bfa100" stroke-width="2"/>
                          <rect x="10" y="17" width="8" height="4" rx="1.5" fill="#fffbe6" stroke="#7c4700" stroke-width="1.5"/>
                          <rect x="13" y="19" width="2" height="2" rx="1" fill="#e2a700" stroke="#7c4700" stroke-width="1"/>
                          <rect x="7" y="14" width="14" height="2" rx="1" fill="#fffbe6" stroke="#7c4700" stroke-width="1"/>
                          <circle cx="14" cy="13" r="2.5" fill="#ffd700" stroke="#bfa100" stroke-width="1.2"/>
                          <ellipse cx="14" cy="16" rx="7.5" ry="3" fill="#ffe066" stroke="#bfa100" stroke-width="1.2"/>
                          <path d="M6 12 Q14 4 22 12" stroke="#7c4700" stroke-width="1.2" fill="none"/>
                          <path d="M11 8 Q14 3 17 8" stroke="#bfa100" stroke-width="1.2" fill="none"/>
                          <circle cx="14" cy="21" r="1.2" fill="#ffd700" stroke="#bfa100" stroke-width="0.8"/>
                          <path d="M14 21 v-2" stroke="#bfa100" stroke-width="0.8"/>
                          <circle cx="8" cy="10" r="0.7" fill="#fff" opacity="0.8"/>
                          <circle cx="20" cy="10" r="0.5" fill="#fff" opacity="0.7"/>
                          <circle cx="12" cy="7" r="0.4" fill="#fff" opacity="0.6"/>
                        </svg>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('game.dashboard') }}">
                                <i class="fas fa-gamepad me-1"></i>{{ __('nav.game') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('store.index') }}">
                                <i class="fas fa-store me-1"></i>{{ __('nav.store') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('game.inventory') }}">
                                <i class="fas fa-box me-1"></i>{{ __('nav.inventory') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('topup.index') }}">
                                <i class="fas fa-coins me-1"></i>Top Up
                            </a>
                        </li>
                        @if(Auth::user() && Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('topup.admin') }}">
                                <i class="fas fa-user-shield me-1"></i>Top Up Admin
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('game.status') }}">
                                <i class="fas fa-chart-line me-1"></i>{{ __('nav.status') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('game.class-path') }}">
                                <i class="fas fa-tree me-1"></i>{{ __('nav.class_path') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gambling.hall') }}">
                                <i class="fas fa-dice me-1"></i>{{ __('nav.gambling_hall') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('game.guide') }}">
                                <i class="fas fa-book me-1"></i>{{ __('nav.guide') }}
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a>
                                
                                <!-- Language Switcher in User Menu -->
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">
                                    <i class="fas fa-globe me-2"></i>Language
                                </h6>
                                <a class="dropdown-item @if(app()->getLocale() == 'en') active @endif" 
                                   href="{{ route('language.switch', 'en') }}">
                                    <i class="fas fa-flag-usa me-2"></i>{{ __('auth.english') }}
                                </a>
                                <a class="dropdown-item @if(app()->getLocale() == 'id') active @endif" 
                                   href="{{ route('language.switch', 'id') }}">
                                    <i class="fas fa-flag me-2"></i>{{ __('auth.indonesian') }}
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   id="rpg-logout-btn">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('nav.logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @endauth

        @auth
        <main>
            @yield('content')
        </main>
        @else
        <main>
            @yield('content')
        </main>
        @endauth
    </div>

    <!-- RPG Logout Overlay -->
    <div id="rpg-logout-overlay" style="display:none;position:fixed;inset:0;z-index:99999;background:radial-gradient(circle at center, #0a0f1c 0%, #1a1a2e 100%);">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
            <div class="rpg-logout-animation" style="animation:rpgLogoutAnim 1.2s ease-in-out forwards;">
                <i class="fas fa-dragon" style="font-size:4rem;color:#fbbf24;text-shadow:0 0 30px #fbbf24,0 0 60px #7c3aed;"></i>
                <h2 style="color:#fff;font-family:'Cinzel',serif;font-weight:700;margin-top:1rem;text-shadow:0 0 10px #3b82f6;">{{ __('nav.farewell_adventurer') }}</h2>
                <p style="color:#fbbf24;font-size:1.2rem;">{{ __('nav.your_journey_continues') }}</p>
            </div>
        </div>
    </div>

    <style>
    .custom-treasure-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: none !important;
        background: none !important;
        padding: 0 !important;
    }
    @keyframes rpgLogoutAnim {
        0% { opacity: 0; transform: scale(0.7); }
        60% { opacity: 1; transform: scale(1.1); }
        100% { opacity: 1; transform: scale(1); }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var logoutBtn = document.getElementById('rpg-logout-btn');
        var overlay = document.getElementById('rpg-logout-overlay');
        if (logoutBtn && overlay) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                overlay.style.display = 'block';
                setTimeout(function() {
                    document.getElementById('logout-form').submit();
                }, 1600); // Show animation for 1.6s before logout
            });
        }
    });
    </script>
    <!-- Bootstrap 5 JavaScript Bundle (Local, includes Popper) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
