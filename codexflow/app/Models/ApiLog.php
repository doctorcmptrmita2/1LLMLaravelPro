<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiLog extends Model
{
    protected $fillable = [
        'user_id',
        'model',
        'input_tokens',
        'output_tokens',
        'total_cost',
        'response_time_ms',
        'status',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'total_cost' => 'decimal:6',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
