@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">About Burner Note</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 space-y-8 transition-colors duration-200">
            <!-- TL;DR -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">TL;DR</h2>
                <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Your note is encrypted in your browser before it leaves your device</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>The decryption key never touches our servers</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>We cannot read your notes, even if compelled to</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Notes are permanently deleted after being read</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Verify it yourself: Burner Note is <a href="https://github.com/GigaMick/burnernote" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">open source</a></span>
                    </li>
                </ul>
            </div>

            <!-- Story -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">The Story</h2>
                <p>
                    Burner Note exists because a lot of "burn after reading" note sites are noisy, ad-heavy, and opaque. You're expected to trust that they encrypt and delete data as advertised.
                </p>
                <p>
                    As a developer, I wanted something faster to use and easier to verify. Burner Note is that: a simple UI, strong defaults, and technical transparency.
                </p>
            </div>

            <!-- Technical Details -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">How the Encryption Works</h2>

                <p>
                    Burner Note uses <strong class="text-gray-900 dark:text-white">client-side encryption</strong> with a zero-knowledge architecture. Your note is encrypted in your browser before it ever leaves your device, and the decryption key is never sent to our servers.
                </p>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 font-mono text-sm space-y-3">
                    <p class="text-gray-500 dark:text-gray-400">// When you create a note:</p>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>A 256-bit AES-GCM key is generated in your browser using the <a href="https://developer.mozilla.org/en-US/docs/Web/API/Web_Crypto_API" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">Web Crypto API</a></li>
                        <li>Your note is encrypted client-side with this key</li>
                        <li>Only the encrypted ciphertext is sent to our server</li>
                        <li>The key is placed in the URL fragment (the part after <code class="bg-gray-200 dark:bg-gray-600 px-1 rounded">#</code>)</li>
                    </ol>
                </div>

                <p>
                    The URL fragment is crucial to our zero-knowledge design. Per the <a href="https://www.rfc-editor.org/rfc/rfc3986#section-3.5" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">URI specification (RFC 3986)</a>, the fragment identifier is never sent to the server in HTTP requests. It exists only in the browser. This means the decryption key cannot reach our servers through normal operation.
                </p>

                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-5 text-amber-800 dark:text-amber-200">
                    <p class="font-medium mb-2">What this means in practice:</p>
                    <p class="text-sm">
                        Even if our servers were compromised, or we received a legal demand for your data, we could only hand over encrypted ciphertext. Without the key (which we never had), the data is computationally indistinguishable from random noise.
                    </p>
                </div>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">Limitations</h3>
                <p>
                    As with any client-side encryption system, Burner Note cannot protect against a compromised device, malicious browser extensions, or someone manually copying the decrypted text after opening a note.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">The Cipher</h3>
                <p>
                    We use <strong class="text-gray-900 dark:text-white">AES-256-GCM</strong> (Advanced Encryption Standard with Galois/Counter Mode). This is an authenticated encryption algorithm that provides both confidentiality and integrity. The "256" refers to the key size in bits; the "GCM" mode provides authentication, meaning any tampering with the ciphertext will be detected during decryption.
                </p>
                <p>
                    A random 96-bit IV (initialization vector) is generated for each note and prepended to the ciphertext. This ensures that encrypting the same plaintext twice produces different ciphertext.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">Defense in Depth</h3>
                <p>
                    In addition to client-side encryption, we apply a second layer of encryption at rest using <a href="https://laravel.com/docs/encryption" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">Laravel's encryption</a> (AES-256-CBC with HMAC). This protects against database leaks and provides an additional barrier, though the client-side encryption is the primary security layer.
                </p>

                <h3 class="text-md font-semibold text-gray-900 dark:text-white pt-2">Deletion</h3>
                <p>
                    When a note reaches its view limit, it is immediately deleted from our database. We don't soft-delete or archive. The SQL <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-800 dark:text-gray-200">DELETE</code> is executed synchronously before the response is returned. Once deleted, the ciphertext is gone forever.
                </p>
            </div>

            <!-- Open Source -->
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Open Source</h2>
                <p>
                    Don't trust us? Good. You shouldn't have to. Burner Note is completely <a href="https://github.com/GigaMick/burnernote" target="_blank" class="text-gray-900 dark:text-white underline hover:text-gray-700 dark:hover:text-gray-300">open source</a>. Review the encryption implementation in <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-800 dark:text-gray-200">welcome.blade.php</code> and the decryption in <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-gray-800 dark:text-gray-200">note-encrypted.blade.php</code>. The entire codebase is available for inspection.
                </p>
                <p class="font-medium text-gray-900 dark:text-white">
                    That's the point.
                </p>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 dark:border-gray-700 my-10"></div>

        <!-- Created by Dept91 -->
        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col items-center gap-4 text-center">
                <p class="text-gray-600 dark:text-gray-400">Burner Note was created by</p>
                <a href="https://dept91.com" target="_blank">
                    <img src="/img/dept91-logo-3.png" alt="Dept91" class="h-8 dark:invert">
                </a>
            </div>
        </div>
    </div>
@endsection
