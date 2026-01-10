@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $team->name }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $team->members->count() }} {{ Str::plural('member', $team->members->count()) }}</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Team Policies -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6 transition-colors duration-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Team Policies</h2>
                @can('update', $team)
                    <a href="{{ route('teams.settings', $team) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Settings
                    </a>
                @endcan
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Max expiry:</span>
                    <span class="text-gray-900 dark:text-white ml-2">{{ $team->policy_max_expiry_days }} days</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Min expiry:</span>
                    <span class="text-gray-900 dark:text-white ml-2">{{ $team->policy_min_expiry_days }} day(s)</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Password required:</span>
                    <span class="text-gray-900 dark:text-white ml-2">{{ $team->policy_require_password ? 'Yes' : 'No' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Max views:</span>
                    <span class="text-gray-900 dark:text-white ml-2">{{ $team->policy_max_view_limit }}</span>
                </div>
            </div>
        </div>

        <!-- Members -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6 transition-colors duration-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Members</h2>
                @can('manageMembers', $team)
                    <a href="{{ route('teams.members', $team) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Manage
                    </a>
                @endcan
            </div>
            <div class="space-y-3">
                @foreach($team->members as $member)
                    <div class="flex justify-between items-center py-2">
                        <div>
                            <p class="text-gray-900 dark:text-white">{{ $member->email }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 capitalize">
                            {{ $member->pivot->role }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pending Invitations -->
        @if($team->invitations->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 mb-6 transition-colors duration-200">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pending Invitations</h2>
                <div class="space-y-3">
                    @foreach($team->invitations as $invitation)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <p class="text-gray-900 dark:text-white">{{ $invitation->email }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Expires {{ $invitation->expires_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                                Pending
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Audit Log -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h2>
                <a href="{{ route('teams.audit-log', $team) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    View all
                </a>
            </div>
            @php
                $recentLogs = $team->auditLogs()->with('user')->orderByDesc('created_at')->limit(5)->get();
            @endphp
            @if($recentLogs->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-sm">No activity yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentLogs as $log)
                        <div class="flex justify-between items-center py-2">
                            <div>
                                <p class="text-gray-900 dark:text-white text-sm">{{ $log->action_label }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $log->user?->email ?? 'System' }}
                                </p>
                            </div>
                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
