@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Rate Limits</h1>
        <p class="text-gray-400">Monitor and manage your API rate limits</p>
    </div>

    <!-- Rate Limits Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Daily Limits -->
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-lg font-semibold mb-4">Daily Limits</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Tokens</span>
                        <span id="daily-tokens">0 / 0</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-3">
                        <div class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] h-3 rounded-full" id="daily-tokens-progress" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Requests</span>
                        <span id="daily-requests">0 / 0</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-3">
                        <div class="bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] h-3 rounded-full" id="daily-requests-progress" style="width: 0%"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#1a1f3a]">
                    <p class="text-sm text-gray-400">Resets in: <span id="daily-reset">-</span></p>
                </div>
            </div>
        </div>

        <!-- Monthly Limits -->
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-lg font-semibold mb-4">Monthly Limits</h3>
            
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Tokens</span>
                        <span id="monthly-tokens">0 / 0</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-3">
                        <div class="bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] h-3 rounded-full" id="monthly-tokens-progress" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-400">Requests</span>
                        <span id="monthly-requests">0 / 0</span>
                    </div>
                    <div class="w-full bg-[#1a1f3a] rounded-full h-3">
                        <div class="bg-gradient-to-r from-[#22D3EE] to-[#3EE48B] h-3 rounded-full" id="monthly-requests-progress" style="width: 0%"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#1a1f3a]">
                    <p class="text-sm text-gray-400">Resets in: <span id="monthly-reset">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Increase -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
        <h3 class="text-lg font-semibold mb-4">Request Limit Increase</h3>
        <p class="text-gray-400 mb-4">Need higher limits? Request an increase to your plan.</p>
        <button class="px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
            Request Increase
        </button>
    </div>
@endsection

