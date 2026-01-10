@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Almost there!</p>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">How will you use Burner Note?</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">You can change this later</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <!-- Individual Option -->
            <form method="POST" action="{{ route('auth.choose-mode.store') }}">
                @csrf
                <input type="hidden" name="mode" value="individual">
                <button type="submit" class="w-full h-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 text-left hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600 border-2 border-transparent transition-all duration-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Use as Individual</h2>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Full Pro features for personal use. Set your own defaults.</p>
                    <ul class="text-xs text-gray-400 dark:text-gray-500 space-y-1.5">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Multiple views per note
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Read receipts
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Custom defaults
                        </li>
                    </ul>
                </button>
            </form>

            <!-- Team Option -->
            <form method="POST" action="{{ route('auth.choose-mode.store') }}">
                @csrf
                <input type="hidden" name="mode" value="team">
                <button type="submit" class="w-full h-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 text-left hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600 border-2 border-transparent transition-all duration-200">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Create a Team</h2>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">All Pro features plus tooling to help you manage a team.</p>
                    <ul class="text-xs text-gray-400 dark:text-gray-500 space-y-1.5">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Team audit log
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enforced security policies
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Invite members
                        </li>
                    </ul>
                </button>
            </form>
        </div>
    </div>
@endsection
