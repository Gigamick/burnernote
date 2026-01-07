@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-2xl mb-6">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">You've been sent a self-destructing note</h2>
        @if($remainingViews === 1)
            <p class="text-gray-500 dark:text-gray-400 mb-8">This note can only be viewed once. After viewing, it will be permanently deleted.</p>
        @else
            <p class="text-gray-500 dark:text-gray-400 mb-8">This note can be viewed {{ $remainingViews }} more times. After that, it will be permanently deleted.</p>
        @endif

        <a
            id="show-note-btn"
            href="/n/{{ $token }}"
            class="inline-flex items-center justify-center px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
        >
            Show Me The Note
        </a>
    </div>

    <script>
        // Preserve the encryption key from URL fragment
        const hash = window.location.hash;
        if (hash && hash.startsWith('#key=')) {
            const key = hash.replace('#key=', '');
            sessionStorage.setItem('burnernote_key', key);

            // Update the link to include the hash
            const btn = document.getElementById('show-note-btn');
            btn.href = btn.href + hash;
        }
    </script>
@endsection
