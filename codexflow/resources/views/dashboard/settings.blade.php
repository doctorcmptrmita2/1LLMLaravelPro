@extends('layouts.dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Settings</h1>
        <p class="text-gray-400">Manage your account settings and API keys</p>
    </div>

    <!-- API Key Section -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">API Key</h3>
        <div class="flex items-center space-x-4">
            <input type="text" readonly value="{{ auth()->user()->api_key }}" 
                class="flex-1 px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white font-mono text-sm" 
                id="api-key-input">
            <button onclick="copyApiKey()" class="px-4 py-2 bg-[#1a1f3a] border border-[#6D5CFF] rounded-lg hover:bg-[#6D5CFF]/10 transition">
                Copy
            </button>
            <button onclick="regenerateApiKey()" class="px-4 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                Regenerate
            </button>
        </div>
        <p class="text-sm text-gray-400 mt-2">Keep your API key secure. Never share it publicly.</p>
    </div>

    <!-- Account Settings -->
    <div class="bg-[#0E1330] rounded-lg p-6 border border-[#1a1f3a] mb-8">
        <h3 class="text-lg font-semibold mb-4">Account Information</h3>
        <form class="space-y-4">
            <div>
                <label class="block text-sm text-gray-400 mb-2">Name</label>
                <input type="text" value="{{ auth()->user()->name }}" 
                    class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" 
                    class="w-full px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-2">Plan</label>
                <div class="px-4 py-2 bg-[#1a1f3a] border border-[#1a1f3a] rounded-lg">
                    <span class="text-white capitalize">{{ auth()->user()->plan }}</span>
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] rounded-lg font-semibold hover:opacity-90 transition">
                Save Changes
            </button>
        </form>
    </div>

    <script>
        function copyApiKey() {
            const input = document.getElementById('api-key-input');
            input.select();
            document.execCommand('copy');
            alert('API key copied to clipboard!');
        }

        function regenerateApiKey() {
            if (confirm('Are you sure you want to regenerate your API key? The old key will no longer work.')) {
                // TODO: Implement API call to regenerate key
                alert('API key regeneration not yet implemented');
            }
        }
    </script>
@endsection

