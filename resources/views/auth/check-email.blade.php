@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Check your email</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-2">
            @if(session('is_registration'))
                We've sent a verification link to
            @else
                We've sent a magic link to
            @endif
        </p>
        @if(session('email'))
            <p class="text-gray-900 dark:text-white font-medium mb-6">{{ session('email') }}</p>
        @endif
        <p class="text-sm text-gray-400 dark:text-gray-500">
            @if(session('is_registration'))
                Click the link in the email to verify your account and complete setup. The link expires in 15 minutes.
            @else
                Click the link in the email to sign in. The link expires in 15 minutes.
            @endif
        </p>

        <div class="mt-8">
            <a
                href="{{ session('is_registration') ? route('register') : route('login') }}"
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
            >
                Didn't receive it? Try again
            </a>
        </div>
    </div>
@endsection
