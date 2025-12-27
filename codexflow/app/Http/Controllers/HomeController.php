<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $isAdmin = isset($user->is_admin) && $user->is_admin;
        
        $data = [];
        
        if ($isAdmin) {
            try {
                $data['adminStats'] = [
                    'total_users' => \App\Models\User::count(),
                    'active_users' => \App\Models\User::where('status', 'active')->count(),
                    'suspended_users' => \App\Models\User::where('status', 'suspended')->count(),
                    'total_api_calls' => \App\Models\ApiLog::count(),
                ];
                
                $data['users'] = \App\Models\User::latest()->limit(10)->get();
            } catch (\Exception $e) {
                // Migration henüz çalıştırılmamış olabilir
                $data['adminStats'] = null;
                $data['users'] = collect();
            }
        }
        
        return view('dashboard.index', $data);
    }

    public function analytics()
    {
        return view('dashboard.analytics');
    }

    public function logs()
    {
        return view('dashboard.logs');
    }

    public function rateLimits()
    {
        return view('dashboard.rate-limits');
    }

    public function models()
    {
        return view('dashboard.models');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }
}
