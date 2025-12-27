<?php

namespace App\Services;

use App\Models\RateLimit;
use App\Models\User;
use Carbon\Carbon;

class RateLimitService
{
    public function getRateLimits(User $user): array
    {
        $daily = $this->getOrCreateRateLimit($user, 'daily');
        $monthly = $this->getOrCreateRateLimit($user, 'monthly');

        return [
            'daily' => [
                'limit' => $daily->limit_tokens,
                'used' => $daily->used_tokens,
                'remaining' => $daily->getRemainingTokens(),
                'limit_requests' => $daily->limit_requests,
                'used_requests' => $daily->used_requests,
                'remaining_requests' => $daily->getRemainingRequests(),
                'reset_at' => $daily->reset_at,
            ],
            'monthly' => [
                'limit' => $monthly->limit_tokens,
                'used' => $monthly->used_tokens,
                'remaining' => $monthly->getRemainingTokens(),
                'limit_requests' => $monthly->limit_requests,
                'used_requests' => $monthly->used_requests,
                'remaining_requests' => $monthly->getRemainingRequests(),
                'reset_at' => $monthly->reset_at,
            ],
        ];
    }

    public function getOrCreateRateLimit(User $user, string $period): RateLimit
    {
        $rateLimit = RateLimit::where('user_id', $user->id)
            ->where('period', $period)
            ->first();

        if (!$rateLimit) {
            $limits = $this->getDefaultLimits($user->plan, $period);
            
            $rateLimit = RateLimit::create([
                'user_id' => $user->id,
                'period' => $period,
                'limit_tokens' => $limits['tokens'],
                'limit_requests' => $limits['requests'],
                'reset_at' => $this->getResetDate($period),
            ]);
        } else {
            // Reset if needed
            if (Carbon::now()->greaterThan($rateLimit->reset_at)) {
                $rateLimit->update([
                    'used_tokens' => 0,
                    'used_requests' => 0,
                    'reset_at' => $this->getResetDate($period),
                ]);
            }
        }

        return $rateLimit;
    }

    public function incrementUsage(User $user, int $tokens, string $period = 'daily'): void
    {
        $rateLimit = $this->getOrCreateRateLimit($user, $period);
        
        $rateLimit->increment('used_tokens', $tokens);
        $rateLimit->increment('used_requests', 1);
    }

    protected function getDefaultLimits(string $plan, string $period): array
    {
        $limits = [
            'starter' => [
                'daily' => ['tokens' => 100000, 'requests' => 1000],
                'monthly' => ['tokens' => 1000000, 'requests' => 10000],
            ],
            'pro' => [
                'daily' => ['tokens' => 500000, 'requests' => 5000],
                'monthly' => ['tokens' => 10000000, 'requests' => 100000],
            ],
            'agency' => [
                'daily' => ['tokens' => 2000000, 'requests' => 20000],
                'monthly' => ['tokens' => 50000000, 'requests' => 500000],
            ],
        ];

        return $limits[$plan][$period] ?? $limits['starter'][$period];
    }

    protected function getResetDate(string $period): Carbon
    {
        if ($period === 'daily') {
            return Carbon::tomorrow()->startOfDay();
        }
        
        return Carbon::now()->addMonth()->startOfMonth();
    }
}

