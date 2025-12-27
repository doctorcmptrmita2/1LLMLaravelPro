@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative overflow-hidden min-h-screen flex items-center">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#6D5CFF]/20 via-[#22D3EE]/10 to-transparent"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(109,92,255,0.1),transparent_50%)]"></div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#6D5CFF]/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#22D3EE]/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-[#0E1330] border border-[#6D5CFF]/30 rounded-full mb-8">
                    <span class="w-2 h-2 bg-[#3EE48B] rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm text-gray-300">AI API Management Platform</span>
                </div>

                <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-[#6D5CFF] via-[#22D3EE] to-[#3EE48B] bg-clip-text text-transparent">
                        CodexFlow
                    </span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-300 mb-4 max-w-3xl mx-auto leading-relaxed">
                    Powerful AI API management platform with 
                    <span class="text-[#22D3EE] font-semibold">real-time analytics</span>, 
                    <span class="text-[#3EE48B] font-semibold">cost tracking</span>, and 
                    <span class="text-[#6D5CFF] font-semibold">intelligent rate limiting</span>.
                </p>
                
                <p class="text-lg text-gray-400 mb-12 max-w-2xl mx-auto">
                    Take control of your AI infrastructure. Monitor usage, optimize costs, and scale with confidence.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                    <a href="{{ route('register') }}" class="group px-8 py-4 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold text-lg hover:opacity-90 transition-all transform hover:scale-105 shadow-lg shadow-[#6D5CFF]/50">
                        Get Started Free
                        <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-[#6D5CFF] rounded-lg font-semibold text-lg hover:bg-[#6D5CFF]/10 transition-all">
                        Sign In
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                    <div class="bg-[#0E1330]/50 backdrop-blur-sm rounded-lg p-6 border border-[#1a1f3a]">
                        <div class="text-4xl font-bold bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent mb-2">99.9%</div>
                        <div class="text-gray-400">Uptime</div>
                    </div>
                    <div class="bg-[#0E1330]/50 backdrop-blur-sm rounded-lg p-6 border border-[#1a1f3a]">
                        <div class="text-4xl font-bold bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] bg-clip-text text-transparent mb-2">10K+</div>
                        <div class="text-gray-400">API Calls/Day</div>
                    </div>
                    <div class="bg-[#0E1330]/50 backdrop-blur-sm rounded-lg p-6 border border-[#1a1f3a]">
                        <div class="text-4xl font-bold bg-gradient-to-r from-[#3EE48B] to-[#6D5CFF] bg-clip-text text-transparent mb-2">$0.01</div>
                        <div class="text-gray-400">Per 1K Tokens</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="text-center mb-20">
            <h2 class="text-5xl font-bold mb-6">
                <span class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent">
                    Everything You Need
                </span>
            </h2>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                Powerful features to manage, monitor, and optimize your AI API usage
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Real-time Analytics</h3>
                <p class="text-gray-400 leading-relaxed">
                    Track your API usage, costs, and performance in real-time with beautiful charts, detailed insights, and customizable dashboards.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#22D3EE]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Cost Tracking</h3>
                <p class="text-gray-400 leading-relaxed">
                    Monitor your spending with detailed cost breakdowns, forecasting, budget alerts, and optimization recommendations.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#3EE48B]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#3EE48B] to-[#6D5CFF] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Smart Rate Limiting</h3>
                <p class="text-gray-400 leading-relaxed">
                    Intelligent rate limiting with automatic alerts, flexible limits, and burst protection to safeguard your API usage.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#6D5CFF]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Lightning Fast</h3>
                <p class="text-gray-400 leading-relaxed">
                    Built for performance with sub-millisecond response times, global CDN, and 99.9% uptime SLA.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#22D3EE]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Enterprise Security</h3>
                <p class="text-gray-400 leading-relaxed">
                    Bank-level encryption, API key management, audit logs, and compliance with industry standards.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="group bg-[#0E1330] rounded-xl p-8 border border-[#1a1f3a] hover:border-[#3EE48B]/50 transition-all hover:transform hover:scale-105">
                <div class="w-16 h-16 bg-gradient-to-r from-[#3EE48B] to-[#6D5CFF] rounded-xl mb-6 flex items-center justify-center group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-3">Easy Integration</h3>
                <p class="text-gray-400 leading-relaxed">
                    Simple REST API, comprehensive documentation, SDKs for popular languages, and webhook support.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="relative bg-gradient-to-r from-[#6D5CFF] via-[#22D3EE] to-[#3EE48B] rounded-3xl p-12 md:p-16 text-center overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 50px 50px;"></div>
            </div>
            
            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to get started?</h2>
                <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-2xl mx-auto">
                    Join thousands of developers using CodexFlow to manage their AI APIs efficiently and cost-effectively.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-[#6D5CFF] rounded-lg font-semibold text-lg hover:opacity-90 transition-all transform hover:scale-105 shadow-xl">
                        Create Free Account
                    </a>
                    <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white rounded-lg font-semibold text-lg hover:bg-white/20 transition-all">
                        Sign In
                    </a>
                </div>
                <p class="text-sm mt-6 opacity-75">No credit card required • Free tier available • Setup in minutes</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-[#1a1f3a] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent mb-4">
                        CodexFlow
                    </h3>
                    <p class="text-gray-400 text-sm">
                        The most powerful AI API management platform for modern developers.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Features</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#22D3EE] transition">About</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Blog</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Terms</a></li>
                        <li><a href="#" class="hover:text-[#22D3EE] transition">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-[#1a1f3a] pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} CodexFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>
@endsection
