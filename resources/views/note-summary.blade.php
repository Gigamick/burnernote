@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <div class="max-w-lg mx-auto px-4 sm:px-6">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-2xl mb-4">
                <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your note is ready</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Share the link below. It can be viewed {{ $note->max_views }} {{ Str::plural('time', $note->max_views) }}.</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-200">
            <!-- Link Section -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Share link</span>
                    <span class="copy-link-success text-xs font-medium text-green-600 dark:text-green-400 hidden">Copied!</span>
                </div>
                <div
                    data-clipboard-target="#link-text"
                    class="copy-link group cursor-pointer"
                >
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition-colors">
                        <p id="link-text" class="text-sm text-gray-800 dark:text-gray-200 font-mono break-all leading-relaxed"></p>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 copy-link-note">Click to copy</p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="p-6 bg-gray-50/50 dark:bg-gray-700/50">
                <div class="flex items-center gap-6">
                    <div id="qrcode" class="flex-shrink-0 bg-white p-3 rounded-xl shadow-sm"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">Scan to share</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Or share via:</p>
                        <div class="flex gap-2 mt-3">
                            <button
                                id="email-toggle"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 hover:border-gray-300 dark:hover:border-gray-400 transition-colors"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Form (Hidden by default) -->
        <div id="email-form-container" class="hidden mt-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-200">
                <form id="email-form" method="post" action="/send-email" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Send link to</label>
                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="recipient@example.com"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        >
                    </div>
                    <input type="hidden" name="link" id="email-link" value="">
                    <button
                        type="submit"
                        class="w-full px-4 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors"
                    >
                        Send Email
                    </button>
                </form>
            </div>
        </div>

        <!-- Zero Knowledge + Receipt -->
        <div class="mt-6 space-y-3">
            <!-- E2E Badge -->
            <div class="flex items-center gap-3 px-4 py-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <p class="text-sm text-green-800 dark:text-green-300">
                    <span class="font-medium">End-to-end encrypted.</span>
                    <span class="text-green-700 dark:text-green-400">The key is in the URL. We never see it.</span>
                </p>
            </div>

            <!-- Receipt Link -->
            <div
                data-clipboard-target="#receipt-text"
                class="copy-receipt flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-800 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group"
            >
                <div class="w-8 h-8 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-medium">Track read status</span>
                        <span class="text-gray-400 dark:text-gray-500 mx-1">·</span>
                        <span class="copy-receipt-note text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300">Click to copy tracking link</span>
                        <span class="copy-receipt-success text-green-600 dark:text-green-400 hidden">Copied!</span>
                    </p>
                </div>
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <input type="hidden" id="receipt-text" value="{{ config('app.url') }}/r/{{ $receipt->token }}">
        </div>

        <!-- Create Another -->
        <div class="text-center mt-8">
            <a href="/" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                Create another note
            </a>
        </div>
    </div>

    <script>
        // Get the encryption key from sessionStorage
        const key = sessionStorage.getItem('burnernote_key');
        const baseUrl = "{{ config('app.url') }}/v/{{ $note->token }}";
        const fullUrl = key ? `${baseUrl}#key=${key}` : baseUrl;

        // Set the link text
        document.getElementById('link-text').textContent = fullUrl;
        document.getElementById('email-link').value = fullUrl;

        // Clear the key from sessionStorage
        sessionStorage.removeItem('burnernote_key');

        // Toggle email form
        document.getElementById('email-toggle').addEventListener('click', function() {
            const container = document.getElementById('email-form-container');
            container.classList.toggle('hidden');
            if (!container.classList.contains('hidden')) {
                container.querySelector('input[type="email"]').focus();
            }
        });

        // Clipboard for main link
        var clipboardLink = new ClipboardJS('.copy-link');
        clipboardLink.on('success', function (e) {
            document.querySelector('.copy-link-success').classList.remove('hidden');
            document.querySelector('.copy-link-note').classList.add('hidden');
            e.clearSelection();
            setTimeout(() => {
                document.querySelector('.copy-link-success').classList.add('hidden');
                document.querySelector('.copy-link-note').classList.remove('hidden');
            }, 2000);
        });

        // Clipboard for receipt
        var clipboardReceipt = new ClipboardJS('.copy-receipt');
        clipboardReceipt.on('success', function (e) {
            document.querySelector('.copy-receipt-success').classList.remove('hidden');
            document.querySelector('.copy-receipt-note').classList.add('hidden');
            e.clearSelection();
            setTimeout(() => {
                document.querySelector('.copy-receipt-success').classList.add('hidden');
                document.querySelector('.copy-receipt-note').classList.remove('hidden');
            }, 2000);
        });

        // Generate QR code
        new QRCode(document.getElementById("qrcode"), {
            text: fullUrl,
            width: 100,
            height: 100,
            colorDark: "#111827",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.L
        });
    </script>
@endsection
