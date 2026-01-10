@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Profile Section -->
        <form method="POST" action="{{ route('account.profile.update') }}" class="mb-6">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Profile</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                        <input
                            type="text"
                            name="first_name"
                            value="{{ old('first_name', $user->first_name) }}"
                            required
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-gray-400 dark:text-gray-500 font-normal">(optional)</span></label>
                        <input
                            type="text"
                            name="last_name"
                            value="{{ old('last_name', $user->last_name) }}"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                        >
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <div class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-500 dark:text-gray-400">
                        {{ $user->email }}
                    </div>
                </div>
                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-all duration-200"
                >
                    Update Profile
                </button>
            </div>
        </form>

        <!-- Note Defaults Section (for individuals) -->
        @if($user->account_mode === 'individual' || $teams->isEmpty())
            <form method="POST" action="{{ route('account.defaults.update') }}" id="defaults-form" class="mb-6">
                @csrf
                @method('PUT')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Note Defaults</h2>
                        <span id="defaults-saved" class="text-sm text-green-600 dark:text-green-400 opacity-0 transition-opacity duration-200">Saved</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">These defaults will be applied when you create notes.</p>

                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Min Expiry (days)</label>
                                <input
                                    type="number"
                                    name="default_min_expiry_days"
                                    min="1"
                                    max="365"
                                    required
                                    value="{{ old('default_min_expiry_days', $user->default_min_expiry_days) }}"
                                    oninput="debounceDefaults()"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Expiry (days)</label>
                                <input
                                    type="number"
                                    name="default_max_expiry_days"
                                    min="1"
                                    max="365"
                                    required
                                    value="{{ old('default_max_expiry_days', $user->default_max_expiry_days) }}"
                                    oninput="debounceDefaults()"
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max View Limit</label>
                            <input
                                type="number"
                                name="default_max_view_limit"
                                min="1"
                                max="100"
                                required
                                value="{{ old('default_max_view_limit', $user->default_max_view_limit) }}"
                                oninput="debounceDefaults()"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="hidden" name="default_require_password" value="0">
                            <input
                                type="checkbox"
                                name="default_require_password"
                                id="default_require_password"
                                value="1"
                                {{ old('default_require_password', $user->default_require_password) ? 'checked' : '' }}
                                onchange="saveDefaults()"
                                class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-gray-900 dark:focus:ring-gray-100 bg-white dark:bg-gray-700"
                            >
                            <label for="default_require_password" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Require password on all notes
                            </label>
                        </div>
                    </div>
                </div>
            </form>

            <script>
                let defaultsTimeout;

                function debounceDefaults() {
                    clearTimeout(defaultsTimeout);
                    defaultsTimeout = setTimeout(() => saveDefaults(), 800);
                }

                function saveDefaults() {
                    const form = document.getElementById('defaults-form');
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const indicator = document.getElementById('defaults-saved');
                            indicator.classList.remove('opacity-0');
                            indicator.classList.add('opacity-100');
                            setTimeout(() => {
                                indicator.classList.remove('opacity-100');
                                indicator.classList.add('opacity-0');
                            }, 2000);
                        }
                    });
                }
            </script>
        @endif

        <!-- Teams Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Teams</h2>
                <a href="{{ route('teams.create') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    Create Team
                </a>
            </div>

            @if($teams->isEmpty())
                <p class="text-sm text-gray-500 dark:text-gray-400">You're not part of any teams yet.</p>
            @else
                <div class="space-y-2">
                    @foreach($teams as $team)
                        <a href="{{ route('teams.show', $team) }}" class="block p-3 -mx-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $team->name }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 capitalize">{{ $team->pivot->role }}</span>
                                </div>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $team->members_count }} {{ Str::plural('member', $team->members_count) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Burn Box Section -->
        <form method="POST" action="{{ route('account.burn-me.update') }}" id="burn-me-form" class="mb-6">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Burn Box</h2>
                        @if($user->burn_me_slug && $user->unreadBurnMeNotes()->count() > 0)
                            <span class="px-2 py-0.5 text-xs font-medium bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-full">
                                {{ $user->unreadBurnMeNotes()->count() }} new
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="burn-me-saved" class="text-sm text-green-600 dark:text-green-400 opacity-0 transition-opacity duration-200">Saved</span>
                        @if($user->burn_me_slug)
                            <a href="{{ route('account.inbox') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                View Inbox
                            </a>
                        @endif
                    </div>
                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Let anyone send you encrypted notes via a public link.
                </p>

                <!-- Toggle Switch -->
                <div class="flex items-center justify-between mb-6">
                    <label for="burn_me_enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Enable Burn Box
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="burn_me_enabled" value="0">
                        <input
                            type="checkbox"
                            name="burn_me_enabled"
                            id="burn_me_enabled"
                            value="1"
                            {{ $user->burn_me_enabled ? 'checked' : '' }}
                            onchange="saveBurnMe()"
                            class="sr-only peer"
                        >
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 dark:peer-checked:bg-green-500"></div>
                    </label>
                </div>

                <!-- URL Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Burn Box URL</label>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ config('app.url') }}/b/</span>
                        <input
                            type="text"
                            name="burn_me_slug"
                            id="burn_me_slug"
                            value="{{ old('burn_me_slug', $user->burn_me_slug) }}"
                            placeholder="your-name"
                            oninput="formatSlug(this); debounceSave()"
                            class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 text-sm"
                        >
                        @if($user->burn_me_slug && $user->burn_me_enabled)
                            <button
                                type="button"
                                onclick="copyBurnMeUrl()"
                                class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200"
                            >
                                <span id="copy-text">Copy</span>
                            </button>
                        @endif
                    </div>
                    @error('burn_me_slug')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </form>

        <script>
            let saveTimeout;
            let lastSavedSlug = '{{ $user->burn_me_slug }}';

            function formatSlug(input) {
                let value = input.value;
                value = value.replace(/ /g, '-');
                value = value.toLowerCase();
                value = value.replace(/[^a-z0-9-]/g, '');
                value = value.replace(/-+/g, '-');
                value = value.replace(/^-+/, '');
                input.value = value;
            }

            function debounceSave() {
                clearTimeout(saveTimeout);
                const currentSlug = document.getElementById('burn_me_slug').value;
                if (currentSlug !== lastSavedSlug && currentSlug.length > 0) {
                    saveTimeout = setTimeout(() => saveBurnMe(), 800);
                }
            }

            function saveBurnMe() {
                const form = document.getElementById('burn-me-form');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.slug) {
                            document.getElementById('burn_me_slug').value = data.slug;
                            lastSavedSlug = data.slug;
                        }
                        showSaved();
                    }
                });
            }

            function showSaved() {
                const indicator = document.getElementById('burn-me-saved');
                indicator.classList.remove('opacity-0');
                indicator.classList.add('opacity-100');
                setTimeout(() => {
                    indicator.classList.remove('opacity-100');
                    indicator.classList.add('opacity-0');
                }, 2000);
            }

            function copyBurnMeUrl() {
                const slug = document.getElementById('burn_me_slug').value;
                const url = '{{ config('app.url') }}/b/' + slug;
                const copyText = document.getElementById('copy-text');

                navigator.clipboard.writeText(url).then(() => {
                    copyText.textContent = 'Copied!';
                    setTimeout(() => {
                        copyText.textContent = 'Copy';
                    }, 2000);
                });
            }
        </script>

        <!-- Danger Zone -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200 border border-red-200 dark:border-red-900/50">
            <h2 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-2">Danger Zone</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Permanently delete your account and all associated data. This cannot be undone.</p>
            <form method="POST" action="{{ route('account.destroy') }}" onsubmit="return confirm('Are you absolutely sure? This will permanently delete your account and all data.')">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3">
                    <input
                        type="text"
                        name="confirmation"
                        placeholder="Type DELETE to confirm"
                        class="flex-1 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-400 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                    >
                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-all duration-200"
                    >
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
