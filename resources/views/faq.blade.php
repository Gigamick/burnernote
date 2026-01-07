@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">FAQs</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">How does this product make money?</h2>
                    <p class="text-gray-600">It doesn't. Making money isn't the point of this product.</p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Do you use Google Analytics?</h2>
                    <p class="text-gray-600">Nope. We use <a href="https://plausible.io/?ref=burnernote" target="_blank" class="text-gray-900 underline hover:text-gray-700">Plausible Analytics</a>. They are a privacy first alternative to the big analytics players like Google.</p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Why are you open source?</h2>
                    <p class="text-gray-600">To promote trust; so that people can see we do what we say we do.</p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">How do I know the linked repo is really what is deployed?</h2>
                    <p class="text-gray-600">I actually don't know how to prove that. It is a problem for any OSS I imagine. However I promise you it is.</p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">How can I stop someone taking a screenshot?</h2>
                    <p class="text-gray-600 mb-3">In short, you can't. Taking screenshots is a function of the operating system and can't be blocked or overridden by a website.</p>
                    <p class="text-gray-600">Further to that, even if it was possible there is no way to stop someone simply taking a photograph of the screen. Or, even more simply writing out your note on paper. To that end Burner Note and similar products make no effort to stop screenshots or copy/pasting. If the person you're sending a note to wants to keep it bad enough then they will. One way or another.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
