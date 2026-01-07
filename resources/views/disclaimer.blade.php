@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-2">You've been sent a self-destructing note</h2>
        <p class="text-gray-500 mb-8">This note can only be accessed once. After viewing, it will be permanently deleted.</p>

        <a
            href="/n/{{ $token }}"
            class="inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200"
        >
            Show Me The Note
        </a>
    </div>
@endsection