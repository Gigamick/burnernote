@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">This note is password protected</h2>
            <p class="text-gray-500 mt-2">Enter the password to view this note</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <form method="post" action="{{ secure_url('/submit-password') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200"
                        placeholder="Enter password"
                    >
                </div>

                @if(session('error'))
                    <p class="text-red-600 text-sm">{{ session('error') }}</p>
                @endif

                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200"
                >
                    Unlock Note
                </button>
            </form>
        </div>
    </div>
@endsection