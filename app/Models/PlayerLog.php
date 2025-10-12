<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_type',
        'description',
        'money_change',
        'treasure_change',
        'rare_treasure_change',
        'random_box_change',
        'experience_gained',
        'additional_data',
        'is_success'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'is_success' => 'boolean',
        'money_change' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the log
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted money change
     */
    public function getFormattedMoneyChangeAttribute(): string
    {
        $formatted = number_format(abs($this->money_change), 0, ',', '.');
        if ($this->money_change >= 0) {
            return "+IDR {$formatted}";
        }
        return "-IDR {$formatted}";
    }

    /**
     * Get action type display name
     */
    public function getActionTypeDisplayAttribute(): string
    {
        return match($this->action_type) {
            'treasure_open' => '💎 Treasure Opening',
            'rare_treasure_open' => '⭐ Rare Treasure Opening',
            'random_box_open' => '🎁 Random Box Opening',
            'gambling_dice' => '🎲 Dice Gambling',
            'gambling_card' => '🃏 Card Gambling',
            'treasure_fusion' => '✨ Treasure Fusion',
            default => ucfirst(str_replace('_', ' ', $this->action_type))
        };
    }

    /**
     * Scope to get logs for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get recent logs
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Static method to create a log entry
     */
    public static function createLog(
        int $userId,
        string $actionType,
        string $description,
        float $moneyChange = 0,
        int $treasureChange = 0,
        int $rareTreasureChange = 0,
        int $randomBoxChange = 0,
        int $experienceGained = 0,
        array $additionalData = null,
        bool $isSuccess = true
    ): self {
        return self::create([
            'user_id' => $userId,
            'action_type' => $actionType,
            'description' => $description,
            'money_change' => $moneyChange,
            'treasure_change' => $treasureChange,
            'rare_treasure_change' => $rareTreasureChange,
            'random_box_change' => $randomBoxChange,
            'experience_gained' => $experienceGained,
            'additional_data' => $additionalData,
            'is_success' => $isSuccess
        ]);
    }
}