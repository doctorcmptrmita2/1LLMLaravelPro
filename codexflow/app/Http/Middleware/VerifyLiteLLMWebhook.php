<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLiteLLMWebhook
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key') ?? $request->header('Authorization');
        
        // Remove 'Bearer ' prefix if present
        if ($apiKey && str_starts_with($apiKey, 'Bearer ')) {
            $apiKey = substr($apiKey, 7);
        }
        
        $expectedKey = config('services.litellm.webhook_key');
        
        if (!$expectedKey || $apiKey !== $expectedKey) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid webhook key'
            ], 401);
        }
        
        return $next($request);
    }
}

