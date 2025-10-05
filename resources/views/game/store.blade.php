@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-5">
                <i class="fas fa-store me-3 text-primary"></i>Game Store
            </h1>

            <!-- Status Messages -->
            @if (session('success'))
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

            <!-- Player Money Card -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card shadow-lg border-start border-5 border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success mb-2">
                                <i class="fas fa-wallet me-2"></i>Your Money
                            </h3>
                            <h2 class="display-5 fw-bold text-dark">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Items -->
            <div class="row g-5">
                
                <!-- 1. STEAL ABILITY UPGRADE -->
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-danger text-white text-center py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-mask me-2"></i>Steal Ability
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                        Level {{ $user->steal_level }} / {{ $maxStealLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->steal_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Success Rate: {{ min($user->steal_level * 20, 80) }}%</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Steal Amount: {{ $user->steal_level }}x multiplier</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Can attempt heists</li>
                                    </ul>
                                @else
                                    <p class="text-muted">
                                        Unlock the ability to steal money from other players and the global prize pool!
                                    </p>
                                @endif
                            </div>

                            @if ($user->steal_level < $maxStealLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-danger mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Success Rate: {{ min(($user->steal_level + 1) * 20, 80) }}%</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Steal Amount: {{ $user->steal_level + 1 }}x multiplier</li>
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.steal') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger btn-lg w-100 fw-bold @if($user->money_earned < $stealUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $stealUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($stealUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-5 py-3 px-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL REACHED
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 2. AUTO EARNING ABILITY UPGRADE -->
                <div class="col-12 col-md-6">
                    <div class="card h-100 shadow-lg border-0">
                        <div class="card-header bg-warning text-dark text-center py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-robot me-2"></i>Auto Earning
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        Level {{ $user->auto_earning_level }} / {{ $maxAutoEarningLevel }}
                                    </span>
                                </div>
                                
                                @if ($user->auto_earning_level > 0)
                                    <p class="text-muted mb-2">
                                        <strong>Current Benefits:</strong>
                                    </p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Auto Earning Rate: {{ $user->auto_earning_level * 0.05 }}% per hour</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Passive income while offline</li>
                                        <li><i class="fas fa-check text-success me-2"></i>No attempts required</li>
                                    </ul>
                                    <div class="alert alert-info">
                                        <small>
                                            <strong>Hourly Income:</strong> 
                                            IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.05 / 100), 0, ',', '.') }}
                                        </small>
                                    </div>
                                @else
                                    <p class="text-muted">
                                        Unlock passive income! Earn money automatically every hour without using attempts.
                                    </p>
                                @endif
                            </div>

                            @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                <div class="text-center">
                                    <p class="fw-bold text-warning mb-3">
                                        Next Level Benefits:
                                    </p>
                                    <ul class="list-unstyled text-start mb-4">
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Auto Earning Rate: {{ ($user->auto_earning_level + 1) * 0.05 }}% per hour</li>
                                        <li><i class="fas fa-arrow-up text-primary me-2"></i>Higher passive income</li>
                                    </ul>
                                    
                                    <form method="POST" action="{{ route('store.purchase.auto-earning') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-warning btn-lg w-100 fw-bold text-dark @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            UPGRADE - IDR {{ number_format($autoEarningUpgradeCost, 0, ',', '.') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-success fs-5 py-3 px-4">
                                        <i class="fas fa-crown me-2"></i>MAX LEVEL REACHED
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Game Button -->
            <div class="text-center mt-5">
                <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Back to Game
                </a>
            </div>
        </div>
    </div>
</div>
@endsection