@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-5">
                The Game Dashboard
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

            <!-- Player & Global Stats - Responsive Grid -->
            <div class="row g-4 mb-5">
                <!-- Player Money Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-primary">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Money Earned</p>
                            <h2 class="card-title h3 fw-bolder text-dark">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Attempts Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-warning">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Current Attempts</p>
                            <h2 class="card-title h3 fw-bolder @if($user->attempts > 0) text-warning @else text-danger @endif">
                                {{ $user->attempts }}
                            </h2>
                            <p class="text-muted small mb-0">Resets to 1 hourly.</p>
                        </div>
                    </div>
                </div>

                <!-- Global Prize Pool Card -->
                <div class="col-12 col-md-4">
                    <div class="card h-100 shadow-lg border-start border-5 border-info">
                        <div class="card-body">
                            <p class="card-text text-uppercase text-muted fw-semibold mb-1">Global Prize Pool</p>
                            <h2 class="card-title h3 fw-bolder text-info">
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
                            <h2 class="h3 fw-bold text-primary mb-3">Daily Grind</h2>
                            <p class="text-muted mb-4">Click below to try and earn money. Uses one attempt.</p>
                            
                            <form method="POST" action="{{ route('game.earn') }}">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-lg w-100 w-sm-auto fw-bold text-uppercase @if($user->attempts > 0) btn-primary @else btn-secondary disabled @endif"
                                        @if($user->attempts <= 0) disabled @endif>
                                    @if($user->attempts > 0)
                                        <i class="fas fa-coins me-2"></i> EARN MONEY NOW
                                    @else
                                        OUT OF ATTEMPTS
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- 2. STEAL ABILITY MANAGEMENT -->
                <div class="col-12">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="h3 fw-bold text-danger mb-4">Steal Operations</h2>
                            
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-4 mb-4">
                                <p class="lead fw-normal text-muted mb-2 mb-sm-0">
                                    Steal Level: <span class="fw-bolder text-danger">{{ $user->steal_level }} / {{ $maxStealLevel }}</span>
                                </p>
                                
                                @if ($user->steal_level < $maxStealLevel)
                                    <form method="POST" action="{{ route('game.purchase') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success fw-bold @if($user->money_earned < $stealUpgradeCost) disabled @endif"
                                                @if($user->money_earned < $stealUpgradeCost) disabled @endif>
                                            UPGRADE (IDR {{ number_format($stealUpgradeCost, 0, ',', '.') }})
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success py-2 px-3 fw-bold">MAX LEVEL REACHED</span>
                                @endif
                            </div>

                            <!-- Execute Steal Button (only available if level > 0) -->
                            <form method="POST" action="{{ route('game.steal') }}">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-lg w-100 fw-bold text-uppercase @if($user->steal_level > 0) btn-danger @else btn-secondary disabled @endif"
                                        @if($user->steal_level === 0) disabled @endif>
                                    <i class="fas fa-hand-lizard me-2"></i> ATTEMPT HEIST
                                </button>
                            </form>
                            <p class="text-muted small mt-2 text-center">Success chance and reward depend on your Steal Level.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
