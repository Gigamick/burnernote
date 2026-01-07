@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ $actualnote }}</p>
        </div>

        <div class="text-center mt-6">
            <p class="text-gray-600 mb-2">This note has now been permanently deleted</p>
            <a href="/" class="text-gray-500 hover:text-gray-900 underline transition-colors">
                Create your own Burner Note
            </a>
        </div>
    </div>
@endsection