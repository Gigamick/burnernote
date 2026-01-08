@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Teams</h1>
            <a href="{{ route('teams.create') }}" class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                Create Team
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($teams->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-8 text-center transition-colors duration-200">
                <p class="text-gray-500 dark:text-gray-400 mb-4">You're not part of any teams yet.</p>
                <a href="{{ route('teams.create') }}" class="text-gray-900 dark:text-white font-medium hover:underline">Create your first team</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($teams as $team)
                    <a href="{{ route('teams.show', $team) }}" class="block bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $team->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $team->members_count }} {{ Str::plural('member', $team->members_count) }}
                                    <span class="mx-2">·</span>
                                    <span class="capitalize">{{ $team->pivot->role }}</span>
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
