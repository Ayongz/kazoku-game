<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopupRequest extends Model
{
    protected $fillable = [
        'user_id', 'package', 'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
