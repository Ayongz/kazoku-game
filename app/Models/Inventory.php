<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the inventory.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create inventory for a user
     */
    public static function getOrCreateForUser(int $userId): self
    {
        return self::firstOrCreate(['user_id' => $userId]);
    }
}
