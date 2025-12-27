<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RateLimitService;
use Illuminate\Http\Request;

class RateLimitController extends Controller
{
    public function __construct(
        private RateLimitService $rateLimitService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $rateLimits = $this->rateLimitService->getRateLimits($user);
        
        return response()->json($rateLimits);
    }

    public function requestIncrease(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,monthly',
            'reason' => 'required|string|max:500',
        ]);

        // TODO: Implement request increase logic (email to admin, etc.)
        
        return response()->json([
            'message' => 'Your request has been submitted. We will review it shortly.',
        ]);
    }
}
