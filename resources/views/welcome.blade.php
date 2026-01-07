@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                Send secure and encrypted notes that self destruct once they've been read
            </h1>
            <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                Burner Note is a free, ad-free and open sourced service for sending secure text based notes that are completely erased from existence once they've been read.
            </p>
            <p class="mt-2 text-sm text-gray-400">
                Utilising AES-256-CBC encryption signed with a message authentication code (MAC).
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <form method="post" action="/create-note" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Create your note</label>
                    <textarea
                        rows="4"
                        name="note"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200 resize-none placeholder:text-gray-400"
                        placeholder="Write your secret message here..."
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Create an optional password</label>
                    <p class="text-sm text-gray-400 mb-2">Leave blank if you do not require password protection</p>
                    <input
                        type="text"
                        name="password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200 placeholder:text-gray-400"
                        placeholder="Optional password"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Days till auto self destruct</label>
                    <p class="text-sm text-gray-400 mb-2">The note will expire after a set number of days</p>
                    <input
                        type="number"
                        min="1"
                        max="30"
                        name="expiry"
                        value="7"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full px-6 py-4 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200"
                >
                    Get Link
                </button>
            </form>
        </div>
    </div>
@endsection