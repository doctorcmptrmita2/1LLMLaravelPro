<?php

namespace App\Services;

use App\Models\ApiLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function getCostTrend(User $user, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $trend = ApiLog::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_cost) as cost')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $costs = [];

        foreach ($trend as $item) {
            $dates[] = Carbon::parse($item->date)->format('M d');
            $costs[] = (float) $item->cost;
        }

        return [
            'dates' => $dates,
            'costs' => $costs,
        ];
    }

    public function getTopModels(User $user, int $limit = 5): array
    {
        return ApiLog::where('user_id', $user->id)
            ->select('model', DB::raw('COUNT(*) as usage_count'))
            ->groupBy('model')
            ->orderByDesc('usage_count')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getMonthlyStats(User $user): array
    {
        $monthStart = Carbon::now()->startOfMonth();
        
        $stats = ApiLog::where('user_id', $user->id)
            ->where('created_at', '>=', $monthStart)
            ->select(
                DB::raw('COUNT(*) as api_calls'),
                DB::raw('SUM(input_tokens + output_tokens) as tokens_used'),
                DB::raw('SUM(total_cost) as total_cost')
            )
            ->first();

        return [
            'api_calls' => (int) ($stats->api_calls ?? 0),
            'tokens_used' => (int) ($stats->tokens_used ?? 0),
            'total_cost' => (float) ($stats->total_cost ?? 0),
        ];
    }
}

