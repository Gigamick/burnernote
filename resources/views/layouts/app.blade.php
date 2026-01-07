<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script defer data-domain="burnernote.com" src="https://plausible.io/js/plausible.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Burner Note</title>
    <meta name="title" content="Burner Note">
    <meta name="description" content="Send secure and encrypted notes that self destruct once they've been read">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://burnernote.com/">
    <meta property="og:title" content="Burner Note">
    <meta property="og:description" content="Send secure and encrypted notes that self destruct once they've been read">
    <meta property="og:image" content="https://burnernote.com/img/burnernote.png">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://burnernote.com/">
    <meta property="twitter:title" content="Burner Note">
    <meta property="twitter:description" content="Send secure and encrypted notes that self destruct once they've been read">
    <meta property="twitter:image" content="https://burnernote.com/img/burnernote.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900 hover:text-gray-700 transition-colors">
                        Burner Note
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:flex items-center space-x-8">
                        <a href="/about" class="text-gray-600 hover:text-gray-900 transition-colors">About</a>
                        <a href="/faq" class="text-gray-600 hover:text-gray-900 transition-colors">FAQ</a>
                        <a href="/contact" class="text-gray-600 hover:text-gray-900 transition-colors">Contact</a>
                    </div>

                    <!-- Mobile menu button -->
                    <button type="button" class="sm:hidden p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="hidden sm:hidden pb-4 space-y-2">
                    <a href="/about" class="block px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all">About</a>
                    <a href="/faq" class="block px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all">FAQ</a>
                    <a href="/contact" class="block px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-all">Contact</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 py-8 sm:py-12">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="https://buymeacoffee.com/gigamick" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200">
                        <span>🍕</span> Buy me a Pizza
                    </a>
                    <span class="hidden sm:block text-gray-300">|</span>
                    <a href="https://github.com/sponsors/Gigamick" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                        </svg>
                        Sponsor on GitHub
                    </a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
