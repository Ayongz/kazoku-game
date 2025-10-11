@extends('layouts.app')

@section('content')
<style>
/* RPG Guide Theme - Complete Redesign */
.rpg-guide-world {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);
    background-size: 400% 400%;
    animation: mysticalShift 30s ease-in-out infinite;
    position: relative;
    overflow-x: hidden;
}

.rpg-guide-world::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(3px 3px at 25px 25px, rgba(255, 215, 0, 0.6), transparent),
        radial-gradient(2px 2px at 50px 75px, rgba(59, 130, 246, 0.4), transparent),
        radial-gradient(1px 1px at 100px 50px, rgba(168, 85, 247, 0.5), transparent),
        radial-gradient(2px 2px at 150px 100px, rgba(34, 197, 94, 0.4), transparent);
    background-repeat: repeat;
    background-size: 250px 150px;
    animation: floatingMagic 40s linear infinite;
    pointer-events: none;
    z-index: 1;
    opacity: 0.8;
}

@keyframes mysticalShift {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 100% 25%; }
    50% { background-position: 100% 75%; }
    75% { background-position: 0% 100%; }
}

@keyframes floatingMagic {
    0% { transform: translateY(0px) translateX(0px) rotate(0deg); }
    25% { transform: translateY(-15px) translateX(10px) rotate(90deg); }
    50% { transform: translateY(0px) translateX(-10px) rotate(180deg); }
    75% { transform: translateY(10px) translateX(10px) rotate(270deg); }
    100% { transform: translateY(0px) translateX(0px) rotate(360deg); }
}

.rpg-guide-container {
    position: relative;
    z-index: 2;
    padding: 2rem 0;
}

/* Main Header */
.rpg-main-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
}

.rpg-main-title {
    font-size: 3.5rem;
    font-weight: bold;
    background: linear-gradient(45deg, #60a5fa, #a78bfa, #fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 0 30px rgba(96, 165, 250, 0.8);
    margin-bottom: 1rem;
    letter-spacing: 2px;
}

.rpg-main-subtitle {
    font-size: 1.4rem;
    color: #cbd5e1;
    font-weight: 500;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    margin-bottom: 1.5rem;
}

.rpg-intro-message {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(59, 130, 246, 0.15));
    border: 2px solid rgba(34, 197, 94, 0.4);
    border-radius: 15px;
    padding: 1.5rem;
    color: #e2e8f0;
    font-size: 1.1rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    margin-top: 1rem;
}

/* Guide Sections */
.rpg-guide-section {
    background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
    border: 2px solid rgba(59, 130, 246, 0.4);
    border-radius: 20px;
    margin-bottom: 2.5rem;
    overflow: hidden;
    backdrop-filter: blur(20px);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.1),
        0 0 0 1px rgba(59, 130, 246, 0.1);
    transition: all 0.3s ease;
    position: relative;
}

.rpg-guide-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(96, 165, 250, 0.8), transparent);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

.rpg-guide-section:hover {
    transform: translateY(-5px);
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.5),
        inset 0 1px 0 rgba(255, 255, 255, 0.15),
        0 0 0 1px rgba(59, 130, 246, 0.2);
}

.rpg-section-header {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.3));
    padding: 1.5rem 2rem;
    border-bottom: 2px solid rgba(59, 130, 246, 0.4);
    position: relative;
}

.rpg-section-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: #60a5fa;
    text-shadow: 
        0 0 10px rgba(96, 165, 250, 0.7),
        2px 2px 4px rgba(0, 0, 0, 0.5);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.rpg-section-icon {
    font-size: 1.6rem;
    filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.8));
}

.rpg-section-content {
    padding: 2rem;
    color: #e2e8f0;
    line-height: 1.7;
}

.rpg-content-title {
    font-size: 1.3rem;
    color: #4ade80;
    font-weight: bold;
    margin-bottom: 1rem;
    margin-top: 1.5rem;
    text-shadow: 0 0 8px rgba(74, 222, 128, 0.6);
}

.rpg-content-title:first-child {
    margin-top: 0;
}

.rpg-content-text {
    color: #cbd5e1;
    margin-bottom: 1.25rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
    font-size: 1.05rem;
}

.rpg-content-list {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1.5rem;
}

.rpg-content-list li {
    color: #e2e8f0;
    padding: 0.5rem 0;
    padding-left: 1.5rem;
    position: relative;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.rpg-content-list li::before {
    content: '⚡';
    position: absolute;
    left: 0;
    color: #fbbf24;
    font-weight: bold;
    text-shadow: 0 0 8px rgba(251, 191, 36, 0.8);
}

/* Table of Contents */
.rpg-toc {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.rpg-toc-link {
    display: block;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.8));
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 12px;
    color: #60a5fa;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    font-weight: 500;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
}

