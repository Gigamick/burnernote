@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Email sent!</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">We've sent your note link to the email address you provided.</p>

        <a
            href="/"
            class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
        >
            Create Another Note
        </a>
    </div>
@endsection
