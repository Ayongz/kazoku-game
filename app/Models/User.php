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
        'randombox',
        'selected_class',
        'has_advanced_class',
        'class_selected_at',
        'prestige_level',
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
                'description' => 'A skilled explorer specializing in treasure discovery and efficiency.',
                'abilities' => [
                    '15% chance for free treasure attempts',
                    'Enhanced treasure hunting skills'
                ],
                'advanced_name' => 'Master Treasure Hunter',
                'advanced_description' => 'Elite explorer with supreme treasure hunting mastery.',
                'advanced_abilities' => [
                    '25% chance for free treasure attempts',
                    'Superior treasure hunting expertise'
                ]
            ],
            'proud_merchant' => [
                'name' => 'Proud Merchant',
                'icon' => '💼',
                'description' => 'A savvy trader focused on maximizing profits and earnings.',
                'abilities' => [
                    '+20% bonus earnings from treasure',
                    'Enhanced profit margins'
                ],
                'advanced_name' => 'Trade Emperor',
                'advanced_description' => 'Master merchant with supreme trading prowess.',
                'advanced_abilities' => [
                    '+30% bonus earnings from treasure',
                    'Supreme profit optimization'
                ]
            ],
            'fortune_gambler' => [
                'name' => 'Fortune Gambler',
                'icon' => '🎰',
                'description' => 'A risk-taker who lives for high stakes and big rewards.',
                'abilities' => [
                    '15% chance to double earnings',
                    '8% chance to lose everything',
                    'High risk, high reward gameplay'
                ],
                'advanced_name' => 'Luck Master',
                'advanced_description' => 'Elite gambler with enhanced fortune mechanics.',
                'advanced_abilities' => [
                    '25% chance to double earnings',
                    '12% chance to lose everything',
                    'Extreme risk, extreme reward'
                ]
            ],
            'moon_guardian' => [
                'name' => 'Moon Guardian',
                'icon' => '🌙',
                'description' => 'A mystical guardian who draws power from the night.',
                'abilities' => [
                    '20% chance for random box during nighttime (6 PM - 6 AM)',
                    'Enhanced night-time treasure hunting'
                ],
                'advanced_name' => 'Lunar Master',
                'advanced_description' => 'Supreme guardian blessed by lunar forces.',
                'advanced_abilities' => [
                    '30% chance for random box during nighttime (6 PM - 6 AM)',
                    'Master of nocturnal treasure arts'
                ]
            ],
            'day_breaker' => [
                'name' => 'Day Breaker',
                'icon' => '☀️',
                'description' => 'A radiant warrior who harnesses the power of sunlight.',
                'abilities' => [
                    '20% chance for random box during daytime (6 AM - 6 PM)',
                    'Enhanced day-time treasure hunting'
                ],
                'advanced_name' => 'Solar Champion',
                'advanced_description' => 'Elite champion empowered by solar energy.',
                'advanced_abilities' => [
                    '30% chance for random box during daytime (6 AM - 6 PM)',
                    'Master of solar treasure arts'
                ]
            ],
            'box_collector' => [
                'name' => 'Box Collector',
                'icon' => '📦',
                'description' => 'A dedicated collector who specializes in acquiring rare containers.',
                'abilities' => [
                    '10% chance to receive 2 random boxes',
                    'Enhanced box discovery skills'
                ],
                'advanced_name' => 'Grand Collector',
                'advanced_description' => 'Supreme collector with unmatched acquisition skills.',
                'advanced_abilities' => [
                    '15% chance to receive 2 random boxes',
                    'Master collection expertise'
                ]
            ],
            'divine_scholar' => [
                'name' => 'Divine Scholar',
                'icon' => '📜',
                'description' => 'A wise scholar blessed with knowledge and enhanced learning.',
                'abilities' => [
                    '+10% bonus experience from treasure',
                    'Wisdom-based learning enhancement'
                ],
                'advanced_name' => 'Arcane Sage',
                'advanced_description' => 'Master scholar with divine knowledge and superior learning.',
                'advanced_abilities' => [
                    '+20% bonus experience from treasure',
                    'Enhanced divine wisdom and learning'
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
}
