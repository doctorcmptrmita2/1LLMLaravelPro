@extends('layouts.dashboard')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">API Logs</h1>
            <p class="text-gray-400">View and filter your API request logs</p>
        </div>
        <button class="px-4 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
            Export CSV
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-gray-400 mb-2">Model</label>
                <select class="w-full px-3 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                    <option>All Models</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">Status</label>
                <select class="w-full px-3 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                    <option>All Status</option>
                    <option>Success</option>
                    <option>Error</option>
                    <option>Rate Limited</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">Date From</label>
                <input type="date" class="w-full px-3 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">Date To</label>
                <input type="date" class="w-full px-3 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#1a1f3a]">
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Date</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Model</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Input Tokens</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Output Tokens</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Total Cost</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Response Time</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Status</th>
                    </tr>
                </thead>
                <tbody id="logs-table-body">
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400">No logs found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

