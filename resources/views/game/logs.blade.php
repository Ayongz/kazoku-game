@extends('layouts.app')

@section('content')
<div class="rpg-logs-world">
    <!-- RPG Background Elements -->
    <div class="rpg-background">
        <div class="floating-particles"></div>
        <div class="magic-orbs"></div>
        <div class="energy-waves"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                
                <!-- RPG Header -->
                <div class="rpg-logs-header text-center mb-5">
                    <div class="rpg-header-container">
                        <h1 class="rpg-logs-title">
                            <i class="fas fa-scroll me-3"></i>{{ __('nav.player_activity_logs') }}
                        </h1>
                        <div class="rpg-title-decoration"></div>
                        <p class="rpg-logs-subtitle">{{ __('nav.track_your_adventure_history') }}</p>
                    </div>
                </div>

                <!-- Statistics Overview -->
                <div class="row mb-5">
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-money">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.money_gained') }}</h3>
                                <h4 class="rpg-stat-value">
                                    IDR {{ number_format($stats['total_money_gained'], 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-loss">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-minus-circle"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.money_lost') }}</h3>
                                <h4 class="rpg-stat-value">
                                    IDR {{ number_format($stats['total_money_lost'], 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-exp">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.total_exp') }}</h3>
                                <h4 class="rpg-stat-value">
                                    {{ number_format($stats['total_experience_gained']) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-treasure">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.treasures_opened') }}</h3>
                                <h4 class="rpg-stat-value">
                                    {{ number_format($stats['total_treasures_opened']) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-gambling">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-dice"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.gambling_sessions') }}</h3>
                                <h4 class="rpg-stat-value">
                                    {{ number_format($stats['total_gambling_sessions']) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="rpg-logs-stat-card stat-success">
                            <div class="rpg-stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="rpg-stat-content">
                                <h3 class="rpg-stat-label">{{ __('nav.success_rate') }}</h3>
                                <h4 class="rpg-stat-value">
                                    {{ $stats['success_rate'] }}%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="rpg-logs-panel mb-4">
                    <div class="rpg-panel-header">
                        <h4 class="rpg-panel-title">
                            <i class="fas fa-filter me-2"></i>{{ __('nav.filter_logs') }}
                        </h4>
                    </div>
                    <div class="rpg-panel-content">
                        <form method="GET" action="{{ route('game.logs') }}" class="row g-3">
                            <div class="col-md-4">
                                <label class="rpg-form-label">{{ __('nav.action_type') }}</label>
                                <select name="action_type" class="rpg-form-select">
                                    <option value="all" {{ $currentFilter === 'all' ? 'selected' : '' }}>{{ __('nav.all_actions') }}</option>
                                    <option value="treasure_open" {{ $currentFilter === 'treasure_open' ? 'selected' : '' }}>{{ __('nav.treasure_opening') }}</option>
                                    <option value="rare_treasure_open" {{ $currentFilter === 'rare_treasure_open' ? 'selected' : '' }}>{{ __('nav.rare_treasure_opening') }}</option>
                                    <option value="random_box_open" {{ $currentFilter === 'random_box_open' ? 'selected' : '' }}>{{ __('nav.random_box_opening') }}</option>
                                    <option value="gambling_dice" {{ $currentFilter === 'gambling_dice' ? 'selected' : '' }}>{{ __('nav.dice_gambling') }}</option>
                                    <option value="gambling_card" {{ $currentFilter === 'gambling_card' ? 'selected' : '' }}>{{ __('nav.card_gambling') }}</option>
                                    <option value="treasure_fusion" {{ $currentFilter === 'treasure_fusion' ? 'selected' : '' }}>{{ __('nav.treasure_fusion') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="rpg-form-label">{{ __('nav.per_page') }}</label>
                                <select name="per_page" class="rpg-form-select">
                                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-5 d-flex align-items-end gap-2">
                                <button type="submit" class="rpg-logs-btn rpg-btn-primary">
                                    <i class="fas fa-search me-1"></i>{{ __('nav.apply_filter') }}
                                </button>
                                <a href="{{ route('game.logs') }}" class="rpg-logs-btn rpg-btn-secondary">
                                    <i class="fas fa-times me-1"></i>{{ __('nav.clear') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Activity Logs -->
                <div class="rpg-logs-panel">
                    <div class="rpg-panel-header">
                        <h4 class="rpg-panel-title">
                            <i class="fas fa-history me-2"></i>{{ __('nav.activity_history') }}
                        </h4>
                    </div>
                    <div class="rpg-panel-content">
                        <div class="rpg-logs-table-container">
                            <table class="rpg-logs-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-clock me-1"></i>{{ __('nav.time') }}</th>
                                        <th><i class="fas fa-bolt me-1"></i>{{ __('nav.action') }}</th>
                                        <th><i class="fas fa-scroll me-1"></i>{{ __('nav.description') }}</th>
                                        <th><i class="fas fa-coins me-1"></i>{{ __('nav.money_change') }}</th>
                                        <th><i class="fas fa-star me-1"></i>{{ __('nav.exp_gained') }}</th>
                                        <th><i class="fas fa-trophy me-1"></i>{{ __('nav.result') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr class="rpg-log-row {{ $log->is_success ? 'log-success' : 'log-failure' }}">
                                            <td class="rpg-log-time">
                                                <span class="time-badge">
                                                    {{ $log->created_at->setTimezone('Asia/Jakarta')->format('M d, H:i') }}
                                                </span>
                                            </td>
                                            <td class="rpg-log-action">
                                                <span class="action-badge action-{{ str_replace('_', '-', $log->action_type) }}">
                                                    {!! $log->action_type_display !!}
                                                </span>
                                            </td>
                                            <td class="rpg-log-description">{{ $log->description }}</td>
                                            <td class="rpg-log-money">
                                                @if($log->money_change != 0)
                                                    <span class="money-change {{ $log->money_change > 0 ? 'money-gain' : 'money-loss' }}">
                                                        {{ $log->formatted_money_change }}
                                                    </span>
                                                @else
                                                    <span class="no-change">-</span>
                                                @endif
                                            </td>
                                            <td class="rpg-log-exp">
                                                @if($log->experience_gained > 0)
                                                    <span class="exp-gain">
                                                        +{{ $log->experience_gained }} EXP
                                                    </span>
                                                @else
                                                    <span class="no-change">-</span>
                                                @endif
                                            </td>
                                            <td class="rpg-log-result">
                                                @if($log->is_success)
                                                    <span class="result-badge result-success">
                                                        <i class="fas fa-check me-1"></i>{{ __('nav.success') }}
                                                    </span>
                                                @else
                                                    <span class="result-badge result-failure">
                                                        <i class="fas fa-times me-1"></i>{{ __('nav.failed') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="rpg-log-empty">
                                                <div class="empty-state">
                                                    <i class="fas fa-scroll fa-3x mb-3"></i>
                                                    <h5>{{ __('nav.no_logs_found') }}</h5>
                                                    <p class="text-muted">{{ __('nav.start_playing_to_see_history') }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($logs->hasPages())
                            <div class="rpg-pagination-container">
                                {{ $logs->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Back to Dashboard -->
                <div class="text-center mt-5">
                    <a href="{{ route('game.dashboard') }}" class="rpg-logs-btn rpg-btn-back">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('nav.back_to_dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* === RPG LOGS THEME STYLING === */

.rpg-logs-world {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);
    background-size: 400% 400%;
    animation: mysticalShift 30s ease-in-out infinite;
    position: relative;
    overflow-x: hidden;
}

.rpg-logs-world::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(3px 3px at 25px 25px, rgba(255, 215, 0, 0.3), transparent),
        radial-gradient(2px 2px at 50px 75px, rgba(59, 130, 246, 0.2), transparent),
        radial-gradient(1px 1px at 100px 50px, rgba(168, 85, 247, 0.3), transparent);
    background-repeat: repeat;
    background-size: 200px 120px;
    animation: floatingMagic 25s linear infinite;
    pointer-events: none;
    z-index: 1;
    opacity: 0.6;
}

@keyframes mysticalShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 25%; }
    50% { background-position: 100% 75%; }
    75% { background-position: 0% 100%; }
}

@keyframes floatingMagic {
    0% { transform: translateY(0px) translateX(0px) rotate(0deg); }
    25% { transform: translateY(-10px) translateX(5px) rotate(90deg); }
    50% { transform: translateY(0px) translateX(-5px) rotate(180deg); }
    75% { transform: translateY(5px) translateX(5px) rotate(270deg); }
    100% { transform: translateY(0px) translateX(0px) rotate(360deg); }
}

/* Header Styling */
.rpg-logs-header {
    position: relative;
    z-index: 2;
}

.rpg-header-container {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.15));
    border: 2px solid rgba(59, 130, 246, 0.4);
    border-radius: 20px;
    padding: 2.5rem;
    backdrop-filter: blur(15px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.rpg-logs-title {
    font-size: 3rem;
    font-weight: bold;
    background: linear-gradient(45deg, #60a5fa, #a78bfa, #fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 0 30px rgba(96, 165, 250, 0.8);
    margin-bottom: 1rem;
    letter-spacing: 2px;
}

.rpg-title-decoration {
    height: 3px;
    background: linear-gradient(90deg, transparent, rgba(96, 165, 250, 0.8), transparent);
    margin: 1rem auto;
    border-radius: 2px;
    width: 200px;
}

.rpg-logs-subtitle {
    font-size: 1.2rem;
    color: #cbd5e1;
    font-weight: 500;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    margin: 0;
}

/* Statistics Cards */
.rpg-logs-stat-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border: 2px solid #334155;
    border-radius: 15px;
    padding: 10px;
    height: 100%;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.rpg-logs-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--stat-color), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.rpg-logs-stat-card:hover {
    transform: translateY(-5px);
    border-color: var(--stat-color);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
}

.rpg-logs-stat-card:hover::before {
    opacity: 1;
}

.stat-money { --stat-color: #22c55e; }
.stat-loss { --stat-color: #ef4444; }
.stat-exp { --stat-color: #fbbf24; }
.stat-treasure { --stat-color: #06b6d4; }
.stat-gambling { --stat-color: #8b5cf6; }
.stat-success { --stat-color: #10b981; }

.rpg-stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--stat-color), rgba(var(--stat-color), 0.8));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 0 15px rgba(var(--stat-color), 0.5);
    flex-shrink: 0;
}

.rpg-stat-content {
    flex: 1;
}

.rpg-stat-label {
    font-size: 0.7rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.rpg-stat-value {
    font-size: 1.1rem;
    font-weight: bold;
    color: #f1f5f9;
    margin: 0;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

/* Panel Styling */
.rpg-logs-panel {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border: 2px solid #334155;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 2;
}

.rpg-panel-header {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    padding: 1.5rem 2rem;
    border-bottom: 2px solid #4b5563;
}

.rpg-panel-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #60a5fa;
    margin: 0;
    text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
}

.rpg-panel-content {
    padding: 2rem;
}

/* Form Controls */
.rpg-form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #e2e8f0;
    margin-bottom: 0.5rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.rpg-form-select {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    border: 2px solid #4b5563;
    border-radius: 8px;
    color: #f1f5f9;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    width: 100%;
}

.rpg-form-select:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
    outline: none;
}

.rpg-form-select option {
    background: #1f2937;
    color: #f1f5f9;
}

/* Buttons */
.rpg-logs-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.rpg-btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.rpg-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
    color: white;
}

.rpg-btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #374151 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
}

.rpg-btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.6);
    color: white;
}

.rpg-btn-back {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
    padding: 1rem 2rem;
    font-size: 1rem;
}

.rpg-btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
    color: white;
}

/* Table Styling */
.rpg-logs-table-container {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
}

.rpg-logs-table {
    width: 100%;
    border-collapse: collapse;
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
}

.rpg-logs-table thead th {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    color: #f1f5f9;
    font-weight: 600;
    padding: 1rem;
    text-align: left;
    border-bottom: 2px solid #6b7280;
    font-size: 0.9rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.rpg-log-row {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.rpg-log-row:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.1));
    transform: scale(1.01);
}

.rpg-log-row.log-failure {
    border-left: 3px solid #ef4444;
}

.rpg-log-row.log-success {
    border-left: 3px solid #22c55e;
}

.rpg-logs-table td {
    padding: 1rem;
    color: #e2e8f0;
    font-size: 0.9rem;
    vertical-align: middle;
}

/* Badges and Status */
.time-badge {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-block;
}

.action-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

.action-treasure-open { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }
.action-rare-treasure-open { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.action-random-box-open { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
.action-gambling-dice { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.action-gambling-card { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.action-treasure-fusion { background: linear-gradient(135deg, #f97316, #ea580c); color: white; }

.money-change {
    font-weight: bold;
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.85rem;
}

.money-gain {
    background: rgba(34, 197, 94, 0.2);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.money-loss {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.exp-gain {
    background: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.3);
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.85rem;
}

.no-change {
    color: #6b7280;
    font-style: italic;
}

.result-badge {
    padding: 0.3rem 0.7rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
}

.result-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
}

.result-failure {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

/* Empty State */
.rpg-log-empty {
    padding: 4rem 2rem !important;
    text-align: center;
}

.empty-state {
    color: #94a3b8;
}

.empty-state i {
    color: #6b7280;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #e2e8f0;
    margin-bottom: 0.5rem;
}

/* Pagination */
.rpg-pagination-container {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.rpg-pagination-container .pagination {
    background: none;
}

.rpg-pagination-container .page-link {
    background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
    border: 1px solid #4b5563;
    color: #e2e8f0;
    padding: 0.5rem 0.75rem;
    margin: 0 0.1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.rpg-pagination-container .page-link:hover,
.rpg-pagination-container .page-item.active .page-link {
    background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
    border-color: #60a5fa;
    color: white;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .rpg-logs-title {
        font-size: 2rem;
    }
    
    .rpg-header-container {
        padding: 1.5rem;
    }
    
    .rpg-logs-stat-card {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .rpg-panel-content {
        padding: 1rem;
    }
    
    .rpg-logs-table thead th,
    .rpg-logs-table td {
        padding: 0.5rem;
        font-size: 0.8rem;
    }
    
    .rpg-logs-btn {
        font-size: 0.8rem;
        padding: 0.6rem 1rem;
    }
}

@media (max-width: 576px) {
    .rpg-logs-table-container {
        font-size: 0.75rem;
    }
    
    .action-badge,
    .result-badge,
    .money-change,
    .exp-gain {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }
}
</style>
@endsection