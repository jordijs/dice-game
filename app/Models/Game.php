<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'dice1_value', 'dice2_value', 'result_win'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
