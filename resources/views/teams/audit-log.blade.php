@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('teams.show', $team) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">&larr; Back to {{ $team->name }}</a>
            <div class="flex items-center justify-between mt-2">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Audit Log</h1>
                @if($team->isOwner(auth()->user()) && $logs->isNotEmpty())
                    <div x-data="{ showConfirm: false }">
                        <button
                            @click="showConfirm = true"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                        >
                            Clear audit log
                        </button>

                        <!-- Confirmation Modal -->
                        <div x-show="showConfirm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
                            <div @click.away="showConfirm = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Clear audit log?</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                    This will permanently delete all {{ $logs->count() }} audit log entries. This action cannot be undone.
                                </p>
                                <div class="flex gap-3 justify-end">
                                    <button
                                        @click="showConfirm = false"
                                        type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                    >
                                        Cancel
                                    </button>
                                    <form method="POST" action="{{ route('teams.audit-log.clear', $team) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors"
                                        >
                                            Delete all
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
            @if($logs->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No activity yet.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($logs as $log)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            {{-- Parent log entry --}}
                            <div class="flex justify-between items-start">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $log->action_label }}
                                        </p>
                                    </div>

                                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        @if($log->user)
                                            <span>{{ $log->user->email }}</span>
                                        @else
                                            <span>Anonymous</span>
                                        @endif

                                        @if(isset($log->metadata['email']))
                                            <span class="mx-1">&middot;</span>
                                            <span>{{ $log->metadata['email'] }}</span>
                                            @if(isset($log->metadata['role']))
                                                <span class="text-gray-400 dark:text-gray-500">({{ $log->metadata['role'] }})</span>
                                            @endif
                                        @endif

                                        @if(isset($log->metadata['recipient_email']))
                                            <span class="mx-1">&middot;</span>
                                            <span>To: {{ $log->metadata['recipient_email'] }}</span>
                                        @endif
                                    </div>

                                    {{-- Device & Location Info --}}
                                    @if($log->device_info || isset($log->metadata['ip_address']))
                                        <div class="mt-2 flex flex-wrap items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                                            @if($log->device_info)
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $log->device_info }}
                                                </span>
                                            @endif
                                            @if(isset($log->metadata['ip_address']))
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    {{ $log->metadata['ip_address'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Note metadata --}}
                                    @if(isset($log->metadata['expiry_days']) || isset($log->metadata['max_views']) || (isset($log->metadata['has_password']) && $log->metadata['has_password']))
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @if(isset($log->metadata['expiry_days']))
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                    {{ $log->metadata['expiry_days'] }} day expiry
                                                </span>
                                            @endif
                                            @if(isset($log->metadata['max_views']))
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                    {{ $log->metadata['max_views'] }} max views
                                                </span>
                                            @endif
                                            @if(isset($log->metadata['has_password']) && $log->metadata['has_password'])
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                    Password protected
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Settings changes --}}
                                    @if($log->action === 'settings_updated' && isset($log->metadata['changes']))
                                        <div class="mt-2 space-y-1">
                                            @foreach($log->metadata['changes'] as $setting => $change)
                                                @php
                                                    $settingLabels = [
                                                        'name' => 'Team name',
                                                        'policy_max_expiry_days' => 'Max expiry',
                                                        'policy_min_expiry_days' => 'Min expiry',
                                                        'policy_max_view_limit' => 'Max views',
                                                        'policy_require_password' => 'Require password',
                                                    ];
                                                    $label = $settingLabels[$setting] ?? $setting;

                                                    // Handle both old format (just value) and new format (from/to)
                                                    if (is_array($change) && isset($change['from'], $change['to'])) {
                                                        $from = is_bool($change['from']) ? ($change['from'] ? 'Yes' : 'No') : $change['from'];
                                                        $to = is_bool($change['to']) ? ($change['to'] ? 'Yes' : 'No') : $change['to'];
                                                        $showDiff = true;
                                                    } else {
                                                        $to = is_bool($change) ? ($change ? 'Yes' : 'No') : $change;
                                                        $showDiff = false;
                                                    }
                                                @endphp
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    <span class="font-medium">{{ $label }}:</span>
                                                    @if($showDiff)
                                                        <span class="text-red-500 dark:text-red-400 line-through">{{ $from }}</span>
                                                        <span class="mx-1">&rarr;</span>
                                                    @endif
                                                    <span class="text-green-600 dark:text-green-400">{{ $to }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right ml-4 flex-shrink-0">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $log->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                        {{ $log->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Child log entries (nested note activity) --}}
                            @if($log->children && $log->children->count() > 0)
                                <div class="mt-3 ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600 space-y-3">
                                    @foreach($log->children as $child)
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $child->action_label }}
                                                </p>
                                                <div class="mt-1 flex flex-wrap items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                                                    @if($child->device_info)
                                                        <span class="inline-flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                            </svg>
                                                            {{ $child->device_info }}
                                                        </span>
                                                    @endif
                                                    @if(isset($child->metadata['ip_address']))
                                                        <span class="inline-flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                            </svg>
                                                            {{ $child->metadata['ip_address'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right ml-4 flex-shrink-0">
                                                <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                                    {{ $child->created_at->format('M j, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                                    {{ $child->created_at->format('g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

            @endif
        </div>
    </div>
@endsection
