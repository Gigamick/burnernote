@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">The Story</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
            <div class="bg-gray-50 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">TL;DR</h2>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>We encrypt your note using an AES-256-CBC cipher</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>We "<a href="https://crypto.stackexchange.com/questions/202/should-we-mac-then-encrypt-or-encrypt-then-mac" target="_blank" class="text-gray-900 underline hover:text-gray-700">Encrypt-then-MAC</a>"</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>We delete it from our database once it's been read</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>You can verify this yourself because Burner Note is <a href="https://github.com/GigaMick/burnernote" target="_blank" class="text-gray-900 underline hover:text-gray-700">open source</a></span>
                    </li>
                </ul>
            </div>

            <div class="border-t border-gray-100 pt-6 space-y-4 text-gray-600 leading-relaxed">
                <p>
                    Burner Note came into existence after years of using other products that claim to do something similar. However their pages are laden with ads, have a poor UI, and you can't know for sure if they really are actually encrypting or deleting anything.
                </p>
                <p>
                    As a developer I wanted to build something better; something more useable and technically transparent, and that's what Burner Note is.
                </p>
                <p>
                    The good stuff... Burner Note is <a href="https://github.com/GigaMick/burnernote" target="_blank" class="text-gray-900 underline hover:text-gray-700">open source</a>. Go and check out the code. If you can't be bothered doing that then I can tell you that from browser to server we are relying on good old SSL. On the back end we utilise <a href="https://laravel.com/docs/encryption" target="_blank" class="text-gray-900 underline hover:text-gray-700">Laravel's out of the box encryption protocols</a> which are recognised as being both excellent and are also open source.
                </p>
                <p>
                    On clicking the link and opening your note, it is deleted instantly and completely from our database. Gone forever.
                </p>
                <p class="font-medium text-gray-900">
                    Pretty simple really.
                </p>
            </div>
        </div>
    </div>
@endsection