.rpg-toc-link:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.2));
    border-color: rgba(96, 165, 250, 0.6);
    color: #93c5fd;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    text-shadow: 0 0 8px rgba(147, 197, 253, 0.8);
}

/* Special Content Boxes */
.rpg-highlight-box {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15), rgba(147, 51, 234, 0.15));
    border: 2px solid rgba(168, 85, 247, 0.4);
    border-radius: 15px;
    padding: 1.5rem;
    margin: 1.5rem 0;
    backdrop-filter: blur(10px);
}

.rpg-highlight-title {
    color: #a78bfa;
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
    text-shadow: 0 0 8px rgba(167, 139, 250, 0.6);
}

.rpg-feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.rpg-feature-card {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.9));
    border: 2px solid rgba(34, 197, 94, 0.3);
    border-radius: 15px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.rpg-feature-card:hover {
    border-color: rgba(34, 197, 94, 0.6);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(34, 197, 94, 0.2);
}

.rpg-feature-card h6 {
    color: #4ade80;
    font-weight: bold;
    margin-bottom: 0.75rem;
    text-shadow: 0 0 8px rgba(74, 222, 128, 0.6);
}

/* Badges and Status */
.rpg-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: bold;
    margin: 0.25rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.rpg-badge-danger { background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; }
.rpg-badge-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.rpg-badge-success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.rpg-badge-info { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.rpg-badge-purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

/* Responsive Design */
@media (max-width: 768px) {
    .rpg-main-title {
        font-size: 2.5rem;
    }
    
    .rpg-section-title {
        font-size: 1.5rem;
    }
    
    .rpg-toc {
        grid-template-columns: 1fr;
    }
    
    .rpg-feature-grid {
        grid-template-columns: 1fr;
    }
    
    .rpg-section-content {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .rpg-main-title {
        font-size: 2rem;
    }
    
    .rpg-guide-container {
        padding: 1rem 0;
    }
    
    .rpg-main-header {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
}
</style>

<!-- RPG Guide World -->
<div class="rpg-guide-world">
    <div class="container">
        <div class="rpg-guide-container">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">
                    
                    <!-- Main Header -->
                    <div class="rpg-main-header">
                        <h1 class="rpg-main-title">
                            {{ __('nav.game_guide') }}
                        </h1>
                        <p class="rpg-main-subtitle">{{ __('nav.complete_walkthrough') }}</p>
                        <div class="rpg-intro-message">
                            {{ __('nav.guide_intro') }}
                        </div>
                    </div>

                    <!-- Table of Contents -->
                    <div class="rpg-guide-section">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">📋</span>
                                {{ __('nav.table_of_contents') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <div class="rpg-toc">
                                <a href="#basic-gameplay" class="rpg-toc-link">1. {{ __('nav.basic_gameplay') }}</a>
                                <a href="#treasure-mechanics" class="rpg-toc-link">2. {{ __('nav.treasure_mechanics') }}</a>
                                <a href="#class-system" class="rpg-toc-link">3. {{ __('nav.class_system') }}</a>
                                <a href="#upgrade-system" class="rpg-toc-link">4. {{ __('nav.upgrade_system') }}</a>
                                <a href="#gambling-hall" class="rpg-toc-link">5. {{ __('nav.gambling_hall') }}</a>
                                <a href="#random-boxes" class="rpg-toc-link">6. {{ __('nav.random_boxes') }}</a>
                                <a href="#day-night-cycle" class="rpg-toc-link">7. {{ __('nav.day_night_cycle') }}</a>
                                <a href="#pvp-system" class="rpg-toc-link">8. {{ __('nav.pvp_system') }}</a>
                                <a href="#auto-systems" class="rpg-toc-link">9. {{ __('nav.auto_systems') }}</a>
                                <a href="#tips-strategies" class="rpg-toc-link">10. {{ __('nav.tips_strategies') }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- 1. Basic Gameplay -->
                    <div class="rpg-guide-section" id="basic-gameplay">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🎮</span>
                                1. {{ __('nav.basic_gameplay') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="rpg-content-title">{{ __('nav.getting_started') }}</h5>
                                    <p class="rpg-content-text">{{ __('nav.getting_started_desc') }}</p>
                                    
                                    <h5 class="rpg-content-title">{{ __('nav.earning_money') }}</h5>
                                    <p class="rpg-content-text">{{ __('nav.earning_money_desc') }}</p>
                                    
                                    <h5 class="rpg-content-title">{{ __('nav.treasure_regeneration') }}</h5>
                                    <p class="rpg-content-text">{{ __('nav.treasure_regeneration_desc') }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">{{ __('nav.how_to_play') }}</h6>
                                        <ol class="rpg-content-list">
                                            <li>{{ __('nav.register_and_login') }}</li>
                                            <li>{{ __('nav.open_treasures') }}</li>
                                            <li>{{ __('nav.choose_class_level_4') }}</li>
                                            <li>{{ __('nav.upgrade_abilities') }}</li>
                                            <li>{{ __('nav.compete_leaderboards') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Treasure Mechanics -->
                    <div class="rpg-guide-section" id="treasure-mechanics">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">💎</span>
                                2. {{ __('nav.treasure_mechanics_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="rpg-content-title">{{ __('nav.treasure_capacity') }}</h5>
                                    <p class="rpg-content-text">{{ __('nav.treasure_capacity_desc') }}</p>
                                    <ul class="rpg-content-list">
                                        <li>{{ __('nav.base_capacity') }}: 20 {{ __('nav.treasure') }}</li>
                                        <li>{{ __('nav.treasure_multiplier') }}: +5 {{ __('nav.capacity') }}/{{ __('nav.level') }}</li>
                                        <li>{{ __('nav.efficiency_bonus') }}: {{ __('nav.chance_to_save_treasure') }}</li>
                                    </ul>
                                    
                                    <h5 class="rpg-content-title">{{ __('nav.treasure_regeneration') }}</h5>
                                    <p class="rpg-content-text">{{ __('nav.treasure_regeneration_desc') }}</p>
                                    <ul class="rpg-content-list">
                                        <li>{{ __('nav.base_interval') }}: 60 {{ __('nav.minutes') }}</li>
                                        <li>{{ __('nav.regeneration_amount') }}: +5 {{ __('nav.treasure') }}</li>
                                        <li>{{ __('nav.fast_recovery_upgrade') }}: -5 {{ __('nav.minutes') }}/{{ __('nav.level') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="rpg-content-title">{{ __('nav.treasure_types') }}</h5>
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">{{ __('nav.regular_treasures') }}</h6>
                                        <p class="rpg-content-text">{{ __('nav.regular_treasures_desc') }}</p>
                                        <div class="d-flex flex-wrap mb-2">
                                            <span class="rpg-badge rpg-badge-info">{{ __('nav.common') }}</span>
                                            <span class="rpg-badge rpg-badge-success">{{ __('nav.uncommon') }}</span>
                                            <span class="rpg-badge rpg-badge-info">{{ __('nav.rare') }}</span>
                                        </div>
                                        <div class="d-flex flex-wrap mb-3">
                                            <span class="rpg-badge rpg-badge-purple">{{ __('nav.epic') }}</span>
                                            <span class="rpg-badge rpg-badge-warning">{{ __('nav.legendary') }}</span>
                                            <span class="rpg-badge rpg-badge-info">{{ __('nav.mythical') }}</span>
                                            <span class="rpg-badge rpg-badge-danger">{{ __('nav.divine') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">{{ __('gambling.rare_treasure') }} {{ __('nav.system') }}</h6>
                                        <p class="rpg-content-text">{{ __('nav.rare_treasure_desc') }}</p>
                                        <ul class="rpg-content-list">
                                            <li>{{ __('nav.value') }}: 5-6x {{ __('nav.normal_treasure') }}</li>
                                            <li>{{ __('nav.source') }}: {{ __('gambling.treasure_fusion') }}</li>
                                            <li>{{ __('nav.fusion_cost') }}: 3 {{ __('nav.treasure') }} + IDR 1,000</li>
                                            <li>{{ __('gambling.success_rate') }}: 50%</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Class System -->
                    <div class="rpg-guide-section" id="class-system">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🌳</span>
                                3. {{ __('nav.class_system_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.choosing_class') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.choosing_class_desc') }}</p>
                            
                            <h5 class="rpg-content-title">{{ __('nav.available_classes') }}</h5>
                            <div class="rpg-feature-grid">
                                <div class="rpg-feature-card">
                                    <h6>⚒️ {{ __('nav.treasure_hunter') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.treasure_hunter_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>💰 {{ __('nav.proud_merchant') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.proud_merchant_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>🎰 {{ __('nav.fortune_gambler') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.fortune_gambler_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>🌙 {{ __('nav.moon_guardian') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.moon_guardian_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>☀️ {{ __('nav.day_breaker') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.day_breaker_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>📦 {{ __('nav.box_collector') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.box_collector_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>📜 {{ __('nav.divine_scholar') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.divine_scholar_guide') }}</p>
                                </div>
                            </div>
                            
                            <div class="rpg-highlight-box">
                                <h6 class="rpg-highlight-title">{{ __('nav.class_advancement') }}</h6>
                                <p class="rpg-content-text">{{ __('nav.class_advancement_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Upgrade System -->
                    <div class="rpg-guide-section" id="upgrade-system">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🏪</span>
                                4. {{ __('nav.upgrade_system_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.visiting_store') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.visiting_store_desc') }}</p>
                            
                            <h5 class="rpg-content-title">{{ __('nav.available_upgrades') }}</h5>
                            <div class="rpg-feature-grid">
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-danger">{{ __('nav.auto_steal') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.auto_steal_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-warning">{{ __('nav.auto_earning') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.auto_earning_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-info">{{ __('nav.shield_protection') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.shield_protection_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-warning">{{ __('nav.treasure_multiplier') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.treasure_multiplier_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-success">{{ __('nav.lucky_strikes') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.lucky_strikes_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-danger">{{ __('nav.counter_attack') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.counter_attack_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-purple">{{ __('nav.intimidation') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.intimidation_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-info">{{ __('nav.fast_recovery') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.fast_recovery_guide') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6><span class="rpg-badge rpg-badge-purple">{{ __('nav.treasure_rarity') }}</span></h6>
                                    <p class="rpg-content-text">{{ __('nav.treasure_rarity_guide') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Gambling Hall -->
                    <div class="rpg-guide-section" id="gambling-hall">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🎲</span>
                                5. {{ __('nav.gambling_hall') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.gambling_overview') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.gambling_overview_desc') }}</p>
                            
                            <div class="rpg-feature-grid">
                                <div class="rpg-feature-card">
                                    <h6>🎲 {{ __('gambling.dice_duel') }}</h6>
                                    <p class="rpg-content-text">{{ __('gambling.dice_duel_desc') }}</p>
                                    <ul class="rpg-content-list">
                                        <li>{{ __('nav.bet_range') }}: IDR 3,000 - {{ __('nav.level_based') }}</li>
                                        <li>{{ __('nav.win_rate') }}: ~45%</li>
                                        <li>{{ __('nav.payout') }}: 2x {{ __('nav.bet_amount') }}</li>
                                    </ul>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>✨ {{ __('gambling.treasure_fusion') }}</h6>
                                    <p class="rpg-content-text">{{ __('gambling.treasure_fusion_desc') }}</p>
                                    <ul class="rpg-content-list">
                                        <li>{{ __('gambling.cost') }}: 3 {{ __('nav.treasure') }} + IDR 1,000</li>
                                        <li>{{ __('gambling.success_rate') }}: 50%</li>
                                        <li>{{ __('gambling.reward') }}: 1 {{ __('gambling.rare_treasure') }}</li>
                                    </ul>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>🃏 {{ __('gambling.card_flip') }}</h6>
                                    <p class="rpg-content-text">{{ __('gambling.card_flip_desc') }}</p>
                                    <ul class="rpg-content-list">
                                        <li>{{ __('nav.bet_range') }}: IDR 3,000 - {{ __('nav.level_based') }}</li>
                                        <li>{{ __('nav.win_rate') }}: ~45%</li>
                                        <li>{{ __('nav.payout') }}: 2x {{ __('nav.bet_amount') }}</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">{{ __('nav.gambling_progression') }}</h6>
                                        <ul class="rpg-content-list">
                                            <li>{{ __('nav.base_attempts') }}: 20/{{ __('nav.day') }}</li>
                                            <li>{{ __('nav.level_bonus') }}: +2 {{ __('nav.attempts') }}/{{ __('nav.level') }}</li>
                                            <li>{{ __('nav.bet_increase') }}: +IDR 1,000/{{ __('nav.level') }}</li>
                                            <li>{{ __('nav.exp_per_game') }}: 10 EXP</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">{{ __('gambling.rare_treasure') }} {{ __('nav.system') }}</h6>
                                        <ul class="rpg-content-list">
                                            <li>{{ __('nav.value') }}: 5-6x {{ __('nav.normal_treasure') }}</li>
                                            <li>{{ __('nav.source') }}: {{ __('gambling.treasure_fusion') }}</li>
                                            <li>{{ __('nav.exp_bonus') }}: 2x {{ __('nav.experience') }}</li>
                                            <li>{{ __('nav.class_bonuses') }}: {{ __('nav.apply') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Random Boxes -->
                    <div class="rpg-guide-section" id="random-boxes">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🎁</span>
                                6. {{ __('nav.random_boxes_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.random_boxes') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.random_boxes_desc') }}</p>
                            
                            <div class="rpg-highlight-box">
                                <h6 class="rpg-highlight-title">{{ __('nav.box_mechanics') }}</h6>
                                <ul class="rpg-content-list">
                                    <li>{{ __('nav.box_chance_based_on_rarity') }}</li>
                                    <li>{{ __('nav.higher_rarity_better_rewards') }}</li>
                                    <li>{{ __('nav.boxes_contain_money_treasures') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Day/Night Cycle -->
                    <div class="rpg-guide-section" id="day-night-cycle">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🌙</span>
                                7. {{ __('nav.day_night_cycle_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.day_night_mechanics') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.day_night_mechanics_desc') }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">☀️ {{ __('nav.day_time') }}</h6>
                                        <ul class="rpg-content-list">
                                            <li>{{ __('nav.normal_treasure_rates') }}</li>
                                            <li>{{ __('nav.standard_steal_protection') }}</li>
                                            <li>{{ __('nav.regular_money_earning') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rpg-highlight-box">
                                        <h6 class="rpg-highlight-title">🌙 {{ __('nav.night_time') }}</h6>
                                        <ul class="rpg-content-list">
                                            <li>{{ __('nav.increased_steal_success') }}</li>
                                            <li>{{ __('nav.reduced_protection') }}</li>
                                            <li>{{ __('nav.higher_risk_reward') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 8. PvP System -->
                    <div class="rpg-guide-section" id="pvp-system">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">⚔️</span>
                                8. {{ __('nav.pvp_system_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.steal_mechanics') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.steal_mechanics_desc') }}</p>
                            
                            <div class="rpg-highlight-box">
                                <h6 class="rpg-highlight-title">{{ __('nav.steal_system') }}</h6>
                                <ul class="rpg-content-list">
                                    <li>{{ __('nav.target_other_players') }}</li>
                                    <li>{{ __('nav.success_based_on_levels') }}</li>
                                    <li>{{ __('nav.protection_mechanisms') }}</li>
                                    <li>{{ __('nav.counter_attack_system') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Auto Systems -->
                    <div class="rpg-guide-section" id="auto-systems">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">🤖</span>
                                9. {{ __('nav.auto_systems_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.automation_features') }}</h5>
                            <p class="rpg-content-text">{{ __('nav.automation_features_desc') }}</p>
                            
                            <div class="rpg-feature-grid">
                                <div class="rpg-feature-card">
                                    <h6>🏃 {{ __('nav.auto_earning') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.auto_earning_detailed') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>🎯 {{ __('nav.auto_steal') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.auto_steal_detailed') }}</p>
                                </div>
                                <div class="rpg-feature-card">
                                    <h6>🕰️ {{ __('nav.scheduled_actions') }}</h6>
                                    <p class="rpg-content-text">{{ __('nav.scheduled_actions_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Tips & Strategies -->
                    <div class="rpg-guide-section" id="tips-strategies">
                        <div class="rpg-section-header">
                            <h3 class="rpg-section-title">
                                <span class="rpg-section-icon">💡</span>
                                10. {{ __('nav.tips_strategies_title') }}
                            </h3>
                        </div>
                        <div class="rpg-section-content">
                            <h5 class="rpg-content-title">{{ __('nav.beginner_tips') }}</h5>
                            <div class="rpg-highlight-box">
                                <ul class="rpg-content-list">
                                    <li>{{ __('nav.tip_focus_treasures_early') }}</li>
                                    <li>{{ __('nav.tip_choose_class_wisely') }}</li>
                                    <li>{{ __('nav.tip_upgrade_systematically') }}</li>
                                    <li>{{ __('nav.tip_balance_risk_reward') }}</li>
                                </ul>
                            </div>
                            
                            <h5 class="rpg-content-title">{{ __('nav.advanced_strategies') }}</h5>
                            <div class="rpg-highlight-box">
                                <ul class="rpg-content-list">
                                    <li>{{ __('nav.strategy_timing_matters') }}</li>
                                    <li>{{ __('nav.strategy_class_synergy') }}</li>
                                    <li>{{ __('nav.strategy_resource_management') }}</li>
                                    <li>{{ __('nav.strategy_community_interaction') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection