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
}
