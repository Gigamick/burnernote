@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        @if($receipt->status === 'pending')
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Waiting to be read</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Your note hasn't been opened yet.</p>
            <p class="text-sm text-gray-400 dark:text-gray-500">Expires {{ $receipt->expires_at->diffForHumans() }}</p>
        @elseif($receipt->status === 'viewed')
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Note was read</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Your note was opened and destroyed.</p>
            <p class="text-sm text-gray-400 dark:text-gray-500">Viewed {{ $receipt->viewed_at->diffForHumans() }}</p>
        @else
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl mb-6">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Note expired</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Your note expired before it was read and has been deleted.</p>
        @endif

        <div class="mt-8">
            <a
                href="/"
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
            >
                Create Another Note
            </a>
        </div>
    </div>
@endsection
