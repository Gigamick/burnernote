@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            @if(session('onboarding'))
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Almost there!</p>
            @endif
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create your team</h1>
            @if(session('onboarding'))
                <p class="text-gray-500 dark:text-gray-400 mt-2">Set up your team to start creating secure notes</p>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 sm:p-8 transition-colors duration-200">
            <form method="POST" action="{{ route('teams.store') }}" class="space-y-5">
                @csrf
                @if(session('onboarding'))
                    <input type="hidden" name="onboarding" value="1">
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Team Name</label>
                    <input
                        type="text"
                        name="name"
                        required
                        autofocus
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-gray-900/10 dark:focus:ring-gray-100/10 focus:border-gray-400 dark:focus:border-gray-500 text-gray-900 dark:text-white transition-all duration-200 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        placeholder="Acme Inc."
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-md transition-all duration-200"
                >
                    Create Team
                </button>
            </form>
        </div>
    </div>
@endsection
