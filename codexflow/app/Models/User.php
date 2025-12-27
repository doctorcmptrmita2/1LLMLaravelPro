<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'plan',
        'status',
    ];

    protected $hidden = [
        'password',
        'api_key',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function apiLogs()
    {
        return $this->hasMany(ApiLog::class);
    }

    public function rateLimits()
    {
        return $this->hasMany(RateLimit::class);
    }

    public function generateApiKey(): string
    {
        $key = 'cf_' . bin2hex(random_bytes(32));
        $this->update(['api_key' => $key]);
        return $key;
    }
}
