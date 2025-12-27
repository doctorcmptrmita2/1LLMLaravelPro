@extends('layouts.dashboard')

@section('content')
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400">
            <p class="font-semibold">⚠️ {{ session('error') }}</p>
        </div>
    @endif
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
            <p class="font-semibold">✅ {{ session('success') }}</p>
        </div>
    @endif

    <div id="dashboard-app" data-user="{{ json_encode(auth()->user()) }}">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-400">Here's your API usage overview</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm text-gray-400">API Calls Today</h3>
                    <svg class="w-5 h-5 text-[#6D5CFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent" id="api-calls">
                    <span class="inline-block animate-pulse">-</span>
                </p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#22D3EE]/50 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm text-gray-400">Tokens Used</h3>
                    <svg class="w-5 h-5 text-[#22D3EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] bg-clip-text text-transparent" id="tokens-used">
                    <span class="inline-block animate-pulse">-</span>
                </p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#3EE48B]/50 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm text-gray-400">Total Cost</h3>
                    <svg class="w-5 h-5 text-[#3EE48B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold bg-gradient-to-r from-[#3EE48B] to-[#6D5CFF] bg-clip-text text-transparent" id="total-cost">
                    <span class="inline-block animate-pulse">-</span>
                </p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#FFCC66]/50 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm text-gray-400">Avg Response Time</h3>
                    <svg class="w-5 h-5 text-[#FFCC66]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-[#FFCC66]" id="avg-response-time">
                    <span class="inline-block animate-pulse">-</span>
                </p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Token Usage Chart -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-lg font-semibold mb-4">Daily Token Usage</h3>
                <div class="h-64">
                    <canvas id="tokenChart"></canvas>
                </div>
                <p id="token-chart-empty" class="text-center text-gray-400 mt-4 hidden">No data available</p>
            </div>

            <!-- Model Distribution -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-lg font-semibold mb-4">Model Distribution</h3>
                <div class="h-64">
                    <canvas id="modelChart"></canvas>
                </div>
                <p id="model-chart-empty" class="text-center text-gray-400 mt-4 hidden">No data available</p>
            </div>
        </div>

        <!-- Rate Limits -->
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
            <h3 class="text-lg font-semibold mb-4">Rate Limits</h3>
            
            <div class="space-y-4">
                <!-- Daily Limit -->
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Daily Tokens</span>
                        <span id="daily-tokens">- / -</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] h-2 rounded-full" id="daily-progress" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Monthly Limit -->
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Monthly Tokens</span>
                        <span id="monthly-tokens">- / -</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-2">
                        <div class="bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] h-2 rounded-full" id="monthly-progress" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Logs -->
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
            <h3 class="text-lg font-semibold mb-4">Recent API Calls</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-[#1a1f3a]">
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Model</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Input Tokens</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Output Tokens</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Cost</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Response Time</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Status</th>
                            <th class="text-left py-3 px-4 text-gray-400 text-sm">Time</th>
                        </tr>
                    </thead>
                    <tbody id="logs-table-body">
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset(auth()->user()->is_admin) && auth()->user()->is_admin)
        <!-- Admin Section -->
        <div class="border-t border-[#1a1f3a] pt-8 mt-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-[#FF6B6B] to-[#FFCC66] bg-clip-text text-transparent">
                        🔐 Admin Panel
                    </h2>
                    <p class="text-gray-400 text-sm mt-1">Kullanıcı yönetimi ve API key atama</p>
                </div>
            </div>

            @if(isset($adminStats) && $adminStats)
            <!-- Admin Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-[#FF6B6B]/20 to-[#FF6B6B]/5 rounded-lg p-6 border border-[#FF6B6B]/30">
                    <h3 class="text-sm text-gray-400 mb-2">Total Users</h3>
                    <p class="text-3xl font-bold text-[#FF6B6B]">{{ $adminStats['total_users'] }}</p>
                </div>
                
                <div class="bg-gradient-to-br from-[#3EE48B]/20 to-[#3EE48B]/5 rounded-lg p-6 border border-[#3EE48B]/30">
                    <h3 class="text-sm text-gray-400 mb-2">Active Users</h3>
                    <p class="text-3xl font-bold text-[#3EE48B]">{{ $adminStats['active_users'] }}</p>
                </div>
                
                <div class="bg-gradient-to-br from-[#FFCC66]/20 to-[#FFCC66]/5 rounded-lg p-6 border border-[#FFCC66]/30">
                    <h3 class="text-sm text-gray-400 mb-2">Suspended Users</h3>
                    <p class="text-3xl font-bold text-[#FFCC66]">{{ $adminStats['suspended_users'] }}</p>
                </div>
                
                <div class="bg-gradient-to-br from-[#6D5CFF]/20 to-[#6D5CFF]/5 rounded-lg p-6 border border-[#6D5CFF]/30">
                    <h3 class="text-sm text-gray-400 mb-2">Total API Calls</h3>
                    <p class="text-3xl font-bold text-[#6D5CFF]">{{ number_format($adminStats['total_api_calls']) }}</p>
                </div>
            </div>
            @endif

            <!-- Assign API Key Form -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#6D5CFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    Assign API Key to User
                </h3>
                <form action="{{ route('admin.users.assign-api-key') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="assign-api-key-form">
                    @csrf
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Email Address</label>
                        <input type="email" name="email" required 
                            class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white focus:border-[#6D5CFF] focus:outline-none transition"
                            placeholder="doctor.cmptr.mita2@gmail.com"
                            value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">API Key</label>
                        <input type="text" name="api_key" required 
                            class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white font-mono text-sm focus:border-[#6D5CFF] focus:outline-none transition"
                            placeholder="sk-7Cif43XHbgNSMtSIaul_Xw"
                            value="{{ old('api_key') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                            Assign API Key
                        </button>
                    </div>
                </form>
                @if($errors->any())
                    <div class="mt-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Users Table -->
            @if(isset($users) && $users->count() > 0)
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#22D3EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Recent Users
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#1a1f3a]">
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">ID</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Name</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Email</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">API Key</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Plan</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Status</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Role</th>
                                <th class="text-left py-3 px-4 text-gray-400 text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b border-[#1a1f3a] hover:bg-[#1a1f3a] transition">
                                    <td class="py-3 px-4">{{ $user->id }}</td>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">
                                        <code class="text-xs text-gray-400 font-mono">
                                            {{ $user->api_key ? substr($user->api_key, 0, 20) . '...' : 'N/A' }}
                                        </code>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs capitalize bg-[#1a1f3a]">
                                            {{ $user->plan }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-medium {{ 
                                            $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' 
                                        }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if(isset($user->is_admin) && $user->is_admin)
                                            <span class="px-2 py-1 rounded text-xs bg-purple-500/20 text-purple-400 font-medium">Admin</span>
                                        @else
                                            <span class="text-gray-500 text-xs">User</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline" onsubmit="return confirm('Kullanıcıyı askıya almak istediğinize emin misiniz?')">
                                                @csrf
                                                @if($user->status === 'active')
                                                    <button type="submit" class="text-xs text-yellow-400 hover:text-yellow-300">Suspend</button>
                                                @else
                                                    <button type="submit" formaction="{{ route('admin.users.activate', $user) }}" class="text-xs text-green-400 hover:text-green-300">Activate</button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.index') }}" class="text-[#22D3EE] hover:underline text-sm">
                        View All Users →
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <script>
        // CSRF token for API requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Helper function for fetch with error handling
        async function fetchWithErrorHandling(url, options = {}) {
            try {
                const response = await fetch(url, {
                    ...options,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        ...options.headers
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return await response.json();
            } catch (error) {
                console.error('Fetch error:', error);
                return null;
            }
        }

        // Fetch dashboard stats
        fetchWithErrorHandling('/api/dashboard/stats').then(data => {
            if (!data) return;
            
            const today = data.today || {};
            const rateLimits = data.rate_limits || {};
            
            // Update stats
            const apiCallsEl = document.getElementById('api-calls');
            const tokensUsedEl = document.getElementById('tokens-used');
            const totalCostEl = document.getElementById('total-cost');
            const avgResponseTimeEl = document.getElementById('avg-response-time');
            
            if (apiCallsEl) apiCallsEl.textContent = today.api_calls || 0;
            if (tokensUsedEl) tokensUsedEl.textContent = (today.tokens_used || 0).toLocaleString();
            if (totalCostEl) totalCostEl.textContent = '$' + (today.total_cost || 0).toFixed(4);
            if (avgResponseTimeEl) avgResponseTimeEl.textContent = (today.avg_response_time || 0) + 'ms';
            
            // Rate limits
            const daily = rateLimits.daily || {};
            const monthly = rateLimits.monthly || {};
            
            const dailyTokensEl = document.getElementById('daily-tokens');
            const monthlyTokensEl = document.getElementById('monthly-tokens');
            const dailyProgressEl = document.getElementById('daily-progress');
            const monthlyProgressEl = document.getElementById('monthly-progress');
            
            if (dailyTokensEl) {
                dailyTokensEl.textContent = `${(daily.used || 0).toLocaleString()} / ${(daily.limit || 0).toLocaleString()}`;
            }
            if (monthlyTokensEl) {
                monthlyTokensEl.textContent = `${(monthly.used || 0).toLocaleString()} / ${(monthly.limit || 0).toLocaleString()}`;
            }
            
            const dailyPercent = daily.limit ? Math.min((daily.used / daily.limit) * 100, 100) : 0;
            const monthlyPercent = monthly.limit ? Math.min((monthly.used / monthly.limit) * 100, 100) : 0;
            
            if (dailyProgressEl) dailyProgressEl.style.width = dailyPercent + '%';
            if (monthlyProgressEl) monthlyProgressEl.style.width = monthlyPercent + '%';
        });

        // Fetch usage data
        fetchWithErrorHandling('/api/dashboard/usage').then(data => {
            if (!data) return;
            
            // Token Usage Chart
            const tokenChartEl = document.getElementById('tokenChart');
            const tokenChartEmpty = document.getElementById('token-chart-empty');
            if (tokenChartEl && typeof Chart !== 'undefined') {
                try {
                    const dates = data.chart?.dates || [];
                    const tokens = data.chart?.tokens || [];
                    
                    if (dates.length === 0 || tokens.length === 0) {
                        if (tokenChartEmpty) tokenChartEmpty.classList.remove('hidden');
                        return;
                    }
                    
                    if (tokenChartEmpty) tokenChartEmpty.classList.add('hidden');
                    
                    const tokenCtx = tokenChartEl.getContext('2d');
                    new Chart(tokenCtx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Tokens Used',
                                data: tokens,
                                borderColor: '#6D5CFF',
                                backgroundColor: 'rgba(109, 92, 255, 0.1)',
                                tension: 0.4,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#9CA3AF'
                                    },
                                    grid: {
                                        color: 'rgba(26, 31, 58, 0.5)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#9CA3AF'
                                    },
                                    grid: {
                                        color: 'rgba(26, 31, 58, 0.5)'
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Chart error:', error);
                    if (tokenChartEmpty) tokenChartEmpty.classList.remove('hidden');
                }
            }

            // Model Distribution Chart
            const modelChartEl = document.getElementById('modelChart');
            const modelChartEmpty = document.getElementById('model-chart-empty');
            if (modelChartEl && typeof Chart !== 'undefined') {
                try {
                    const models = data.model_distribution?.models || [];
                    const counts = data.model_distribution?.counts || [];
                    
                    if (models.length === 0 || counts.length === 0) {
                        if (modelChartEmpty) modelChartEmpty.classList.remove('hidden');
                        return;
                    }
                    
                    if (modelChartEmpty) modelChartEmpty.classList.add('hidden');
                    
                    const modelCtx = modelChartEl.getContext('2d');
                    new Chart(modelCtx, {
                        type: 'doughnut',
                        data: {
                            labels: models,
                            datasets: [{
                                data: counts,
                                backgroundColor: [
                                    '#6D5CFF',
                                    '#22D3EE',
                                    '#3EE48B',
                                    '#FFCC66',
                                    '#FF6B6B',
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { 
                                    position: 'bottom',
                                    labels: {
                                        color: '#9CA3AF',
                                        padding: 15
                                    }
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Chart error:', error);
                    if (modelChartEmpty) modelChartEmpty.classList.remove('hidden');
                }
            }

            // Recent Logs
            const logsBody = document.getElementById('logs-table-body');
            if (logsBody) {
                if (data.recent_logs && data.recent_logs.length > 0) {
                    logsBody.innerHTML = data.recent_logs.map(log => `
                        <tr class="border-b border-[#1a1f3a] hover:bg-[#1a1f3a]">
                            <td class="py-3 px-4">${log.model || 'N/A'}</td>
                            <td class="py-3 px-4">${(log.input_tokens || 0).toLocaleString()}</td>
                            <td class="py-3 px-4">${(log.output_tokens || 0).toLocaleString()}</td>
                            <td class="py-3 px-4">$${(log.total_cost || 0).toFixed(4)}</td>
                            <td class="py-3 px-4">${log.response_time_ms || 0}ms</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-medium ${
                                    log.status === 'success' ? 'bg-green-500/20 text-green-400' :
                                    log.status === 'error' ? 'bg-red-500/20 text-red-400' :
                                    'bg-yellow-500/20 text-yellow-400'
                                }">
                                    ${log.status || 'unknown'}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-400 text-sm">${log.created_at ? new Date(log.created_at).toLocaleString() : 'N/A'}</td>
                        </tr>
                    `).join('');
                } else {
                    logsBody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-400">No logs found</td></tr>';
                }
            }
        });

        // Admin form submission with AJAX
        const assignForm = document.getElementById('assign-api-key-form');
        if (assignForm) {
            assignForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                submitBtn.disabled = true;
                submitBtn.textContent = 'Assigning...';
                
                try {
                    const response = await fetchWithErrorHandling(this.action, {
                        method: 'POST',
                        body: formData,
                    });
                    
                    if (response) {
                        // Reload page to show success message
                        window.location.reload();
                    } else {
                        alert('Error assigning API key. Please try again.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error assigning API key. Please try again.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        }
    </script>
@endsection

