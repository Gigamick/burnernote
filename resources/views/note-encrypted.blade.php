@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
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

            @if(count($attachments) > 0)
                <div id="attachments-section" class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 hidden">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Attachments</h3>
                    <div id="attachments-list" class="space-y-2">
                        @foreach($attachments as $attachment)
                            <div class="flex items-center justify-between px-3 py-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg"
                                 data-attachment-id="{{ $attachment['id'] }}"
                                 data-encrypted-filename="{{ $attachment['encrypted_filename'] }}"
                                 data-download-url="{{ $attachment['download_url'] }}"
                                 data-size="{{ $attachment['size'] }}">
                                <div class="flex items-center gap-2 min-w-0">
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    <span class="attachment-filename text-sm text-gray-500 dark:text-gray-400">Decrypting...</span>
                                </div>
                                <button class="download-btn hidden text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    Download
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">Files will burn in 10 minutes</p>
                </div>
            @endif
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

    <script>
        const encryptedNote = @json($encryptedNote);
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

        async function decryptFile(encryptedBlob, key) {
            const combined = new Uint8Array(encryptedBlob);
            const iv = combined.slice(0, 12);
            const data = combined.slice(12);

            const decrypted = await window.crypto.subtle.decrypt(
                { name: 'AES-GCM', iv },
                key,
                data
            );

            return new Uint8Array(decrypted);
        }

        async function decryptAttachments(key) {
            const attachments = document.querySelectorAll('[data-attachment-id]');
            if (attachments.length === 0) return;

            document.getElementById('attachments-section')?.classList.remove('hidden');

            for (const el of attachments) {
                const encryptedFilename = el.dataset.encryptedFilename;
                const downloadUrl = el.dataset.downloadUrl;

                try {
                    const filename = await decrypt(encryptedFilename, key);
                    el.querySelector('.attachment-filename').textContent = filename;
                    el.dataset.filename = filename;

                    const btn = el.querySelector('.download-btn');
                    btn.classList.remove('hidden');
                    btn.onclick = () => downloadAttachment(downloadUrl, filename, key);
                } catch (e) {
                    el.querySelector('.attachment-filename').textContent = 'Unable to decrypt filename';
                }
            }
        }

        async function downloadAttachment(downloadUrl, filename, key) {
            const btn = event.target;
            btn.textContent = 'Downloading...';
            btn.disabled = true;

            try {
                // Fetch encrypted content from server
                const response = await fetch(downloadUrl);
                if (!response.ok) {
                    throw new Error(response.status === 404 ? 'Attachment expired' : 'Download failed');
                }

                const encryptedBlob = await response.arrayBuffer();
                btn.textContent = 'Decrypting...';

                const decrypted = await decryptFile(encryptedBlob, key);

                const blob = new Blob([decrypted]);
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = filename;
                a.click();
                URL.revokeObjectURL(a.href);

                btn.textContent = 'Download';
                btn.disabled = false;
            } catch (e) {
                console.error('Download failed:', e);
                btn.textContent = e.message === 'Attachment expired' ? 'Expired' : 'Failed';
                setTimeout(() => {
                    btn.textContent = 'Download';
                    btn.disabled = false;
                }, 2000);
            }
        }

        let decryptionKey = null;

        async function decryptNote() {
            const loading = document.getElementById('loading');
            const error = document.getElementById('error');
            const content = document.getElementById('note-content');

            // Get key from URL fragment or sessionStorage
            let keyBase64 = window.location.hash.replace('#key=', '');
            if (!keyBase64) {
                keyBase64 = sessionStorage.getItem('burnernote_key');
            }

            if (!keyBase64) {
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                return;
            }

            try {
                const key = await importKey(keyBase64);
                decryptionKey = key;
                const plaintext = await decrypt(encryptedNote, key);

                loading.classList.add('hidden');
                content.textContent = plaintext;
                content.classList.remove('hidden');

                // Decrypt attachment filenames
                await decryptAttachments(key);

                // Clear the key from storage
                sessionStorage.removeItem('burnernote_key');

                // Only clear the hash from URL if no views remaining
                // (so the recipient can reload to view again if views remain)
                if (remainingViews === 0) {
                    history.replaceState(null, '', window.location.pathname);
                }
            } catch (e) {
                console.error('Decryption failed:', e);
                loading.classList.add('hidden');
                error.classList.remove('hidden');
            }
        }

        decryptNote();
    </script>
@endsection
