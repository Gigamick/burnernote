@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create your account</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Enter your email to get started</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                    <p class="text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="register" value="1">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email address</label>
                    <input
                        type="email"
                        name="email"
                        required
                        autofocus
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-size="flexible"></div>
                @error('cf-turnstile-response')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
                >
                    Create Account
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            We'll send you a link to verify your email and complete your account.
        </p>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gray-900 dark:text-white font-medium hover:underline">Sign in</a>
        </p>
    </div>
@endsection
