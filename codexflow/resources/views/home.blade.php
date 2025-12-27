@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#6D5CFF]/20 via-[#22D3EE]/10 to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-32">
            <div class="text-center">
                <h1 class="text-6xl font-bold mb-6">
                    <span class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent">
                        CodexFlow
                    </span>
                </h1>
                <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                    Powerful AI API management platform with real-time analytics, 
                    cost tracking, and intelligent rate limiting.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="/register" class="px-8 py-3 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                        Get Started
                    </a>
                    <a href="/login" class="px-8 py-3 border border-[#6D5CFF] rounded-lg font-semibold hover:bg-[#6D5CFF]/10 transition">
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Powerful Features</h2>
            <p class="text-gray-400 text-lg">Everything you need to manage your AI API usage</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition">
                <div class="w-12 h-12 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Real-time Analytics</h3>
                <p class="text-gray-400">
                    Track your API usage, costs, and performance in real-time with beautiful charts and insights.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition">
                <div class="w-12 h-12 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Cost Tracking</h3>
                <p class="text-gray-400">
                    Monitor your spending with detailed cost breakdowns and forecasting to optimize your budget.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition">
                <div class="w-12 h-12 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Smart Rate Limiting</h3>
                <p class="text-gray-400">
                    Intelligent rate limiting with automatic alerts and flexible limits to protect your API usage.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-2xl p-12 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to get started?</h2>
            <p class="text-xl mb-8 opacity-90">
                Join thousands of developers using CodexFlow to manage their AI APIs
            </p>
            <a href="/register" class="inline-block px-8 py-3 bg-white text-[#6D5CFF] rounded-lg font-semibold hover:opacity-90 transition">
                Create Free Account
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-[#1a1f3a] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} CodexFlow. All rights reserved.</p>
        </div>
    </footer>
@endsection

