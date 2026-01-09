@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Accounts</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalAccounts) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Teams</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalTeams) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 transition-colors duration-200">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Notes Sent</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalNotes) }}</p>
            </div>
        </div>

        <!-- Teams Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
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
