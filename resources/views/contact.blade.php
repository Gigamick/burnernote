@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Contact</h1>
            <p class="text-gray-500 mt-2">We'd love to hear from you. Use the form below to say hi.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <form method="POST" action="https://submit-form.com/coj4IR32" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Email</label>
                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200"
                        placeholder="you@example.com"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea
                        name="message"
                        rows="5"
                        required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 transition-all duration-200 resize-none"
                        placeholder="What's on your mind?"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gray-900 text-white font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200"
                >
                    Send Message
                </button>
            </form>
        </div>
    </div>
@endsection
