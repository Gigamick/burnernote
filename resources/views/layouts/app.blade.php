<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased transition-colors duration-200">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50 transition-colors duration-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                        Burner Note
                    </a>

                    <!-- Navigation -->
                    <div class="flex items-center space-x-3">
                        @guest
                            <!-- Go Pro Pill -->
                            <a href="/pro" class="px-4 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors">Go Pro</a>
                        @endguest

                        <!-- Theme Toggle -->
                        <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                            <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <!-- Hamburger Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 border border-gray-100 dark:border-gray-700">
                                @guest
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Log In</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Create Account</a>
                                @endguest
                                @auth
                                    <a href="{{ route('teams.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">My Teams</a>
                                    @if(auth()->user()->email === env('ADMIN_EMAIL'))
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Admin</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Sign Out</button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 py-8 sm:py-12">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-center gap-6 text-sm text-gray-400 dark:text-gray-500">
                    <a href="/about" class="hover:text-gray-600 dark:hover:text-gray-400 transition-colors">About</a>
                    <span class="text-gray-300 dark:text-gray-600">·</span>
                    <a href="/privacy" class="hover:text-gray-600 dark:hover:text-gray-400 transition-colors">Privacy</a>
                    <span class="text-gray-300 dark:text-gray-600">·</span>
                    <a href="/contact" class="hover:text-gray-600 dark:hover:text-gray-400 transition-colors">Contact</a>
                    <span class="text-gray-300 dark:text-gray-600">·</span>
                    <a href="https://github.com/GigaMick/burnernote" target="_blank" class="hover:text-gray-600 dark:hover:text-gray-400 transition-colors">Open source</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
    </script>
</body>
</html>
