<?php

namespace App\Services;

use App\Models\ApiLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsageService
{
    public function logUsage(array $data): ApiLog
    {
        return ApiLog::create($data);
    }

    public function getTodayStats(User $user): array
    {
        $today = Carbon::today();

        $stats = ApiLog::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->select(
                DB::raw('COUNT(*) as api_calls'),
                DB::raw('SUM(input_tokens + output_tokens) as tokens_used'),
                DB::raw('SUM(total_cost) as total_cost'),
                DB::raw('AVG(response_time_ms) as avg_response_time')
            )
            ->first();

        return [
            'api_calls' => (int) ($stats->api_calls ?? 0),
            'tokens_used' => (int) ($stats->tokens_used ?? 0),
            'total_cost' => (float) ($stats->total_cost ?? 0),
            'avg_response_time' => (int) ($stats->avg_response_time ?? 0),
        ];
    }

    public function getUsageChartData(User $user, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $logs = ApiLog::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(input_tokens + output_tokens) as tokens')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $tokens = [];

        foreach ($logs as $log) {
            $dates[] = Carbon::parse($log->date)->format('M d');
            $tokens[] = (int) $log->tokens;
        }

        return [
            'dates' => $dates,
            'tokens' => $tokens,
        ];
    }

    public function getModelDistribution(User $user, int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);
        
        $distribution = ApiLog::where('user_id', $user->id)
            ->where('created_at', '>=', $startDate)
            ->select('model', DB::raw('COUNT(*) as count'))
            ->groupBy('model')
            ->orderByDesc('count')
            ->get();

        $models = [];
        $counts = [];

        foreach ($distribution as $item) {
            $models[] = $item->model;
            $counts[] = (int) $item->count;
        }

        return [
            'models' => $models,
            'counts' => $counts,
        ];
    }

    public function getRecentLogs(User $user, int $limit = 50)
    {
        return ApiLog::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}

