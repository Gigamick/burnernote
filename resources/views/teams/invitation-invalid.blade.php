@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-8 text-center transition-colors duration-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-50 dark:bg-red-900/20 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Invalid Invitation</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-6">This invitation has expired or is no longer valid.</p>
            <a href="/" class="inline-block px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                Go Home
            </a>
        </div>
    </div>
@endsection
