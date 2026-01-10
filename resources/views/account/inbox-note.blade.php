@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="mb-6">
            <a href="{{ route('account.inbox') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">&larr; Back to Inbox</a>
        </div>

        <div id="note-container" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            <div id="loading" class="text-center text-gray-500 dark:text-gray-400">
                <svg class="animate-spin h-6 w-6 mx-auto mb-2 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Decrypting...
            </div>
            <div id="error" class="hidden text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl mb-3">
                    <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <p class="text-red-600 dark:text-red-400 font-medium">Unable to decrypt this note</p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">The decryption key may be missing or invalid.</p>
            </div>
            <p id="note-content" class="text-gray-900 dark:text-white whitespace-pre-wrap leading-relaxed hidden"></p>
        </div>

        <div class="text-center mt-6">
            @if($remainingViews > 0)
                <p class="text-gray-600 dark:text-gray-400 mb-2">This note can be viewed {{ $remainingViews }} more {{ Str::plural('time', $remainingViews) }}</p>
            @else
                <p class="text-gray-600 dark:text-gray-400 mb-2">This note has been permanently deleted</p>
            @endif
            <a href="{{ route('account.inbox') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline transition-colors">
                Back to Inbox
            </a>
        </div>
    </div>

    <script>
        const encryptedNote = @json($encryptedNote);
        const clientKey = @json($clientKey);
        const remainingViews = {{ $remainingViews }};

        async function importKey(base64Key) {
            const keyData = Uint8Array.from(atob(base64Key), c => c.charCodeAt(0));
            return await window.crypto.subtle.importKey(
                'raw',
                keyData,
                { name: 'AES-GCM', length: 256 },
                false,
                ['decrypt']
            );
        }

        async function decrypt(ciphertext, key) {
            const combined = Uint8Array.from(atob(ciphertext), c => c.charCodeAt(0));
            const iv = combined.slice(0, 12);
            const data = combined.slice(12);

            const decrypted = await window.crypto.subtle.decrypt(
                { name: 'AES-GCM', iv },
                key,
                data
            );

            const decoder = new TextDecoder();
            return decoder.decode(decrypted);
        }

        async function decryptNote() {
            const loading = document.getElementById('loading');
            const error = document.getElementById('error');
            const content = document.getElementById('note-content');

            if (!clientKey) {
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                return;
            }

            try {
                const key = await importKey(clientKey);
                const plaintext = await decrypt(encryptedNote, key);

                loading.classList.add('hidden');
                content.textContent = plaintext;
                content.classList.remove('hidden');
            } catch (e) {
                console.error('Decryption failed:', e);
                loading.classList.add('hidden');
                error.classList.remove('hidden');
            }
        }

        decryptNote();
    </script>
@endsection
