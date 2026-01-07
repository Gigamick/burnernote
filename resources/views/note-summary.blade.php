@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>

    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Here's your link:</h2>

            <div
                data-clipboard-target="#link-text"
                class="copy bg-white rounded-2xl shadow-sm p-6 cursor-pointer hover:shadow-md transition-all duration-200 border border-gray-100"
            >
                <p id="link-text" class="text-gray-900 font-medium break-all">{{ config('app.url') }}/v/{{ $note->token }}</p>
            </div>

            <p class="text-gray-400 mt-3 copy-note">Click on the link to copy it</p>
            <p class="text-green-600 font-medium mt-3 copy-success hidden">Copied to clipboard!</p>
        </div>

        <!-- Email Form -->
        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <form method="post" action="/send-email" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Or send link by email</label>
                    <p class="text-sm text-gray-400 mb-2">Enter email address below</p>
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="hello@example.com"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200 placeholder:text-gray-400"
                    >
                </div>
                <input type="hidden" name="link" value="{{ config('app.url') }}/v/{{ $note->token }}">
                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200"
                >
                    Send Email
                </button>
            </form>
        </div>
    </div>

    <script>
        var clipboard = new ClipboardJS('.copy');
        clipboard.on('success', function (e) {
            document.querySelector('.copy-success').classList.remove('hidden');
            document.querySelector('.copy-note').classList.add('hidden');
            e.clearSelection();
        });
    </script>
@endsection