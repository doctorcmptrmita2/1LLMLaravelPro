<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/analytics', [HomeController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/dashboard/logs', [HomeController::class, 'logs'])->name('dashboard.logs');
    Route::get('/dashboard/rate-limits', [HomeController::class, 'rateLimits'])->name('dashboard.rate-limits');
    Route::get('/dashboard/models', [HomeController::class, 'models'])->name('dashboard.models');
    Route::get('/dashboard/settings', [HomeController::class, 'settings'])->name('dashboard.settings');
});
