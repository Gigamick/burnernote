@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            <p class="text-gray-900 dark:text-white whitespace-pre-wrap leading-relaxed">{{ $actualnote }}</p>
        </div>

        <div class="text-center mt-6">
            @if($remainingViews > 0)
                <p class="text-gray-600 dark:text-gray-400 mb-2">This note can be viewed {{ $remainingViews }} more {{ Str::plural('time', $remainingViews) }}</p>
            @else
                <p class="text-gray-600 dark:text-gray-400 mb-2">This note has been permanently deleted</p>
            @endif
            <a href="/" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline transition-colors">
                Create your own Burner Note
            </a>
        </div>
    </div>
@endsection
