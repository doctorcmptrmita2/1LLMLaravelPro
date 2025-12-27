@extends('layouts.dashboard')

@section('content')
    <div id="dashboard-app" data-user="{{ json_encode(auth()->user()) }}">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-sm text-gray-400 mb-2">API Calls Today</h3>
                <p class="text-3xl font-bold" id="api-calls">-</p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-sm text-gray-400 mb-2">Tokens Used</h3>
                <p class="text-3xl font-bold" id="tokens-used">-</p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-sm text-gray-400 mb-2">Total Cost</h3>
                <p class="text-3xl font-bold" id="total-cost">-</p>
            </div>
            
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-sm text-gray-400 mb-2">Avg Response Time</h3>
                <p class="text-3xl font-bold" id="avg-response-time">-</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Token Usage Chart -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-lg font-semibold mb-4">Daily Token Usage</h3>
                <canvas id="tokenChart"></canvas>
            </div>

            <!-- Model Distribution -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
                <h3 class="text-lg font-semibold mb-4">Model Distribution</h3>
                <canvas id="modelChart"></canvas>
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
            if (tokenChartEl && typeof Chart !== 'undefined') {
                try {
                    const tokenCtx = tokenChartEl.getContext('2d');
                    new Chart(tokenCtx, {
                        type: 'line',
                        data: {
                            labels: data.chart?.dates || [],
                            datasets: [{
                                label: 'Tokens Used',
                                data: data.chart?.tokens || [],
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
                                y: { beginAtZero: true }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Chart error:', error);
                }
            }

            // Model Distribution Chart
            const modelChartEl = document.getElementById('modelChart');
            if (modelChartEl && typeof Chart !== 'undefined') {
                try {
                    const modelCtx = modelChartEl.getContext('2d');
                    new Chart(modelCtx, {
                        type: 'doughnut',
                        data: {
                            labels: data.model_distribution?.models || [],
                            datasets: [{
                                data: data.model_distribution?.counts || [],
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
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Chart error:', error);
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

