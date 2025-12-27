@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.index') }}" class="text-[#22D3EE] hover:underline mb-4 inline-block">← Back to Users</a>
        <h1 class="text-3xl font-bold mb-2">User Details</h1>
        <p class="text-gray-400">{{ $user->email }}</p>
    </div>

    <!-- User Info -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">User Information</h3>
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Plan</label>
                    <select name="plan" class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                        <option value="starter" {{ $user->plan === 'starter' ? 'selected' : '' }}>Starter</option>
                        <option value="pro" {{ $user->plan === 'pro' ? 'selected' : '' }}>Pro</option>
                        <option value="agency" {{ $user->plan === 'agency' ? 'selected' : '' }}>Agency</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">
                        <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}
                            class="mr-2">
                        Admin User
                    </label>
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                Update User
            </button>
        </form>
    </div>

    <!-- API Key Management -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">API Key Management</h3>
        <form action="{{ route('admin.users.update-api-key', $user) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-2">Current API Key</label>
                <div class="flex items-center space-x-4">
                    <input type="text" name="api_key" value="{{ $user->api_key }}" required
                        class="flex-1 px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white font-mono text-sm">
                    <button type="button" onclick="copyToClipboard('{{ $user->api_key }}')" 
                        class="px-4 py-2 bg-[#1a1f3a] border border-[#6D5CFF] rounded-lg hover:bg-[#6D5CFF]/10 transition">
                        Copy
                    </button>
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                Update API Key
            </button>
        </form>
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
        <div class="flex space-x-4">
            @if($user->status === 'active')
                <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-red-500/20 border border-red-500/50 text-red-400 rounded-lg hover:bg-red-500/30 transition">
                        Suspend User
                    </button>
                </form>
            @else
                <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg hover:bg-green-500/30 transition">
                        Activate User
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Recent API Logs -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
        <h3 class="text-lg font-semibold mb-4">Recent API Logs</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#1a1f3a]">
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Model</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Tokens</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Cost</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Status</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->apiLogs as $log)
                        <tr class="border-b border-[#1a1f3a]">
                            <td class="py-3 px-4">{{ $log->model }}</td>
                            <td class="py-3 px-4">{{ number_format($log->input_tokens + $log->output_tokens) }}</td>
                            <td class="py-3 px-4">${{ number_format($log->total_cost, 4) }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs {{ $log->status === 'success' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $log->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-400 text-sm">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">No API logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('API key copied to clipboard!');
            });
        }
    </script>
@endsection

