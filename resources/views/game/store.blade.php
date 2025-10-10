@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h1 class="display-4 fw-bold text-dark text-center mb-5">
                <i class="fas fa-store me-3 text-primary"></i>{{ __('nav.game_store') }}
            </h1>

            <!-- Status Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">{{ __('nav.success') }}</p>
                    <p class="mb-0">{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <p class="mb-0 fw-bold">{{ __('nav.error') }}</p>
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
                                <i class="fas fa-wallet me-2"></i>{{ __('nav.your_money') }}
                            </h3>
                            <h2 class="display-5 fw-bold text-dark">
                                IDR {{ number_format($user->money_earned, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Items -->
            <div class="row g-3">
                
                <!-- 1. AUTO STEAL -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-danger text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-mask me-1"></i>{{ __('nav.auto_steal') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#autoStealInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->steal_level, 'max' => $maxStealLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="autoStealInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.auto_steal') }}:</strong> {{ __('nav.auto_steal_description') }}
                                    @if ($user->steal_level < $maxStealLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->steal_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.success_rate') }}: {{ ($user->steal_level + 1) * 5 }}%</li>
                                            <li>{{ __('nav.steal_amount') }}: {{ min(1 + (($user->steal_level + 1) * 0.8), 5) }}% max</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->steal_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.success_rate') }}:</strong> {{ $user->steal_level * 5 }}%</div>
                                    <div><strong>{{ __('nav.steal_amount') }}:</strong> {{ min(1 + ($user->steal_level * 0.8), 5) }}% max</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->steal_level < $maxStealLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.steal') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm w-100 fw-bold @if($user->money_earned < $stealUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $stealUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($stealUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-danger small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. AUTO EARNING -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-warning text-dark text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-robot me-1"></i>{{ __('nav.auto_earning') }}
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#autoEarningInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->auto_earning_level, 'max' => $maxAutoEarningLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="autoEarningInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.auto_earning') }}:</strong> {{ __('nav.auto_earning_description') }}
                                    @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->auto_earning_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.rate_per_hour') }}: {{ ($user->auto_earning_level + 1) * 0.05 }}% per hour</li>
                                            <li>{{ __('nav.hourly_income') }}: IDR {{ number_format($user->money_earned * (($user->auto_earning_level + 1) * 0.05 / 100), 0, ',', '.') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->auto_earning_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.rate_per_hour') }}:</strong> {{ $user->auto_earning_level * 0.05 }}%/hour</div>
                                    <div><strong>{{ __('nav.hourly_income') }}:</strong> IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.05 / 100), 0, ',', '.') }}</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.auto-earning') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-warning btn-sm w-100 fw-bold text-dark @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $autoEarningUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($autoEarningUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-warning text-dark small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. SHIELD PROTECTION -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-info text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-shield-alt me-1"></i>{{ __('nav.shield_protection') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#shieldInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>
                                @if ($isShieldActive)
                                    <span class="text-warning">{{ __('nav.active') }}</span>
                                @else
                                    <span class="text-light">{{ __('nav.inactive') }}</span>
                                @endif
                            </small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="shieldInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.shield_protection') }}:</strong> {{ __('nav.shield_description', ['hours' => $shieldDurationHours]) }}
                                    @if (!$isShieldActive)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.benefits') }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.hours_protection', ['hours' => $shieldDurationHours]) }}</li>
                                            <li>{{ __('nav.blocks_theft') }}</li>
                                            <li>{{ __('nav.peace_of_mind') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($isShieldActive)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.protected') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Expires:</strong></div>
                                    <div id="shieldTimer">{{ $user->shield_expires_at ? $user->shield_expires_at->setTimezone('Asia/Jakarta')->format('M d, H:i') : 'N/A' }}</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if (!$isShieldActive)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.shield') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-info btn-sm w-100 fw-bold text-white @if($user->money_earned < $shieldCost) disabled @endif"
                                                    @if($user->money_earned < $shieldCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($shieldCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-info small">{{ __('nav.active') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. TREASURE MULTIPLIER -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-warning text-dark text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-gem me-1"></i>{{ __('nav.treasure_multiplier') }}
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#treasureMultiplierInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->treasure_multiplier_level, 'max' => $maxTreasureMultiplierLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="treasureMultiplierInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.treasure_multiplier') }}:</strong> {{ __('nav.treasure_multiplier_description') }}
                                    @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->treasure_multiplier_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.capacity') }}: {{ __('nav.treasure_max', ['count' => 20 + (($user->treasure_multiplier_level + 1) * 5)]) }}</li>
                                            <li>{{ __('nav.efficiency') }}: {{ __('nav.chance_to_save', ['percent' => ($user->treasure_multiplier_level + 1) * 2]) }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_multiplier_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.capacity') }}:</strong> {{ 20 + ($user->treasure_multiplier_level * 5) }}</div>
                                    <div><strong>{{ __('nav.efficiency') }}:</strong> {{ $user->treasure_multiplier_level * 2 }}%</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.treasure-multiplier') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-warning btn-sm w-100 fw-bold text-dark @if($user->money_earned < $treasureMultiplierUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $treasureMultiplierUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($treasureMultiplierUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-warning text-dark small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. LUCKY STRIKES -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-success text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-star me-1"></i>{{ __('nav.lucky_strikes') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#luckyStrikesInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->lucky_strikes_level, 'max' => $maxLuckyStrikesLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="luckyStrikesInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.lucky_strikes') }}:</strong> {{ __('nav.lucky_chance_detailed') }}
                                    @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->lucky_strikes_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.lucky_chance') }}: {{ ($user->lucky_strikes_level + 1) * 2 }}%</li>
                                            <li>{{ __('nav.double_money_earning') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->lucky_strikes_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.lucky_chance') }}:</strong> {{ $user->lucky_strikes_level * 2 }}%</div>
                                    <div><strong>{{ __('nav.bonus') }}:</strong> 2x Money</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.lucky-strikes') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-success btn-sm w-100 fw-bold @if($user->money_earned < $luckyStrikesUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $luckyStrikesUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($luckyStrikesUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-success small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. COUNTER-ATTACK -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-dark text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-shield-alt me-1"></i>{{ __('nav.counter_attack') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#counterAttackInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->counter_attack_level, 'max' => $maxCounterAttackLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="counterAttackInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.counter_attack') }}:</strong> {{ __('nav.counter_attack_detailed') }}
                                    @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->counter_attack_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.counter_chance') }}: {{ ($user->counter_attack_level + 1) * 20 }}%</li>
                                            <li>{{ __('nav.steal_back', ['percent' => min(0.5 + (($user->counter_attack_level + 1) * 0.5), 3)]) }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->counter_attack_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.counter_chance') }}:</strong> {{ $user->counter_attack_level * 20 }}%</div>
                                    <div><strong>Steal Back:</strong> {{ min(0.5 + ($user->counter_attack_level * 0.5), 3) }}% max</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.counter-attack') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-dark btn-sm w-100 fw-bold @if($user->money_earned < $counterAttackUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $counterAttackUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($counterAttackUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-dark small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. INTIMIDATION -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-warning text-dark text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-skull me-1"></i>{{ __('nav.intimidation') }}
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#intimidationInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->intimidation_level, 'max' => $maxIntimidationLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="intimidationInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.intimidation') }}:</strong> {{ __('nav.intimidation_detailed') }}
                                    @if ($user->intimidation_level < $maxIntimidationLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->intimidation_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.steal_reduction') }}: {{ ($user->intimidation_level + 1) * 2 }}%</li>
                                            <li>{{ __('nav.greater_defensive') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->intimidation_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>{{ __('nav.steal_reduction') }}:</strong> {{ $user->intimidation_level * 2 }}%</div>
                                    <div><strong>{{ __('nav.effect') }}:</strong> {{ __('nav.intimidates_attackers') }}</div>
                                </div>
                            @endif
                            <div class="mt-auto">
                                @if ($user->intimidation_level < $maxIntimidationLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.intimidation') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-warning btn-sm w-100 fw-bold @if($user->money_earned < $intimidationUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $intimidationUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($intimidationUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-warning text-dark small">{{ __('nav.max_level') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 8. FAST RECOVERY -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-primary text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-clock-rotate-left me-1"></i>{{ __('nav.fast_recovery') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#fastRecoveryInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->fast_recovery_level, 'max' => $maxFastRecoveryLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="fastRecoveryInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.fast_recovery') }}:</strong> {{ __('nav.fast_recovery_detailed') }}
                                    @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                        <hr class="my-2">
                                        <strong>{{ __('nav.next_level', ['level' => $user->fast_recovery_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            @php
                                                $intervals = [60, 55, 50, 45, 40, 30];
                                                $nextInterval = $intervals[$user->fast_recovery_level + 1];
                                            @endphp
                                            <li>{{ __('nav.regeneration') }}: {{ __('nav.every_minutes', ['minutes' => $nextInterval]) }}</li>
                                            <li>{{ __('nav.faster_collection') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->fast_recovery_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    @php
                                        $intervals = [60, 55, 50, 45, 40, 30];
                                        $currentInterval = $intervals[$user->fast_recovery_level];
                                    @endphp
                                    <div><strong>{{ __('nav.speed') }}:</strong> {{ __('nav.min_intervals', ['minutes' => $currentInterval]) }}</div>
                                    <div><strong>{{ __('nav.effect') }}:</strong> {{ __('nav.faster_regen') }}</div>
                                </div>
                            @endif
                            
                            <div class="mt-auto">
                                @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.fast-recovery') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-primary btn-sm w-100 fw-bold @if($user->money_earned < $fastRecoveryUpgradeCost) disabled @endif"
                                                    @if($user->money_earned < $fastRecoveryUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($fastRecoveryUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge bg-primary small">
                                            <i class="fas fa-crown me-1"></i>{{ __('nav.max_level') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 9. TREASURE RARITY -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header text-white text-center py-2" style="background: linear-gradient(45deg, #6f42c1, #e83e8c);">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-gem me-1"></i>{{ __('nav.treasure_rarity') }}
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#treasureRarityInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>{{ __('nav.level_max', ['current' => $user->treasure_rarity_level, 'max' => $maxTreasureRarityLevel]) }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="treasureRarityInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>{{ __('nav.treasure_rarity') }}:</strong> {{ __('nav.treasure_rarity_detailed') }}
                                    @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                        <hr class="my-2">
                                        @php
                                            $rarityNames = \App\Models\User::getTreasureRarityNames();
                                            $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                            $nextRarityName = $rarityNames[$user->treasure_rarity_level + 1] ?? 'Ultimate';
                                            $nextChance = $rarityChances[$user->treasure_rarity_level + 1] ?? 19;
                                        @endphp
                                        <strong>{{ __('nav.next_level', ['level' => $user->treasure_rarity_level + 1]) }}:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ __('nav.rarity') }}: {{ $nextRarityName }}</li>
                                            <li>{{ __('nav.random_box_chance') }}: {{ $nextChance }}%</li>
                                            <li>{{ __('nav.better_rewards') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_rarity_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">{{ __('nav.owned') }}</span>
                                </div>
                                <div class="small text-center">
                                    @php
                                        $rarityNames = \App\Models\User::getTreasureRarityNames();
                                        $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                        $currentRarityName = $rarityNames[$user->treasure_rarity_level] ?? 'Ultimate';
                                        $currentChance = $rarityChances[$user->treasure_rarity_level] ?? 0;
                                    @endphp
                                    <div><strong>{{ __('nav.type') }}:</strong> {{ $currentRarityName }}</div>
                                    <div><strong>{{ __('nav.random_box') }}:</strong> {{ $currentChance }}% {{ __('nav.chance') }}</div>
                                </div>
                            @endif
                            
                            <div class="mt-auto">
                                @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                    <div class="text-center">
                                        <form method="POST" action="{{ route('store.purchase.treasure-rarity') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm w-100 fw-bold @if($user->money_earned < $treasureRarityUpgradeCost) disabled @endif"
                                                    style="background: linear-gradient(45deg, #6f42c1, #e83e8c); color: white; border: none;"
                                                    @if($user->money_earned < $treasureRarityUpgradeCost) disabled @endif>
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                IDR {{ number_format($treasureRarityUpgradeCost, 0, ',', '.') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="badge small" style="background: linear-gradient(45deg, #6f42c1, #e83e8c); color: white;">
                                            <i class="fas fa-crown me-1"></i>{{ __('nav.max_level') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Game Button -->
            <div class="text-center mt-4">
                <a href="{{ route('game.dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('nav.back_to_game') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Compact store design with mobile responsiveness */
.card-header {
    font-size: 0.9rem;
}

.card-body {
    font-size: 0.85rem;
}

.card-header h6 {
    font-size: 0.9rem;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
}

.small {
    font-size: 0.8rem !important;
}

/* Ensure proper spacing on mobile */
@media (max-width: 576px) {
    .card-header {
        padding: 0.5rem 1rem;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Info button styling */
.btn-link {
    border: none !important;
    text-decoration: none !important;
}

.btn-link:hover {
    color: rgba(255, 255, 255, 0.8) !important;
}

/* Alert styling for descriptions */
.alert-info {
    background-color: #e7f3ff;
    border-color: #b8daff;
    color: #055160;
    font-size: 0.8rem;
}

/* Disabled button styling */
.btn:disabled, .btn.disabled {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
    pointer-events: none !important;
}

.btn:disabled:hover, .btn.disabled:hover {
    transform: none !important;
    box-shadow: none !important;
}
</style>
@endsection
