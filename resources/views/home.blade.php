@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark">navbar-brand
                    <i class="fas fa-trophy me-3 text-warning"></i>Leaderboard
                </h1>
                <p class="lead text-muted">See who's dominating the money game!</p>
            </div>

            <!-- Game Statistics Cards -->
            <div class="row g-4 mb-5">
                <!-- Global Prize Pool -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm bg-primary">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-gift fa-2x mb-2 text-white"></i>
                            <h6 class="text-uppercase text-white-50">Global Prize Pool</h6>
                            <h3 class="fw-bold mb-0 text-white">IDR {{ number_format($globalPrizePool, 0, ',', '.') }}</h3>
                            <small class="text-white-50">Daily winner takes all!</small>
                        </div>
                    </div>
                </div>

                <!-- Total Money in Game -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm bg-success">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-coins fa-2x mb-2 text-white"></i>
                            <h6 class="text-uppercase text-white-50">Total Money in Game</h6>
                            <h3 class="fw-bold mb-0 text-white">IDR {{ number_format($totalMoneyInGame, 0, ',', '.') }}</h3>
                            <small class="text-white-50">Earned by all players</small>
                        </div>
                    </div>
                </div>

                <!-- Your Rank -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm bg-info">
                        <div class="card-body text-white text-center">
                            <i class="fas fa-medal fa-2x mb-2 text-white"></i>
                            <h6 class="text-uppercase text-white-50">Your Rank</h6>
                            <h3 class="fw-bold mb-0 text-white">#{{ $userRank }}</h3>
                            <small class="text-white-50">out of {{ $totalPlayers }} players</small>
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
                                <i class="fas fa-crown me-2 text-warning"></i>Top Players
                            </h3>
                            <p class="text-muted mb-0">The richest players in the game</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 py-3 px-4">
                                                <i class="fas fa-hashtag me-1"></i>Rank
                                            </th>
                                            <th class="border-0 py-3">
                                                <i class="fas fa-user me-1"></i>Player
                                            </th>
                                            <th class="border-0 py-3">
                                                <i class="fas fa-wallet me-1"></i>Money Earned
                                            </th>
                                            <th class="border-0 py-3 text-center">
                                                <i class="fas fa-cogs me-1"></i>Abilities
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
                                                                    <i class="fas fa-user-check me-1"></i>You
                                                                </small>
                                                            @else
                                                                <small class="text-muted">Player ID: {{ $player->id }}</small>
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
                                                            <i class="fas fa-star me-1"></i>Richest Player
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="py-4 text-center">
                                                    <div class="d-flex flex-column gap-1">
                                                        @if($player->steal_level > 0)
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-mask me-1"></i>Steal Lv.{{ $player->steal_level }}
                                                            </span>
                                                        @endif
                                                        @if($player->auto_earning_level > 0)
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="fas fa-robot me-1"></i>Auto Lv.{{ $player->auto_earning_level }}
                                                            </span>
                                                        @endif
                                                        @if($player->steal_level === 0 && $player->auto_earning_level === 0)
                                                            <small class="text-muted">No abilities</small>
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

            <!-- Quick Actions -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h4 class="mb-4">Ready to climb the ranks?</h4>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                        <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-gamepad me-2"></i>Play Game
                        </a>
                        <a href="{{ route('store.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-store me-2"></i>Visit Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient {
        position: relative;
        overflow: hidden;
    }
    
    .bg-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .bg-gradient:hover::before {
        opacity: 1;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .table tbody tr.table-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
        border-left: 4px solid #0d6efd;
    }
    
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
