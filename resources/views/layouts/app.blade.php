<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="
        $watch('dark', v => {
          localStorage.setItem('theme', v ? 'dark' : 'light');
          document.documentElement.classList.toggle('dark', v);
        });
        document.documentElement.classList.toggle('dark', dark);
      "
      :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
 
        <title>{{ config('app.name', 'CabinetMédical') }}</title>
 
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
 
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< HEAD
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
=======
        <style>[x-cloak]{display:none!important}</style>
>>>>>>> c786c016ab5bdb026b76331043925fce08a52a25
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-[#0f172a] transition-colors duration-200">
        <div class="min-h-screen">
            @include('layouts.navigation')
 
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-[#1a2332] shadow dark:shadow-none border-b border-transparent dark:border-[#233044]">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
<<<<<<< HEAD

<<<<<<< HEAD
            <!-- Page Content -->
            <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{ $slot }}
</main>
=======
            <main>{{ $slot }}</main>
>>>>>>> c786c016ab5bdb026b76331043925fce08a52a25
=======
 
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
>>>>>>> 1a9fef19a87a0a690b3701666bf2609ac82c8e3b
        </div>
    </body>
</html>