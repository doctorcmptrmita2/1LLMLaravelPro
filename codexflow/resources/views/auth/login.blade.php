@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Sign in to CodexFlow
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Or
                <a href="{{ route('register') }}" class="font-medium text-[#6D5CFF] hover:text-[#22D3EE]">
                    create a new account
                </a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-[#1a1f3a] bg-[#0E1330] text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-[#6D5CFF] focus:border-[#6D5CFF] focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                        placeholder="Email address" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none relative block w-full px-3 py-2 border border-[#1a1f3a] bg-[#0E1330] text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-[#6D5CFF] focus:border-[#6D5CFF] focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                        placeholder="Password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 text-[#6D5CFF] focus:ring-[#6D5CFF] border-[#1a1f3a] rounded bg-[#0E1330]">
                    <label for="remember" class="ml-2 block text-sm text-gray-400">
                        Remember me
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-[#6D5CFF] to-[#22D3EE] hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6D5CFF]">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

