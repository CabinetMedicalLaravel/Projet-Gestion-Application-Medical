<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-init="$watch('dark', v => { localStorage.setItem('theme', v ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', v) }); document.documentElement.classList.toggle('dark', dark)" :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Authentification - Cabinet Médical</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-[#F4F8FB] dark:bg-gray-900 transition-colors duration-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <!-- Dark Mode Toggle (top-right) -->
        <div class="absolute top-4 right-4">
            <button
                @click="dark = !dark"
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-150"
                :title="dark ? 'Mode clair' : 'Mode sombre'"
            >
                <svg x-show="dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg x-show="!dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </button>
        </div>

        <!-- Logo -->
        <div class="mb-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-3xl font-extrabold text-blue-900 dark:text-blue-300 tracking-tight">Cabinet<span class="text-blue-500">Médical</span></span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Portail de gestion des consultations</p>
        </div>

        <!-- Form box -->
        <div class="w-full sm:max-w-md mt-2 px-10 py-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-3xl border border-blue-50 dark:border-gray-700 transition-colors duration-200">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
