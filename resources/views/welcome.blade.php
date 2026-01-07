@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                Send notes that self-destruct when they're read
            </h1>
            <p class="mt-2 text-2xl text-gray-600 dark:text-gray-400 leading-relaxed">
                Encrypted in your browser. Zero knowledge. No tracking.
            </p>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                Free, ad-free, and open source.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            <form id="note-form" method="post" action="/create-note" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Create your note</label>
                    <textarea
                        rows="4"
                        id="note-input"
                        name="note"
                        required
                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 resize-none placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        placeholder="Write your secret message here..."
                    ></textarea>
                </div>

                <!-- Advanced Options Toggle -->
                <button
                    type="button"
                    id="advanced-toggle"
                    class="text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                >
                    Advanced options
                </button>

                <!-- Advanced Options (Hidden by default) -->
                <div id="advanced-options" class="grid grid-rows-[0fr] opacity-0 transition-all duration-300 ease-out">
                    <div class="overflow-hidden space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password protection</label>
                        <input
                            type="text"
                            name="password"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Optional password"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Days till expiry</label>
                            <input
                                type="number"
                                min="1"
                                max="30"
                                name="expiry"
                                value="7"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Allowed views</label>
                            <input
                                type="number"
                                min="1"
                                max="10"
                                name="max_views"
                                value="1"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notify when read</label>
                        <input
                            type="email"
                            name="notify_email"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="your@email.com"
                        >
                    </div>
                    </div>
                </div>

                <input type="hidden" name="client_encrypted" value="1">

                <button
                    type="submit"
                    id="submit-btn"
                    class="w-full px-6 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
                >
                    Get Link
                </button>
            </form>
        </div>

        <!-- Burn Counter -->
        <div class="flex items-center justify-center gap-2 mt-8 text-sm text-gray-400 dark:text-gray-500">
            <span class="relative flex h-1.5 w-1.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-orange-500"></span>
            </span>
            <span>{{ number_format($burnCount) }} notes securely destroyed</span>
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

        // Advanced options toggle
        const advancedToggle = document.getElementById('advanced-toggle');
        const advancedOptions = document.getElementById('advanced-options');
        let isOpen = false;

        advancedToggle.addEventListener('click', function() {
            isOpen = !isOpen;
            if (isOpen) {
                advancedOptions.classList.remove('grid-rows-[0fr]', 'opacity-0');
                advancedOptions.classList.add('grid-rows-[1fr]', 'opacity-100');
            } else {
                advancedOptions.classList.remove('grid-rows-[1fr]', 'opacity-100');
                advancedOptions.classList.add('grid-rows-[0fr]', 'opacity-0');
            }
            this.textContent = isOpen ? 'Hide options' : 'Advanced options';
        });

        document.getElementById('note-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('submit-btn');
            const noteInput = document.getElementById('note-input');
            const plaintext = noteInput.value;

            btn.disabled = true;
            btn.textContent = 'Encrypting...';

            try {
                const key = await generateKey();
                const exportedKey = await exportKey(key);
                const encrypted = await encrypt(plaintext, key);

                // Store key in sessionStorage for the summary page
                sessionStorage.setItem('burnernote_key', exportedKey);

                // Replace plaintext with encrypted content
                noteInput.value = encrypted;

                // Submit the form
                this.submit();
            } catch (err) {
                console.error('Encryption failed:', err);
                btn.disabled = false;
                btn.textContent = 'Get Link';
                alert('Encryption failed. Please try again.');
            }
        });
    </script>
@endsection
