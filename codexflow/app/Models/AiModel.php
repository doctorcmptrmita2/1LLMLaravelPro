<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiModel extends Model
{
    protected $table = 'models';

    protected $fillable = [
        'name',
        'model_id',
        'cost_per_1k_tokens',
        'availability',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'cost_per_1k_tokens' => 'decimal:6',
            'availability' => 'boolean',
        ];
    }
}

