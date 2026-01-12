@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                Send notes that self-destruct when read
            </h1>
            <p class="mt-2 text-xl text-gray-600 dark:text-gray-400 leading-relaxed">
                Encrypted in your browser. Zero knowledge. No tracking.
            </p>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                Free, ad-free, and open source.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Form Card -->
        @php
            $isPro = $team || $isIndividual;
            $requirePassword = $team ? $team->policy_require_password : ($user?->default_require_password ?? false);
            $minExpiry = $team ? $team->policy_min_expiry_days : ($user?->default_min_expiry_days ?? 1);
            $maxExpiry = $team ? $team->policy_max_expiry_days : ($user?->default_max_expiry_days ?? 30);
            $maxViews = $team ? $team->policy_max_view_limit : ($user?->default_max_view_limit ?? 10);
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200 relative">
            @if($team)
                <span class="absolute top-4 right-4 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-full">Team Mode</span>
            @elseif($isIndividual)
                <span class="absolute top-4 right-4 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-full">Pro</span>
            @endif

            <form id="note-form" method="post" action="/create-note" class="space-y-6">
                @csrf
                @if($team)
                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                @endif

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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Password protection
                            @if($requirePassword)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input
                            type="text"
                            name="password"
                            @if($requirePassword) required @endif
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="{{ $requirePassword ? 'Required password' : 'Optional password' }}"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Days till expiry</label>
                            <input
                                type="number"
                                min="{{ $minExpiry }}"
                                max="{{ $maxExpiry }}"
                                name="expiry"
                                value="{{ min(7, $maxExpiry) }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Allowed views
                                @unless($isPro)
                                    <a href="/pro" class="text-xs text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 font-normal ml-1">Pro</a>
                                @endunless
                            </label>
                            @if($isPro)
                                <input
                                    type="number"
                                    min="1"
                                    max="{{ $maxViews }}"
                                    name="max_views"
                                    value="1"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                                >
                            @else
                                <input type="hidden" name="max_views" value="1">
                                <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 dark:text-gray-500">
                                    1 view (burn after reading)
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Read receipts
                            @unless($isPro)
                                <a href="/pro" class="text-xs text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 font-normal ml-1">Pro</a>
                            @endunless
                        </label>
                        @if($isPro)
                            <input
                                type="email"
                                name="notify_email"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                                placeholder="your@email.com"
                            >
                        @else
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 dark:text-gray-500">
                                Get notified when your note is read
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            File attachments
                            @if($isPro)
                                <span class="text-xs text-gray-400 dark:text-gray-500 font-normal ml-1">(max 5 files, 25MB each)</span>
                            @else
                                <a href="/pro" class="text-xs text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 font-normal ml-1">Pro</a>
                            @endif
                        </label>
                        @if($isPro)
                            <input type="file" id="file-input" multiple class="hidden">
                            <div id="file-list" class="space-y-2 mb-2"></div>
                            <button
                                type="button"
                                id="add-files-btn"
                                class="w-full px-4 py-3 border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 dark:text-gray-500 hover:border-gray-300 dark:hover:border-gray-500 hover:text-gray-500 dark:hover:text-gray-400 transition-all duration-200"
                            >
                                + Add files
                            </button>
                        @else
                            <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 dark:text-gray-500">
                                Attach encrypted files to your note
                            </div>
                        @endif
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
        const MAX_FILES = 5;
        const MAX_SIZE = 25 * 1024 * 1024; // 25MB
        const files = [];

        // Convert Uint8Array to base64 without stack overflow on large files
        function arrayToBase64(bytes) {
            let binary = '';
            const chunkSize = 32768; // Process in 32KB chunks
            for (let i = 0; i < bytes.length; i += chunkSize) {
                const chunk = bytes.subarray(i, Math.min(i + chunkSize, bytes.length));
                binary += String.fromCharCode.apply(null, chunk);
            }
            return btoa(binary);
        }

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

        async function encryptFile(file, key) {
            const arrayBuffer = await file.arrayBuffer();
            const data = new Uint8Array(arrayBuffer);
            const iv = window.crypto.getRandomValues(new Uint8Array(12));

            const encrypted = await window.crypto.subtle.encrypt(
                { name: 'AES-GCM', iv },
                key,
                data
            );

            const combined = new Uint8Array(iv.length + encrypted.byteLength);
            combined.set(iv);
            combined.set(new Uint8Array(encrypted), iv.length);

            const encryptedFilename = await encrypt(file.name, key);

            return {
                blob: combined,
                encryptedFilename,
                mimeType: file.type,
                size: file.size,
            };
        }

        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function renderFileList() {
            const list = document.getElementById('file-list');
            const addBtn = document.getElementById('add-files-btn');
            if (!list || !addBtn) return;

            list.innerHTML = files.map((file, index) => `
                <div class="flex items-center justify-between px-3 py-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center gap-2 min-w-0">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300 truncate">${file.name}</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">${formatFileSize(file.size)}</span>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `).join('');

            addBtn.style.display = files.length >= MAX_FILES ? 'none' : 'block';
        }

        window.removeFile = function(index) {
            files.splice(index, 1);
            renderFileList();
        };

        // File attachment handlers (Pro only)
        const addFilesBtn = document.getElementById('add-files-btn');
        const fileInput = document.getElementById('file-input');

        if (addFilesBtn && fileInput) {
            addFilesBtn.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', function(e) {
                for (const file of e.target.files) {
                    if (files.length >= MAX_FILES) {
                        alert('Maximum 5 files allowed');
                        break;
                    }
                    if (file.size > MAX_SIZE) {
                        alert(`${file.name} exceeds 25MB limit`);
                        continue;
                    }
                    files.push(file);
                }
                renderFileList();
                e.target.value = '';
            });
        }

        async function uploadEncryptedFiles(key) {
            const attachmentIds = [];
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const btn = document.getElementById('submit-btn');
            const total = files.length;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const tempId = crypto.randomUUID();
                const shortName = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
                const progress = total > 1 ? ` (${i + 1}/${total})` : '';

                btn.textContent = `Encrypting ${shortName}${progress}`;

                const encrypted = await encryptFile(file, key);

                btn.textContent = `Uploading ${shortName}${progress}`;

                const response = await fetch('/api/attachments/upload', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        file: arrayToBase64(encrypted.blob),
                        encrypted_filename: encrypted.encryptedFilename,
                        mime_type: encrypted.mimeType,
                        size: encrypted.size,
                        temp_id: tempId,
                    }),
                });

                if (response.ok) {
                    attachmentIds.push(tempId);
                } else {
                    console.error(`Failed to upload ${file.name}`);
                }
            }

            return attachmentIds;
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

                // Upload encrypted files if any
                let attachmentIds = [];
                if (files.length > 0) {
                    attachmentIds = await uploadEncryptedFiles(key);
                }

                // Add attachment IDs to form
                attachmentIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'attachment_ids[]';
                    input.value = id;
                    this.appendChild(input);
                });

                // Brief delay to show encryption happened
                btn.textContent = 'Encrypted!';
                await new Promise(resolve => setTimeout(resolve, 1000));

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
