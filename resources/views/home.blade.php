@extends('layouts.app')

@section('content')
<style>
/* === RPG THEME STYLING === */

/* Main Container Background */
.rpg-dashboard-container {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 25%, #0f3460 50%, #1a1a2e 75%, #16213e 100%);
    background-size: 400% 400%;
    animation: backgroundShift 20s ease-in-out infinite;
}

.rpg-dashboard-container::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(2px 2px at 20px 30px, rgba(255,193,7,0.4), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(59,130,246,0.3), transparent),
        radial-gradient(1px 1px at 90px 40px, rgba(147,51,234,0.4), transparent),
        radial-gradient(1px 1px at 130px 80px, rgba(34,197,94,0.3), transparent),
        radial-gradient(2px 2px at 160px 30px, rgba(239,68,68,0.3), transparent);
    background-repeat: repeat;
    background-size: 200px 100px;
    animation: floatingStars 25s linear infinite;
    pointer-events: none;
    z-index: 1;
}

.text-muted{
    color:white !important;
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

.rpg-dashboard-container > .container {
    position: relative;
    z-index: 2;
}

/* RPG Panels */
.rpg-panel {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-radius: 15px;
    box-shadow: 
        0 10px 30px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.1),
        0 0 20px rgba(59, 130, 246, 0.1);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.rpg-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.05) 50%, transparent 70%);
    pointer-events: none;
}

.rpg-panel:hover {
    transform: translateY(-5px);
    box-shadow: 
        0 15px 40px rgba(0, 0, 0, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.15),
        0 0 30px rgba(59, 130, 246, 0.2);
}

.panel-leaderboard {
    border-color: rgba(255, 193, 7, 0.4);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.6),
        inset 0 1px 0 rgba(255, 255, 255, 0.15),
        0 0 25px rgba(255, 193, 7, 0.2);
}

/* RPG Titles */
.rpg-title {
    font-family: 'Cinzel', serif;
    font-weight: 700;
    letter-spacing: 1px;
    background: linear-gradient(45deg, #fbbf24, #f59e0b, #d97706);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: titleShimmer 3s ease-in-out infinite;
}

@keyframes titleShimmer {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.rpg-subtitle {
    color: #e2e8f0;
    font-weight: 500;
}

/* RPG Buttons */
.rpg-button {
    position: relative;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.rpg-button-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.rpg-button:hover .rpg-button-glow {
    left: 100%;
}

.rpg-button-primary {
    background: linear-gradient(45deg, #3b82f6, #1d4ed8);
    color: white;
}

.rpg-button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.rpg-button-secondary {
    background: linear-gradient(45deg, #7c3aed, #5b21b6);
    color: white;
}

.rpg-button-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
}

/* Stat Cards */
.rpg-stat-card {
    /* background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9)); */
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.rpg-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.05) 50%, transparent 70%);
    pointer-events: none;
}

.rpg-stat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
}

.rpg-stat-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.rpg-stat-value {
    font-family: 'Orbitron', monospace;
    font-weight: 700;
    font-size: 1.4rem;
    color: #fbbf24;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}

.rpg-stat-label {
    color: #cbd5e1;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.75rem;
    line-height: 1.3;
}

.rpg-stat-description {
    color: #94a3b8;
    font-size: 0.7rem;
    margin-top: 0.25rem;
    display: none; /* Hidden to save space */
}

/* Player Position Panel */
.rpg-position-panel {
    background: linear-gradient(145deg, rgba(124, 58, 237, 0.2), rgba(91, 33, 182, 0.2));
    border: 2px solid rgba(124, 58, 237, 0.4);
    border-radius: 15px;
    padding: 1.25rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.rpg-position-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(124, 58, 237, 0.1) 50%, transparent 70%);
    pointer-events: none;
}

/* Leaderboard Table */
.rpg-table {
    background: transparent;
    border-radius: 12px;
    overflow: hidden;
}

.rpg-table thead {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
}

.rpg-table th {
    border: none;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem;
}

.rpg-table td {
    border: none;
    background: rgba(30, 41, 59, 0.3);
    color: #e2e8f0;
    padding: 1rem;
    vertical-align: middle;
}

.rpg-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(59, 130, 246, 0.1);
}

