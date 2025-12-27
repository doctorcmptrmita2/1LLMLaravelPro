<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RateLimit extends Model
{
    protected $fillable = [
        'user_id',
        'period',
        'limit_tokens',
        'used_tokens',
        'limit_requests',
        'used_requests',
        'reset_at',
    ];

    protected function casts(): array
    {
        return [
            'reset_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExceeded(): bool
    {
        return $this->used_tokens >= $this->limit_tokens 
            || $this->used_requests >= $this->limit_requests;
    }

    public function getRemainingTokens(): int
    {
        return max(0, $this->limit_tokens - $this->used_tokens);
    }

    public function getRemainingRequests(): int
    {
        return max(0, $this->limit_requests - $this->used_requests);
    }
}
