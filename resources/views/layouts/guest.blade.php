<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Authentification - Cabinet Médical</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans text-gray-900 antialiased bg-[#F4F8FB]">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <!-- Logo -->
        <div class="mb-4 text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                <span class="text-3xl font-extrabold text-blue-900 tracking-tight">Cabinet<span class="text-blue-500">Médical</span></span>
            </div>
            <p class="text-gray-500 font-medium text-sm">Portail de gestion des consultations</p>
        </div>

        <!-- Boîte du formulaire -->
        <div class="w-full sm:max-w-md mt-2 px-10 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-3xl border border-blue-50">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>