.rpg-table tbody tr:hover {
    background: rgba(59, 130, 246, 0.1);
    transform: scale(1.01);
}

.rpg-table tbody tr.current-player {
    background: rgba(59, 130, 246, 0.2);
    border-left: 4px solid #3b82f6;
    box-shadow: inset 0 0 10px rgba(59, 130, 246, 0.3);
}

/* Rank Badges */
.rpg-rank-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
}

.rank-1 {
    background: linear-gradient(45deg, #fbbf24, #f59e0b);
    color: #1f2937;
}

.rank-2 {
    background: linear-gradient(45deg, #94a3b8, #64748b);
    color: white;
}

.rank-3 {
    background: linear-gradient(45deg, #cd7f32, #92400e);
    color: white;
}

.rank-other {
    background: linear-gradient(45deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.8));
    color: #e2e8f0;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

/* Player Avatar */
.rpg-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(45deg, #3b82f6, #1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
    border: 2px solid rgba(59, 130, 246, 0.5);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

/* Ability Badges */
.rpg-ability-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.7rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    margin: 0.2rem;
}

.ability-steal { background: linear-gradient(45deg, #dc2626, #991b1b); color: white; }
.ability-auto { background: linear-gradient(45deg, #f59e0b, #d97706); color: white; }
.ability-treasure { background: linear-gradient(45deg, #06b6d4, #0891b2); color: white; }
.ability-lucky { background: linear-gradient(45deg, #10b981, #059669); color: white; }
.ability-counter { background: linear-gradient(45deg, #374151, #1f2937); color: white; }
.ability-intimidate { background: linear-gradient(45deg, #fbbf24, #f59e0b); color: #1f2937; }
.ability-shield { background: linear-gradient(45deg, #6b7280, #4b5563); color: white; }

/* Level Badge */
.rpg-level-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background: linear-gradient(45deg, #7c3aed, #5b21b6);
    border: 2px solid rgba(124, 58, 237, 0.3);
    box-shadow: 0 0 15px rgba(124, 58, 237, 0.2);
    transition: all 0.3s ease;
}

.rpg-level-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(124, 58, 237, 0.4);
}

/* Responsive Design */
@media (max-width: 768px) {
    .rpg-title {
        font-size: 2rem;
    }
    
    .rpg-stat-card {
        padding: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .rpg-stat-icon {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }
    
    .rpg-stat-value {
        font-size: 1.1rem;
    }
    
    .rpg-stat-label {
        font-size: 0.7rem;
    }
    
    .rpg-position-panel {
        padding: 1rem;
    }
    
    .rpg-table th,
    .rpg-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.9rem;
    }
    
    .rpg-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .rpg-ability-badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin: 0.1rem;
    }
    
    .rpg-button {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .rpg-stat-card {
        padding: 0.5rem;
    }
    
    .rpg-stat-icon {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    
    .rpg-stat-value {
        font-size: 1rem;
    }
    
    .rpg-stat-label {
        font-size: 0.65rem;
    }
    
    .rpg-position-panel {
        padding: 0.75rem;
    }
    
    .rpg-table th,
    .rpg-table td {
        padding: 0.5rem 0.3rem;
        font-size: 0.8rem;
    }
    
    .rpg-ability-badge {
        font-size: 0.65rem;
        padding: 0.15rem 0.4rem;
    }
}

/* Loading Animation */
.rpg-panel {
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
</style>

<div class="rpg-dashboard-container">
    <div class="container pt-4">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <h1 class="rpg-title display-4 mb-3">
                <i class="fas fa-crown me-3"></i>{{ __('nav.leaderboard_title') }}
            </h1>
            <p class="rpg-subtitle lead mb-4">{{ __('nav.leaderboard_subtitle') }}</p>
            
            <!-- Action Buttons -->
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="rpg-button rpg-button-primary d-flex align-items-center" onclick="location.href='{{ route('game.dashboard') }}'">
                    <div class="rpg-button-glow"></div>
                    <span class="rpg-button-content">
                        <i class="fas fa-gamepad me-2"></i>{{ __('nav.play_now') }}
                    </span>
                </button>
                <button class="rpg-button rpg-button-secondary d-flex align-items-center" onclick="location.href='{{ route('game.status') }}'">
                    <div class="rpg-button-glow"></div>
                    <span class="rpg-button-content">
                        <i class="fas fa-chart-line me-2"></i>{{ __('nav.view_stats') }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Game Statistics Grid -->
        <div class="row g-3 mb-3">
            <div class="col-6 col-md-3">
                <div class="rpg-stat-card">
                    <div class="rpg-stat-icon">🎁</div>
                    <div class="rpg-stat-value">{{ number_format($globalPrizePool, 0, ',', '.') }}</div>
                    <div class="rpg-stat-label">{{ __('nav.global_prize_pool') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rpg-stat-card">
                    <div class="rpg-stat-icon">💰</div>
                    <div class="rpg-stat-value">{{ number_format($totalMoneyInGame, 0, ',', '.') }}</div>
                    <div class="rpg-stat-label">{{ __('nav.total_wealth') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rpg-stat-card">
                    <div class="rpg-stat-icon">📦</div>
                    <div class="rpg-stat-value">{{ number_format($totalRandomBoxes, 0, ',', '.') }}</div>
                    <div class="rpg-stat-label">{{ __('nav.random_boxes') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rpg-stat-card">
                    <div class="rpg-stat-icon">👥</div>
                    <div class="rpg-stat-value">{{ number_format($totalPlayers, 0, ',', '.') }}</div>
                    <div class="rpg-stat-label">{{ __('nav.active_players') }}</div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Panel -->
        <div class="rpg-panel panel-leaderboard">
            <div class="p-4">
                <h3 class="text-white fw-bold mb-3">
                    <i class="fas fa-trophy me-2 text-warning"></i>{{ __('nav.top_players') }}
                </h3>
                <p class="text-muted mb-4">{{ __('nav.richest_players_description') }}</p>
                
                <div class="table-responsive">
                    <table class="rpg-table table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>{{ __('nav.rank') }}</th>
                                <th><i class="fas fa-user me-1"></i>{{ __('nav.player') }}</th>
                                <th class="d-none d-md-table-cell"><i class="fas fa-wallet me-1"></i>{{ __('nav.money_earned') }}</th>
                                <th class="text-center"><i class="fas fa-star me-1"></i>{{ __('nav.level') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topPlayers as $index => $player)
                                <tr class="@if($player->id === $currentUser->id) current-player @endif">
                                    <td>
                                        <div class="rpg-rank-badge 
                                            @if($index === 0) rank-1
                                            @elseif($index === 1) rank-2
                                            @elseif($index === 2) rank-3
                                            @else rank-other @endif">
                                            @if($index === 0)
                                                <i class="fas fa-crown me-1"></i>
                                            @elseif($index === 1)
                                                <i class="fas fa-medal me-1"></i>
                                            @elseif($index === 2)
                                                <i class="fas fa-award me-1"></i>
                                            @else
                                                <i class="fas fa-hashtag me-1"></i>
                                            @endif
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rpg-avatar me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-white">{{ $player->name }}</h6>
                                                @if($player->id === $currentUser->id)
                                                    <small class="text-primary fw-bold">
                                                        <i class="fas fa-user-check me-1"></i>{{ __('nav.you') }}
                                                    </small>
                                                @endif
                                                <div class="d-md-none mt-1">
                                                    <span class="text-success fw-bold small">
                                                        IDR {{ number_format($player->money_earned, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <h5 class="mb-0 fw-bold text-success">
                                            IDR {{ number_format($player->money_earned, 0, ',', '.') }}
                                        </h5>
                                        @if($index === 0 && $player->money_earned > 0)
                                            <small class="text-warning">
                                                <i class="fas fa-star me-1"></i>{{ __('nav.richest_player') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="rpg-level-badge">
                                            <i class="fas fa-star me-2 text-warning"></i>
                                            <span class="fw-bold text-white">{{ __('nav.level') }} {{ $player->level ?? 1 }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br />
    </div>
</div>
@endsection
