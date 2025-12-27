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
        return view('dashboard.index');
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
