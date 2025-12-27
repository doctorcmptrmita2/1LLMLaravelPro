<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Dashboard - {{ config('app.name', 'CodexFlow') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#6D5CFF',
                        secondary: '#22D3EE',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="antialiased bg-[#070A12] text-white">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-[#0E1330] border-b border-[#1a1f3a]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-bold bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] bg-clip-text text-transparent">
                            CodexFlow
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-400">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-400 hover:text-white">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar & Main Content -->
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-[#0E1330] min-h-screen border-r border-[#1a1f3a]">
                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('dashboard.analytics') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard.analytics') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        Usage Analytics
                    </a>
                    <a href="{{ route('dashboard.logs') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard.logs') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        API Logs
                    </a>
                    <a href="{{ route('dashboard.rate-limits') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard.rate-limits') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        Rate Limits
                    </a>
                    <a href="{{ route('dashboard.models') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard.models') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        Models
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('dashboard.settings') ? 'bg-[#1a1f3a] border-l-2 border-[#6D5CFF]' : '' }}">
                        Settings
                    </a>
                    @if(auth()->user()->is_admin)
                    <div class="pt-4 mt-4 border-t border-[#1a1f3a]">
                        <a href="{{ route('admin.index') }}" class="block px-4 py-2 rounded-lg hover:bg-[#1a1f3a] transition {{ request()->routeIs('admin.*') ? 'bg-[#1a1f3a] border-l-2 border-[#FF6B6B]' : '' }} text-[#FF6B6B]">
                            Admin Panel
                        </a>
                    </div>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

