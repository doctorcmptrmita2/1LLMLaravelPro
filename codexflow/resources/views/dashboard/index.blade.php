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
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
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
    </script>
@endsection

