<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Services\RateLimitService;
use App\Services\UsageService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private UsageService $usageService,
        private AnalyticsService $analyticsService,
        private RateLimitService $rateLimitService
    ) {}

    public function stats(Request $request)
    {
        $user = $request->user();
        
        $todayStats = $this->usageService->getTodayStats($user);
        $rateLimits = $this->rateLimitService->getRateLimits($user);
        
        return response()->json([
            'today' => $todayStats,
            'rate_limits' => $rateLimits,
        ]);
    }

    public function usage(Request $request)
    {
        $user = $request->user();
        
        $chartData = $this->usageService->getUsageChartData($user);
        $modelDistribution = $this->usageService->getModelDistribution($user);
        $recentLogs = $this->usageService->getRecentLogs($user);
        
        return response()->json([
            'chart' => $chartData,
            'model_distribution' => $modelDistribution,
            'recent_logs' => $recentLogs,
        ]);
    }
}
