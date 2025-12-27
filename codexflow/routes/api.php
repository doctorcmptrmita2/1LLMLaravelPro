<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\RateLimitController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\UsageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// LiteLLM Webhook (public but secured with webhook key)
Route::post('/webhook/litellm', [UsageController::class, 'litellmWebhook'])
    ->middleware('litellm.webhook');

// Protected routes (works with both Sanctum and Web auth)
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/usage', [DashboardController::class, 'usage']);
    
    // Usage
    Route::get('/usage/logs', [UsageController::class, 'logs']);
    Route::get('/usage/analytics', [UsageController::class, 'analytics']);
    Route::post('/usage/export', [UsageController::class, 'export']);
    Route::post('/usage/log', [UsageController::class, 'log']);
    
    // Rate Limits
    Route::get('/rate-limits', [RateLimitController::class, 'index']);
    Route::post('/rate-limits/request-increase', [RateLimitController::class, 'requestIncrease']);
    
    // Models
    Route::get('/models', [ModelController::class, 'index']);
    Route::post('/models/favorite', [ModelController::class, 'favorite']);
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings/api-key/regenerate', [SettingsController::class, 'regenerateApiKey']);
    Route::post('/settings/update', [SettingsController::class, 'update']);
});

