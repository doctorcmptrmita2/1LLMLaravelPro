<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'user' => $user->makeHidden(['password']),
            'api_key' => $user->api_key,
        ]);
    }

    public function regenerateApiKey(Request $request)
    {
        $user = $request->user();
        $newKey = $user->generateApiKey();
        
        return response()->json([
            'message' => 'API key regenerated successfully',
            'api_key' => $newKey,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));
        
        return response()->json([
            'message' => 'Settings updated successfully',
            'user' => $user->makeHidden(['password']),
        ]);
    }
}
