@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="mb-8">
            <a href="{{ route('account.settings') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-sm">&larr; Back to Settings</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">Burn Box</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Notes sent to your public inbox</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($notes->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-8 text-center transition-colors duration-200">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-xl mb-4">
                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-2">No notes yet</p>
                <p class="text-sm text-gray-400 dark:text-gray-500">Share your Burn Box link to receive encrypted notes</p>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($notes as $note)
                        <a href="{{ route('account.inbox.view', $note) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if(!$note->read_at)
                                        <span class="w-2 h-2 bg-gray-900 dark:bg-white rounded-full flex-shrink-0"></span>
                                    @else
                                        <span class="w-2 h-2 flex-shrink-0"></span>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white {{ !$note->read_at ? '' : 'font-normal text-gray-600 dark:text-gray-400' }}">
                                            Encrypted note
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $note->created_at->diffForHumans() }}
                                            @if($note->read_at)
                                                <span class="mx-1">&middot;</span>
                                                <span class="text-gray-400 dark:text-gray-500">Read</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($note->isExpired())
                                        <span class="text-xs px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">Expired</span>
                                    @elseif($note->remainingViews() === 0)
                                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">Viewed</span>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Expires {{ $note->expiry_date->diffForHumans() }}</span>
                                    @endif
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            @if($notes->hasPages())
                <div class="mt-6">
                    {{ $notes->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
