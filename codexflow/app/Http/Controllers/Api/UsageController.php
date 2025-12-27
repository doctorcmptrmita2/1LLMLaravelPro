<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use App\Services\AnalyticsService;
use App\Services\RateLimitService;
use App\Services\UsageService;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function __construct(
        private UsageService $usageService,
        private AnalyticsService $analyticsService,
        private RateLimitService $rateLimitService
    ) {}

    public function logs(Request $request)
    {
        $user = $request->user();
        
        $query = ApiLog::where('user_id', $user->id);
        
        if ($request->has('model')) {
            $query->where('model', $request->model);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $logs = $query->orderByDesc('created_at')
            ->paginate($request->get('per_page', 50));
        
        return response()->json($logs);
    }

    public function analytics(Request $request)
    {
        $user = $request->user();
        
        $costTrend = $this->analyticsService->getCostTrend($user);
        $topModels = $this->analyticsService->getTopModels($user);
        $monthlyStats = $this->analyticsService->getMonthlyStats($user);
        
        return response()->json([
            'cost_trend' => $costTrend,
            'top_models' => $topModels,
            'monthly_stats' => $monthlyStats,
        ]);
    }

    public function export(Request $request)
    {
        $user = $request->user();
        
        $logs = ApiLog::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        
        $csv = "Date,Model,Input Tokens,Output Tokens,Total Cost,Response Time,Status\n";
        
        foreach ($logs as $log) {
            $csv .= sprintf(
                "%s,%s,%d,%d,%.6f,%d,%s\n",
                $log->created_at->format('Y-m-d H:i:s'),
                $log->model,
                $log->input_tokens,
                $log->output_tokens,
                $log->total_cost,
                $log->response_time_ms,
                $log->status
            );
        }
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="usage_export.csv"');
    }

    public function log(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'model' => 'required|string',
            'input_tokens' => 'required|integer|min:0',
            'output_tokens' => 'required|integer|min:0',
            'total_cost' => 'required|numeric|min:0',
            'response_time_ms' => 'required|integer|min:0',
            'status' => 'required|in:success,error,rate_limited',
            'error_message' => 'nullable|string',
        ]);

        $log = $this->usageService->logUsage($request->all());
        
        // Update rate limits
        $user = \App\Models\User::find($request->user_id);
        $this->rateLimitService->incrementUsage(
            $user,
            $request->input_tokens + $request->output_tokens,
            'daily'
        );
        $this->rateLimitService->incrementUsage(
            $user,
            $request->input_tokens + $request->output_tokens,
            'monthly'
        );
        
        return response()->json($log, 201);
    }

    /**
     * LiteLLM Webhook endpoint
     * LiteLLM proxy'den gelen webhook isteklerini işler
     */
    public function litellmWebhook(Request $request)
    {
        // LiteLLM webhook formatına göre veriyi parse et
        $data = $request->all();
        
        try {
            // User'ı API key ile bul
            $apiKey = $data['user_id'] ?? $data['metadata']['user_id'] ?? null;
            
            if (!$apiKey) {
                return response()->json(['error' => 'user_id is required'], 400);
            }
            
            $user = \App\Models\User::where('api_key', $apiKey)->first();
            
            if (!$user) {
                // API key ile user bulunamazsa, user_id'yi direkt kullan
                $userId = is_numeric($apiKey) ? (int) $apiKey : null;
                if (!$userId) {
                    return response()->json(['error' => 'User not found'], 404);
                }
                $user = \App\Models\User::find($userId);
                if (!$user) {
                    return response()->json(['error' => 'User not found'], 404);
                }
            }
            
            // Model adını al
            $model = $data['model'] ?? $data['response']['model'] ?? 'unknown';
            
            // Token bilgilerini al
            $usage = $data['usage'] ?? $data['response']['usage'] ?? [];
            $inputTokens = $usage['prompt_tokens'] ?? $usage['input_tokens'] ?? 0;
            $outputTokens = $usage['completion_tokens'] ?? $usage['output_tokens'] ?? 0;
            
            // Maliyet bilgisini al
            $cost = $data['cost'] ?? $data['response']['cost'] ?? 0;
            
            // Response time'ı al (saniye cinsinden, milisaniyeye çevir)
            $responseTime = ($data['response_time'] ?? $data['response']['response_time'] ?? 0) * 1000;
            
            // Status belirle
            $status = 'success';
            if (isset($data['error']) || isset($data['response']['error'])) {
                $status = 'error';
            }
            
            $errorMessage = $data['error']['message'] ?? $data['response']['error']['message'] ?? null;
            
            // Log kaydı oluştur
            $logData = [
                'user_id' => $user->id,
                'model' => $model,
                'input_tokens' => (int) $inputTokens,
                'output_tokens' => (int) $outputTokens,
                'total_cost' => (float) $cost,
                'response_time_ms' => (int) $responseTime,
                'status' => $status,
                'error_message' => $errorMessage,
            ];
            
            $log = $this->usageService->logUsage($logData);
            
            // Rate limit güncelle
            $this->rateLimitService->incrementUsage(
                $user,
                (int) $inputTokens + (int) $outputTokens,
                'daily'
            );
            $this->rateLimitService->incrementUsage(
                $user,
                (int) $inputTokens + (int) $outputTokens,
                'monthly'
            );
            
            return response()->json([
                'success' => true,
                'log_id' => $log->id,
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('LiteLLM webhook error: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
