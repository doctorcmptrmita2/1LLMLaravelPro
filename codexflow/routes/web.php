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

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\AdminController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/api-key', [\App\Http\Controllers\Admin\AdminController::class, 'updateApiKey'])->name('users.update-api-key');
    Route::post('/users/assign-api-key', [\App\Http\Controllers\Admin\AdminController::class, 'assignApiKey'])->name('users.assign-api-key');
    Route::post('/users/{user}/update', [\App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{user}/suspend', [\App\Http\Controllers\Admin\AdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/activate', [\App\Http\Controllers\Admin\AdminController::class, 'activateUser'])->name('users.activate');
});
