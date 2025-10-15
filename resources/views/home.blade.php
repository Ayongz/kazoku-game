@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark">
                    <i class="fas fa-trophy me-3 text-warning"></i>{{ __('nav.leaderboard_title') }}
                </h1>
                <p class="lead text-muted">{{ __('nav.leaderboard_subtitle') }}</p>
                <div class="mt-4">
                    <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-gamepad me-2"></i>{{ __('nav.play_now') }}
                    </a>
                    <a href="{{ route('game.status') }}" class="btn btn-outline-info btn-lg">
                        <i class="fas fa-chart-line me-2"></i>{{ __('nav.view_stats') }}
                    </a>
                </div>
            </div>

            <!-- Enhanced Game Statistics Cards -->
            <div class="row g-4 mb-5">
                <!-- Global Prize Pool -->
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-gradient-primary h-100">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-gift fa-3x mb-3 text-white"></i>
                            <h6 class="text-uppercase text-white-50 fw-bold">{{ __('nav.global_prize_pool') }}</h6>
                            <h3 class="fw-bold mb-2 text-white">IDR {{ number_format($globalPrizePool, 0, ',', '.') }}</h3>
                            <small class="text-white-75">{{ __('nav.master_treasure_hunt') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Total Money in Game -->
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-gradient-success h-100">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-coins fa-3x mb-3 text-white"></i>
                            <h6 class="text-uppercase text-white-50 fw-bold">{{ __('nav.total_wealth') }}</h6>
                            <h3 class="fw-bold mb-2 text-white">IDR {{ number_format($totalMoneyInGame, 0, ',', '.') }}</h3>
                            <small class="text-white-75">{{ __('nav.earned_by_players') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Total Random Boxes -->
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-gradient-info h-100">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-box fa-3x mb-3 text-white"></i>
                            <h6 class="text-uppercase text-white-50 fw-bold">{{ __('nav.random_boxes') }}</h6>
                            <h3 class="fw-bold mb-2 text-white">{{ number_format($totalRandomBoxes, 0, ',', '.') }}</h3>
                            <small class="text-white-75">{{ __('nav.ready_to_open') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Active Players -->
                <div class="col-12 col-lg-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-gradient-warning h-100">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-users fa-3x mb-3 text-white"></i>
                            <h6 class="text-uppercase text-white-50 fw-bold">{{ __('nav.active_players') }}</h6>
                            <h3 class="fw-bold mb-2 text-white">{{ number_format($totalPlayers, 0, ',', '.') }}</h3>
                            <small class="text-white-75">{{ __('nav.competing_glory') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Position -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg bg-gradient-secondary">
                        <div class="card-body text-white text-center py-4">
                            <h4 class="fw-bold mb-3">{{ __('nav.your_current_standing') }}</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3 mb-md-0">
                                        <h2 class="fw-bold text-warning">#{{ $userRank }}</h2>
                                        <small class="text-white-75">{{ __('nav.rank_out_of', ['total' => $totalPlayers]) }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3 mb-md-0">
                                        <h2 class="fw-bold text-success">{{ $currentUser->level ?? 1 }}</h2>
                                        <small class="text-white-75">{{ __('nav.your_level') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3 mb-md-0">
                                        <h2 class="fw-bold text-info">{{ $currentUser->randombox ?? 0 }}</h2>
                                        <small class="text-white-75">{{ __('nav.random_boxes') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3 mb-md-0">
                                        <h2 class="fw-bold text-primary">{{ $currentUser->getRandomBoxChance() }}%</h2>
                                        <small class="text-white-75">{{ __('nav.box_drop_chance') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-white border-0 py-4">
                            <h3 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-crown me-2 text-warning"></i>{{ __('nav.top_players') }}
                            </h3>
                            <p class="text-muted mb-0">{{ __('nav.richest_players_description') }}</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 py-3 px-4">
                                                <i class="fas fa-hashtag me-1"></i>{{ __('nav.rank') }}
                                            </th>
                                            <th class="border-0 py-3">
                                                <i class="fas fa-user me-1"></i>{{ __('nav.player') }}
                                            </th>
                                            <th class="border-0 py-3">
                                                <i class="fas fa-wallet me-1"></i>{{ __('nav.money_earned') }}
                                            </th>
                            <th class="border-0 py-3 text-center">
                                                <i class="fas fa-magic me-1"></i>{{ __('nav.abilities_status') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topPlayers as $index => $player)
                                            <tr class="@if($player->id === $currentUser->id) table-primary @endif">
                                                <td class="py-4 px-4">
                                                    <div class="d-flex align-items-center">
                                                        @if($index === 0)
                                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                                <i class="fas fa-crown me-1"></i>#{{ $index + 1 }}
                                                            </span>
                                                        @elseif($index === 1)
                                                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                                                <i class="fas fa-medal me-1"></i>#{{ $index + 1 }}
                                                            </span>
                                                        @elseif($index === 2)
                                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2" style="background: linear-gradient(135deg, #cd7f32 0%, #ffa500 100%) !important;">
                                                                <i class="fas fa-award me-1"></i>#{{ $index + 1 }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                                                #{{ $index + 1 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold">{{ $player->name }}</h6>
                                                            @if($player->id === $currentUser->id)
                                                                <small class="text-primary fw-bold">
                                                                    <i class="fas fa-user-check me-1"></i>{{ __('nav.you') }}
                                                                </small>
                                                            @else
                                                                <small class="text-muted">{{ __('nav.player_id', ['id' => $player->id]) }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4">
                                                    <h5 class="mb-0 fw-bold text-success">
                                                        IDR {{ number_format($player->money_earned, 0, ',', '.') }}
                                                    </h5>
                                                    @if($index === 0 && $player->money_earned > 0)
                                                        <small class="text-warning">
                                                            <i class="fas fa-star me-1"></i>{{ __('nav.richest_player') }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="py-4 text-center">
                                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                                        @if($player->steal_level > 0)
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-mask me-1"></i>{{ __('nav.auto_steal_level', ['level' => $player->steal_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->auto_earning_level > 0)
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-robot me-1"></i>{{ __('nav.auto_click_level', ['level' => $player->auto_earning_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->treasure_multiplier_level > 0)
                                                            <span class="badge bg-info">
                                                                <i class="fas fa-gem me-1"></i>{{ __('nav.treasure_level', ['level' => $player->treasure_multiplier_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->lucky_strikes_level > 0)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-star me-1"></i>{{ __('nav.lucky_level', ['level' => $player->lucky_strikes_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->counter_attack_level > 0)
                                                            <span class="badge bg-dark">
                                                                <i class="fas fa-shield-alt me-1"></i>{{ __('nav.counter_level', ['level' => $player->counter_attack_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->intimidation_level > 0)
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-skull me-1"></i>{{ __('nav.intimidate_level', ['level' => $player->intimidation_level]) }}
                                                            </span>
                                                        @endif
                                                        @if($player->shield_expires_at && $player->shield_expires_at > now())
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-shield-alt me-1"></i>{{ __('nav.shield') }}
                                                            </span>
                                                        @endif
                                                        @if($player->steal_level === 0 && $player->auto_earning_level === 0 && $player->treasure_multiplier_level === 0 && $player->lucky_strikes_level === 0 && $player->counter_attack_level === 0 && $player->intimidation_level === 0)
                                                            <small class="text-muted">{{ __('nav.no_abilities') }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Game Features Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg bg-gradient-info">
                        <div class="card-body text-white text-center py-5">
                            <h3 class="fw-bold mb-4">🎮 Game Features</h3>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-4">
                                        <i class="fas fa-coins fa-3x mb-3"></i>
                                        <h5 class="fw-bold">Treasure Hunt</h5>
                                        <p class="mb-0">Open treasures to earn money and experience</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-4">
                                        <i class="fas fa-box fa-3x mb-3"></i>
                                        <h5 class="fw-bold">Random Boxes</h5>
                                        <p class="mb-0">Collect and open boxes for special rewards</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-4">
                                        <i class="fas fa-user-ninja fa-3x mb-3"></i>
                                        <h5 class="fw-bold">Steal & Defend</h5>
                                        <p class="mb-0">Steal from others or protect your wealth</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-4">
                                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                                        <h5 class="fw-bold">Level Up</h5>
                                        <p class="mb-0">Gain experience and unlock new abilities</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced Background Gradients */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
    }
    
    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
    }
    
    .bg-gradient-dark {
        background: linear-gradient(135deg, #2d3436 0%, #636e72 100%);
    }

    /* Purple color support */
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }

    /* Avatar Circle */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.9rem;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #dee2e6;
        position: relative;
    }
    
    .player-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    }

    /* Enhanced Card Hover Effects */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }

    /* Table Enhancements */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: scale(1.01);
        transition: all 0.2s ease;
    }
    
    .table tbody tr.table-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
        border-left: 4px solid #0d6efd;
    }

    /* Badge Enhancements */
    .badge {
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5em 0.8em;
        font-size: 0.8rem;
    }
    
    .badge i {
        opacity: 0.9;
    }

    /* Button Hover Effects */
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2rem;
        }
        
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .badge {
            font-size: 0.7rem;
            margin: 1px;
            padding: 0.3em 0.6em;
        }
        
        .avatar-circle {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .fa-3x {
            font-size: 2rem !important;
        }
    }

    @media (max-width: 576px) {
        .col-lg-3 {
            margin-bottom: 1rem;
        }
        
        .table td, .table th {
            padding: 0.5rem;
        }
        
        .px-4 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
    }

    /* Animation for loading */
    .card {
        animation: slideUp 0.6s ease-out;
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

    /* Text Enhancement */
    .text-white-75 {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    /* Enhanced spacing */
    .py-3 {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }
</style>
@endsection
