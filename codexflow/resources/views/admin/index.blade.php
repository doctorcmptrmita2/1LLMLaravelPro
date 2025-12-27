@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Admin Panel</h1>
        <p class="text-gray-400">Manage users and API keys</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-sm text-gray-400 mb-2">Total Users</h3>
            <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-sm text-gray-400 mb-2">Active Users</h3>
            <p class="text-3xl font-bold text-green-400">{{ $stats['active_users'] }}</p>
        </div>
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-sm text-gray-400 mb-2">Suspended</h3>
            <p class="text-3xl font-bold text-red-400">{{ $stats['suspended_users'] }}</p>
        </div>
        <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
            <h3 class="text-sm text-gray-400 mb-2">Total API Calls</h3>
            <p class="text-3xl font-bold">{{ number_format($stats['total_api_calls']) }}</p>
        </div>
    </div>

    <!-- Assign API Key Form -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">Assign API Key to User</h3>
        <form action="{{ route('admin.users.assign-api-key') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-2">Email Address</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white"
                    placeholder="doctor.cmptr.mita2@gmail.com">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">API Key</label>
                <input type="text" name="api_key" required 
                    class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white font-mono text-sm"
                    placeholder="sk-7Cif43XHbgNSMtSIaul_Xw">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                    Assign API Key
                </button>
            </div>
        </form>
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mt-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Users Table -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a]">
        <h3 class="text-lg font-semibold mb-4">All Users</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#1a1f3a]">
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">ID</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Name</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Email</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">API Key</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Plan</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Status</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Admin</th>
                        <th class="text-left py-3 px-4 text-gray-400 text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-[#1a1f3a] hover:bg-[#1a1f3a]">
                            <td class="py-3 px-4">{{ $user->id }}</td>
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <code class="text-xs text-gray-400">{{ $user->api_key ? substr($user->api_key, 0, 20) . '...' : 'N/A' }}</code>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs capitalize">{{ $user->plan }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs {{ $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 rounded text-xs bg-purple-500/20 text-purple-400">Admin</span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-[#22D3EE] hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-400">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection

