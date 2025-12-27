<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if is_admin column exists in database
        try {
            $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = 'users' AND column_name = 'is_admin'");
            $hasIsAdminColumn = !empty($columns);
        } catch (\Exception $e) {
            // If we can't check, assume column doesn't exist
            $hasIsAdminColumn = false;
        }
        
        // If column doesn't exist, redirect to dashboard with message
        if (!$hasIsAdminColumn) {
            return redirect()->route('dashboard')->with('error', 'Admin panel requires migration. Please run: php artisan migrate');
        }
        
        // Check if user is admin
        // Laravel models return null for non-existent attributes, so we check both existence and value
        $isAdmin = isset($user->is_admin) && $user->is_admin === true;
        
        if (!$isAdmin) {
            // If user is not admin, show 403 but don't redirect to login (user is already logged in)
            abort(403, 'Unauthorized. Admin access required. Your account does not have admin privileges.');
        }

        return $next($request);
    }
}

