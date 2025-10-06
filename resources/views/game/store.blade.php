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
            <div class="row g-3">
                
                <!-- 1. AUTO STEAL -->
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-danger text-white text-center py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="fas fa-mask me-1"></i>Auto Steal
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#autoStealInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->steal_level }} / {{ $maxStealLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="autoStealInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Auto Steal:</strong> Automatically attempts to steal from other players when you earn money. Higher levels increase success rate and steal amount.
                                    @if ($user->steal_level < $maxStealLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->steal_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Success Rate: {{ ($user->steal_level + 1) * 5 }}%</li>
                                            <li>Steal Amount: {{ min(1 + (($user->steal_level + 1) * 0.8), 5) }}% max</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->steal_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Success:</strong> {{ $user->steal_level * 5 }}%</div>
                                    <div><strong>Amount:</strong> {{ min(1 + ($user->steal_level * 0.8), 5) }}% max</div>
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
                                        <span class="badge bg-danger small">MAX LEVEL</span>
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
                                <i class="fas fa-robot me-1"></i>Auto Earning
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#autoEarningInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->auto_earning_level }} / {{ $maxAutoEarningLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="autoEarningInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Auto Earning:</strong> Generates passive income every hour based on your total money. Works even when offline. No treasure required.
                                    @if ($user->auto_earning_level < $maxAutoEarningLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->auto_earning_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Rate: {{ ($user->auto_earning_level + 1) * 0.05 }}% per hour</li>
                                            <li>Hourly Income: IDR {{ number_format($user->money_earned * (($user->auto_earning_level + 1) * 0.05 / 100), 0, ',', '.') }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->auto_earning_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Rate:</strong> {{ $user->auto_earning_level * 0.05 }}%/hour</div>
                                    <div><strong>Hourly:</strong> IDR {{ number_format($user->money_earned * ($user->auto_earning_level * 0.05 / 100), 0, ',', '.') }}</div>
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
                                        <span class="badge bg-warning text-dark small">MAX LEVEL</span>
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
                                <i class="fas fa-shield-alt me-1"></i>Shield Protection
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#shieldInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>
                                @if ($isShieldActive)
                                    <span class="text-warning">ACTIVE</span>
                                @else
                                    <span class="text-light">INACTIVE</span>
                                @endif
                            </small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="shieldInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Shield Protection:</strong> Protects you from theft for {{ $shieldDurationHours }} hours. Blocks all steal attempts while active.
                                    @if (!$isShieldActive)
                                        <hr class="my-2">
                                        <strong>Benefits:</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>{{ $shieldDurationHours }} hours protection</li>
                                            <li>Blocks all theft attempts</li>
                                            <li>Peace of mind</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($isShieldActive)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">PROTECTED</span>
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
                                        <span class="badge bg-info small">ACTIVE</span>
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
                                <i class="fas fa-gem me-1"></i>Treasure Multiplier
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#treasureMultiplierInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->treasure_multiplier_level }} / {{ $maxTreasureMultiplierLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="treasureMultiplierInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Treasure Multiplier:</strong> Increases your treasure capacity and provides treasure efficiency bonus.
                                    @if ($user->treasure_multiplier_level < $maxTreasureMultiplierLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->treasure_multiplier_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Capacity: {{ 20 + (($user->treasure_multiplier_level + 1) * 5) }} treasure max</li>
                                            <li>Efficiency: {{ ($user->treasure_multiplier_level + 1) * 2 }}% chance to save treasure</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_multiplier_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Capacity:</strong> {{ 20 + ($user->treasure_multiplier_level * 5) }}</div>
                                    <div><strong>Efficiency:</strong> {{ $user->treasure_multiplier_level * 2 }}%</div>
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
                                        <span class="badge bg-warning text-dark small">MAX LEVEL</span>
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
                                <i class="fas fa-star me-1"></i>Lucky Strikes
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#luckyStrikesInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->lucky_strikes_level }} / {{ $maxLuckyStrikesLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="luckyStrikesInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Lucky Strikes:</strong> Chance to double ALL money earned from treasure opening AND auto-stealing. Pure profit multiplier!
                                    @if ($user->lucky_strikes_level < $maxLuckyStrikesLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->lucky_strikes_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Lucky Chance: {{ ($user->lucky_strikes_level + 1) * 2 }}%</li>
                                            <li>2x money on earning AND stealing</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->lucky_strikes_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Lucky Chance:</strong> {{ $user->lucky_strikes_level * 2 }}%</div>
                                    <div><strong>Bonus:</strong> 2x Money</div>
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
                                        <span class="badge bg-success small">MAX LEVEL</span>
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
                                <i class="fas fa-shield-alt me-1"></i>Counter-Attack
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#counterAttackInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->counter_attack_level }} / {{ $maxCounterAttackLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="counterAttackInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Counter-Attack:</strong> Automatically retaliate when someone steals from you. Steal back from attackers!
                                    @if ($user->counter_attack_level < $maxCounterAttackLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->counter_attack_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Counter Chance: {{ ($user->counter_attack_level + 1) * 20 }}%</li>
                                            <li>Steal back {{ min(0.5 + (($user->counter_attack_level + 1) * 0.5), 3) }}% of attacker's money</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->counter_attack_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Counter Chance:</strong> {{ $user->counter_attack_level * 20 }}%</div>
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
                                        <span class="badge bg-dark small">MAX LEVEL</span>
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
                                <i class="fas fa-skull me-1"></i>Intimidation
                                <button class="btn btn-link text-dark p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#intimidationInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->intimidation_level }} / {{ $maxIntimidationLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="intimidationInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Intimidation:</strong> Reduces others' steal success rate against you. Strike fear into attackers!
                                    @if ($user->intimidation_level < $maxIntimidationLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->intimidation_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Steal Reduction: {{ ($user->intimidation_level + 1) * 2 }}%</li>
                                            <li>Greater defensive presence</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->intimidation_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    <div><strong>Steal Reduction:</strong> {{ $user->intimidation_level * 2 }}%</div>
                                    <div><strong>Effect:</strong> Intimidates attackers</div>
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
                                        <span class="badge bg-warning text-dark small">MAX LEVEL</span>
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
                                <i class="fas fa-clock-rotate-left me-1"></i>Fast Recovery
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#fastRecoveryInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->fast_recovery_level }} / {{ $maxFastRecoveryLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="fastRecoveryInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Fast Recovery:</strong> Speeds up treasure regeneration for faster resource gathering. Reduce waiting time between treasure spawns!
                                    @if ($user->fast_recovery_level < $maxFastRecoveryLevel)
                                        <hr class="my-2">
                                        <strong>Next Level ({{ $user->fast_recovery_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            @php
                                                $intervals = [60, 55, 50, 45, 40, 30];
                                                $nextInterval = $intervals[$user->fast_recovery_level + 1];
                                            @endphp
                                            <li>Regeneration: Every {{ $nextInterval }} minutes</li>
                                            <li>Faster treasure collection</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->fast_recovery_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    @php
                                        $intervals = [60, 55, 50, 45, 40, 30];
                                        $currentInterval = $intervals[$user->fast_recovery_level];
                                    @endphp
                                    <div><strong>Speed:</strong> {{ $currentInterval }} min intervals</div>
                                    <div><strong>Effect:</strong> Faster treasure regen</div>
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
                                            <i class="fas fa-crown me-1"></i>MAX LEVEL
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
                                <i class="fas fa-gem me-1"></i>Treasure Rarity
                                <button class="btn btn-link text-white p-0 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#treasureRarityInfo" aria-expanded="false">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </h6>
                            <small>Level {{ $user->treasure_rarity_level }} / {{ $maxTreasureRarityLevel }}</small>
                        </div>
                        <div class="card-body p-2">
                            <div class="collapse" id="treasureRarityInfo">
                                <div class="alert alert-info p-2 mb-2 small">
                                    <strong>Treasure Rarity:</strong> Upgrade your treasure rarity to get a chance for Random Boxes when opening treasures! Higher rarity levels give better chances.
                                    @if ($user->treasure_rarity_level < $maxTreasureRarityLevel)
                                        <hr class="my-2">
                                        @php
                                            $rarityNames = \App\Models\User::getTreasureRarityNames();
                                            $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                            $nextRarityName = $rarityNames[$user->treasure_rarity_level + 1] ?? 'Ultimate';
                                            $nextChance = $rarityChances[$user->treasure_rarity_level + 1] ?? 19;
                                        @endphp
                                        <strong>Next Level ({{ $user->treasure_rarity_level + 1 }}):</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            <li>Rarity: {{ $nextRarityName }}</li>
                                            <li>Random Box Chance: {{ $nextChance }}%</li>
                                            <li>Better treasure rewards</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($user->treasure_rarity_level > 0)
                                <div class="text-center mb-2">
                                    <span class="badge bg-success small">OWNED</span>
                                </div>
                                <div class="small text-center">
                                    @php
                                        $rarityNames = \App\Models\User::getTreasureRarityNames();
                                        $rarityChances = [0, 5, 7, 9, 11, 13, 15, 17];
                                        $currentRarityName = $rarityNames[$user->treasure_rarity_level] ?? 'Ultimate';
                                        $currentChance = $rarityChances[$user->treasure_rarity_level] ?? 0;
                                    @endphp
                                    <div><strong>Type:</strong> {{ $currentRarityName }}</div>
                                    <div><strong>Random Box:</strong> {{ $currentChance }}% chance</div>
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
                                            <i class="fas fa-crown me-1"></i>MAX LEVEL
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
                    <i class="fas fa-arrow-left me-2"></i>Back to Game
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
