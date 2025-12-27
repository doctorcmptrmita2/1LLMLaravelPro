@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Usage Analytics</h1>
        <p class="text-gray-400">Detailed analytics and insights about your API usage</p>
    </div>

    <!-- Analytics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-lg font-semibold mb-4">Token Usage Over Time</h3>
            <canvas id="tokenUsageChart"></canvas>
        </div>

        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-lg font-semibold mb-4">Cost Analysis</h3>
            <canvas id="costChart"></canvas>
        </div>
    </div>

    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
        <h3 class="text-lg font-semibold mb-4">Model Performance</h3>
        <canvas id="performanceChart"></canvas>
    </div>

    <script>
        // Token Usage Chart
        const tokenCtx = document.getElementById('tokenUsageChart').getContext('2d');
        new Chart(tokenCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Tokens',
                    data: [],
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
                }
            }
        });

        // Cost Chart
        const costCtx = document.getElementById('costChart').getContext('2d');
        new Chart(costCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Cost ($)',
                    data: [],
                    backgroundColor: '#22D3EE',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Performance Chart
        const perfCtx = document.getElementById('performanceChart').getContext('2d');
        new Chart(perfCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Response Time (ms)',
                    data: [],
                    borderColor: '#3EE48B',
                    backgroundColor: 'rgba(62, 228, 139, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                }
            }
        });
    </script>
@endsection

