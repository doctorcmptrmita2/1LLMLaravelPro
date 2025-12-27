@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">AI Models</h1>
        <p class="text-gray-400">Browse and manage available AI models</p>
    </div>

    <!-- Models Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="models-grid">
        <!-- Model cards will be loaded here -->
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-semibold mb-1">GPT-4</h3>
                    <p class="text-sm text-gray-400">gpt-4</p>
                </div>
                <button class="text-gray-400 hover:text-[#6D5CFF] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Cost per 1K tokens:</span>
                    <span class="font-semibold">$0.03</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Status:</span>
                    <span class="text-green-400">Available</span>
                </div>
            </div>
            <p class="text-sm text-gray-400">Most capable model, best for complex tasks</p>
        </div>
    </div>
@endsection

