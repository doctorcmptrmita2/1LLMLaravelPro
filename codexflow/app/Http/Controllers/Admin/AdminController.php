<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        try {
            $users = User::latest()->paginate(20);
            
            $stats = [
                'total_users' => User::count(),
                'active_users' => User::where('status', 'active')->count(),
                'suspended_users' => User::where('status', 'suspended')->count(),
                'total_api_calls' => \App\Models\ApiLog::count(),
            ];

            return view('admin.index', compact('users', 'stats'));
        } catch (\Exception $e) {
            \Log::error('Admin panel error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->view('errors.500', [
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(User $user)
    {
        $user->load(['apiLogs' => function($query) {
            $query->latest()->limit(10);
        }, 'rateLimits']);

        return view('admin.user.show', compact('user'));
    }

    public function updateApiKey(Request $request, User $user)
    {
        $request->validate([
            'api_key' => 'required|string|max:255|unique:users,api_key,' . $user->id,
        ]);

        $user->update([
            'api_key' => $request->api_key,
        ]);

        return back()->with('success', 'API key updated successfully.');
    }

    public function assignApiKey(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'api_key' => 'required|string|max:255|unique:users,api_key',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->update([
            'api_key' => $request->api_key,
        ]);

        return back()->with('success', "API key assigned to {$user->email} successfully.");
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'plan' => 'required|in:starter,pro,agency',
            'status' => 'required|in:active,suspended',
            'is_admin' => 'boolean',
        ]);

        $user->update($request->only(['name', 'email', 'plan', 'status', 'is_admin']));

        return back()->with('success', 'User updated successfully.');
    }

    public function suspendUser(User $user)
    {
        $user->update(['status' => 'suspended']);
        return back()->with('success', 'User suspended successfully.');
    }

    public function activateUser(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'User activated successfully.');
    }
}

