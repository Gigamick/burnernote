@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
            Note sent
        </h1>

        <p class="text-gray-500 dark:text-gray-400 mb-8">
            Your encrypted note has been sent to {{ $recipient->first_name }}. They'll receive an email notification.
        </p>

        <div class="space-y-3">
            <a
                href="{{ route('burn-me.show', $recipient->burn_me_slug) }}"
                class="block w-full px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-all duration-200"
            >
                Send Another Note
            </a>

            <a
                href="/"
                class="block w-full px-6 py-3 text-gray-600 dark:text-gray-400 font-medium hover:text-gray-900 dark:hover:text-white transition-colors"
            >
                Go to Burner Note
            </a>
        </div>
    </div>
@endsection
