@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Receipt not found</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">This receipt doesn't exist or has been removed.</p>

        <a
            href="/"
            class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
        >
            Create a New Note
        </a>
    </div>
@endsection
