@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('teams.show', $team) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">&larr; Back to {{ $team->name }}</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Team Settings</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('teams.settings.update', $team) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- General -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">General</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Team Name</label>
                    <input
                        type="text"
                        name="name"
                        required
                        value="{{ old('name', $team->name) }}"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Policies -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Security Policies</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">These policies will be enforced on all notes created by team members.</p>

                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Min Expiry (days)</label>
                            <input
                                type="number"
                                name="policy_min_expiry_days"
                                min="1"
                                max="365"
                                required
                                value="{{ old('policy_min_expiry_days', $team->policy_min_expiry_days) }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                            @error('policy_min_expiry_days')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Expiry (days)</label>
                            <input
                                type="number"
                                name="policy_max_expiry_days"
                                min="1"
                                max="365"
                                required
                                value="{{ old('policy_max_expiry_days', $team->policy_max_expiry_days) }}"
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                            >
                            @error('policy_max_expiry_days')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max View Limit</label>
                        <input
                            type="number"
                            name="policy_max_view_limit"
                            min="1"
                            max="100"
                            required
                            value="{{ old('policy_max_view_limit', $team->policy_max_view_limit) }}"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200"
                        >
                        @error('policy_max_view_limit')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="policy_require_password" value="0">
                        <input
                            type="checkbox"
                            name="policy_require_password"
                            id="policy_require_password"
                            value="1"
                            {{ old('policy_require_password', $team->policy_require_password) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-gray-900 dark:focus:ring-gray-100 bg-white dark:bg-gray-700"
                        >
                        <label for="policy_require_password" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Require password on all notes
                        </label>
                    </div>
                </div>
            </div>

            <button
                type="submit"
                class="w-full px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
            >
                Save Settings
            </button>
        </form>
    </div>
@endsection
