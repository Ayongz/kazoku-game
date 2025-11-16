<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'randombox',
        'opened_randomboxes',
        'selected_class',
        'has_advanced_class',
        'class_selected_at',
        'prestige_level',
        // Game fields
        'money_earned',
        'treasure',
        'level',
        'experience',
        'steal_level',
        'auto_earning_level',
        'treasure_multiplier_level',
        'lucky_strikes_level',
        'counter_attack_level',
        'intimidation_level',
        'fast_recovery_level',
        'treasure_rarity_level',
        'shield',
        'shield_expires_at',
        'last_shield_use',
        // Gambling fields
        'gambling_level',
        'gambling_exp',
        'gambling_attempts_today',
        'last_gambling_reset',
        'rare_treasures',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'shield_expires_at' => 'datetime',
            'class_selected_at' => 'datetime',
            'last_gambling_reset' => 'datetime',
        ];
    }

    /**
     * Get the user's inventory.
     */
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    /**
     * Get the user's player logs.
     */
    public function playerLogs()
    {
        return $this->hasMany(PlayerLog::class);
    }

    /**
     * Get random box chance based on treasure rarity level
     */
    public function getRandomBoxChance(): int
    {
        $chances = [
            0 => 0,  // Common - no chance
            1 => 5,  // Uncommon - 5%
            2 => 7,  // Rare - 7%
            3 => 9,  // Epic - 9%
            4 => 11, // Legendary - 11%
            5 => 13, // Mythic - 13%
            6 => 15, // Divine - 15%
            7 => 17, // Celestial - 17%
        ];

        return $chances[$this->treasure_rarity_level] ?? 0;
    }

    /**
     * Check if user gets a random box based on treasure rarity
     */
    public function rollForRandomBox(): bool
    {
        $chance = $this->getRandomBoxChance();
        if ($chance <= 0) {
            return false;
        }

        return rand(1, 100) <= $chance;
    }

    /**
     * Get treasure rarity names array
     */
    public static function getTreasureRarityNames(): array
    {
        return ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Divine', 'Celestial'];
    }

    /**
     * Get available classes for player
     */
    public static function getAvailableClasses(): array
    {
        return [
            'treasure_hunter' => [
                'name' => 'Treasure Hunter',
                'icon' => '🗝️',
                'description' => __('classes.treasure_hunter.description'),
                'abilities' => [
                    __('classes.treasure_hunter.ability_1'),
                    __('classes.treasure_hunter.ability_2')
                ],
                'advanced_name' => 'Master Treasure Hunter',
                'advanced_description' => __('classes.treasure_hunter.advanced_description'),
                'advanced_abilities' => [
                    __('classes.treasure_hunter.advanced_ability_1'),
                    __('classes.treasure_hunter.advanced_ability_2')
                ]
            ],
            'proud_merchant' => [
                'name' => 'Proud Merchant',
                'icon' => '💼',
                'description' => __('classes.proud_merchant.description'),
                'abilities' => [
                    __('classes.proud_merchant.ability_1'),
                    __('classes.proud_merchant.ability_2')
                ],
                'advanced_name' => 'Trade Emperor',
                'advanced_description' => __('classes.proud_merchant.advanced_description'),
                'advanced_abilities' => [
                    __('classes.proud_merchant.advanced_ability_1'),
                    __('classes.proud_merchant.advanced_ability_2')
                ]
            ],
            'fortune_gambler' => [
                'name' => 'Fortune Gambler',
                'icon' => '🎰',
                'description' => __('classes.fortune_gambler.description'),
                'abilities' => [
                    __('classes.fortune_gambler.ability_1'),
                    __('classes.fortune_gambler.ability_2'),
                    __('classes.fortune_gambler.ability_3')
                ],
                'advanced_name' => 'Luck Master',
                'advanced_description' => __('classes.fortune_gambler.advanced_description'),
                'advanced_abilities' => [
                    __('classes.fortune_gambler.advanced_ability_1'),
                    __('classes.fortune_gambler.advanced_ability_2'),
                    __('classes.fortune_gambler.advanced_ability_3')
                ]
            ],
            'moon_guardian' => [
                'name' => 'Moon Guardian',
                'icon' => '🌙',
                'description' => __('classes.moon_guardian.description'),
                'abilities' => [
                    __('classes.moon_guardian.ability_1'),
                    __('classes.moon_guardian.ability_2')
                ],
                'advanced_name' => 'Lunar Master',
                'advanced_description' => __('classes.moon_guardian.advanced_description'),
                'advanced_abilities' => [
                    __('classes.moon_guardian.advanced_ability_1'),
                    __('classes.moon_guardian.advanced_ability_2')
                ]
            ],
            'day_breaker' => [
                'name' => 'Day Breaker',
                'icon' => '☀️',
                'description' => __('classes.day_breaker.description'),
                'abilities' => [
                    __('classes.day_breaker.ability_1'),
                    __('classes.day_breaker.ability_2')
                ],
                'advanced_name' => 'Solar Champion',
                'advanced_description' => __('classes.day_breaker.advanced_description'),
                'advanced_abilities' => [
                    __('classes.day_breaker.advanced_ability_1'),
                    __('classes.day_breaker.advanced_ability_2')
                ]
            ],
            'box_collector' => [
                'name' => 'Box Collector',
                'icon' => '📦',
                'description' => __('classes.box_collector.description'),
                'abilities' => [
                    __('classes.box_collector.ability_1'),
                    __('classes.box_collector.ability_2')
                ],
                'advanced_name' => 'Grand Collector',
                'advanced_description' => __('classes.box_collector.advanced_description'),
                'advanced_abilities' => [
                    __('classes.box_collector.advanced_ability_1'),
                    __('classes.box_collector.advanced_ability_2')
                ]
            ],
            'divine_scholar' => [
                'name' => 'Divine Scholar',
                'icon' => '📜',
                'description' => __('classes.divine_scholar.description'),
                'abilities' => [
                    __('classes.divine_scholar.ability_1'),
                    __('classes.divine_scholar.ability_2')
                ],
                'advanced_name' => 'Arcane Sage',
                'advanced_description' => __('classes.divine_scholar.advanced_description'),
                'advanced_abilities' => [
                    __('classes.divine_scholar.advanced_ability_1'),
                    __('classes.divine_scholar.advanced_ability_2')
                ]
            ]
        ];
    }
    
    /**
     * Check if player can select a class
     */
    public function canSelectClass(): bool
    {
        return $this->level >= 4 && !$this->selected_class;
    }
    
    /**
     * Check if player can advance their class
     */
    public function canAdvanceClass(): bool
    {
        return $this->level >= 8 && $this->selected_class && !$this->has_advanced_class;
    }
    
    /**
     * Get current class display name
     */
    public function getClassDisplayName(): string
    {
        if (!$this->selected_class) {
            return 'None';
        }
        
        $classes = self::getAvailableClasses();
        $class = $classes[$this->selected_class] ?? null;
        
        if (!$class) {
            return 'Unknown';
        }
        
        return $this->has_advanced_class ? $class['advanced_name'] : $class['name'];
    }
    
    /**
     * Get current class description
     */
    public function getClassDescription(): string
    {
        if (!$this->selected_class) {
            return 'No class selected';
        }
        
        $classes = self::getAvailableClasses();
        $class = $classes[$this->selected_class] ?? null;
        
        if (!$class) {
            return 'Unknown class';
        }
        
        return $this->has_advanced_class ? $class['advanced_description'] : $class['description'];
    }

    /**
     * Get the user's profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return '/images/profile/' . $this->profile_picture;
        }
        
        return '/images/profile/default.png';
    }
}
