@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Users</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Personal</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($personalAccounts) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Team Members</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($teamMembers) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Teams</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalTeams) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Notes Sent</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalNotes) }}</p>
            </div>
        </div>

        <!-- All Accounts Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200 mb-8"
             x-data="{ filter: 'all' }">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">All Accounts</h2>
                <div class="flex gap-2">
                    <button @click="filter = 'all'"
                            :class="filter === 'all' ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                            class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                        All
                    </button>
                    <button @click="filter = 'personal'"
                            :class="filter === 'personal' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                            class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                        Personal
                    </button>
                    <button @click="filter = 'team'"
                            :class="filter === 'team' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                            class="px-3 py-1 rounded-full text-sm font-medium transition-colors">
                        Team Members
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notes Sent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Login</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($allUsers as $user)
                            @php
                                $type = $user->account_mode === 'individual' ? 'personal' : 'team';
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                                data-type="{{ $type }}"
                                x-show="filter === 'all' || filter === '{{ $type }}'">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $user->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($type === 'personal')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Personal</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Team</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $user->notes_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('M j, Y') : 'Never' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M j, Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No accounts yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Teams Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Teams</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Team</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notes Sent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($teams as $team)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $team->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $team->members_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $team->notes_count }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $team->created_at->format('M j, Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No teams yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
