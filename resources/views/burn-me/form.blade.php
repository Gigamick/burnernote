@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Send a private note to {{ $recipient->first_name }}
            </h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Your message will be encrypted and can only be read once.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            <form id="burn-me-form" method="POST" action="{{ route('burn-me.store', $slug) }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Your message</label>
                    <p class="text-md text-gray-400">Remember to include your name in the message if you want them to know who you are.</p>
                    <textarea
                        rows="6"
                        id="note-input"
                        name="note"
                        required
                        class="w-full px-4 py-3 mt-4 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 resize-none placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        placeholder="Write your private message here..."
                    ></textarea>
                    @error('note')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="client_key" id="client-key">

                <button
                    type="submit"
                    id="submit-btn"
                    class="w-full px-6 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
                >
                    Send Note
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400 dark:text-gray-500">
                Encrypted in your browser. {{ $recipient->first_name }} will receive an email notification.
            </p>
        </div>
    </div>

    <script type="module">
        async function generateKey() {
            return await window.crypto.subtle.generateKey(
                { name: 'AES-GCM', length: 256 },
                true,
                ['encrypt', 'decrypt']
            );
        }

        async function exportKey(key) {
            const exported = await window.crypto.subtle.exportKey('raw', key);
            return btoa(String.fromCharCode(...new Uint8Array(exported)));
        }

        async function encrypt(plaintext, key) {
            const encoder = new TextEncoder();
            const data = encoder.encode(plaintext);
            const iv = window.crypto.getRandomValues(new Uint8Array(12));

            const encrypted = await window.crypto.subtle.encrypt(
                { name: 'AES-GCM', iv },
                key,
                data
            );

            const combined = new Uint8Array(iv.length + encrypted.byteLength);
            combined.set(iv);
            combined.set(new Uint8Array(encrypted), iv.length);

            return btoa(String.fromCharCode(...combined));
        }

        document.getElementById('burn-me-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('submit-btn');
            const noteInput = document.getElementById('note-input');
            const clientKeyInput = document.getElementById('client-key');
            const plaintext = noteInput.value;

            btn.disabled = true;
            btn.textContent = 'Encrypting...';

            try {
                const key = await generateKey();
                const exportedKey = await exportKey(key);
                const encrypted = await encrypt(plaintext, key);

                // Replace plaintext with encrypted content
                noteInput.value = encrypted;
                // Send the key so server can include it in email
                clientKeyInput.value = exportedKey;

                // Brief delay to show encryption happened
                btn.textContent = 'Encrypted!';
                await new Promise(resolve => setTimeout(resolve, 1000));

                // Submit the form
                this.submit();
            } catch (err) {
                console.error('Encryption failed:', err);
                btn.disabled = false;
                btn.textContent = 'Send Note';
                alert('Encryption failed. Please try again.');
            }
        });
    </script>
@endsection
