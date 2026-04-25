<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-init="$watch('dark', v => { localStorage.setItem('theme', v ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', v) }); document.documentElement.classList.toggle('dark', dark)" :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Authentification - Cabinet Médical</title>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F0F7FF] dark:bg-[#0f172a] transition-colors duration-300">
    <!-- Dark Mode Toggle (Top Right) -->
    <div class="fixed top-6 right-6 z-50">
        <button @click="dark = !dark" 
                class="p-3 rounded-2xl bg-white dark:bg-[#1e293b] text-[#1976D2] dark:text-blue-400 shadow-xl shadow-blue-900/5 border border-blue-50 dark:border-slate-700 hover:scale-110 transition-all duration-300">
            <span x-show="!dark">☀️</span>
            <span x-show="dark" x-cloak>🌙</span>
        </button>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        
        <!-- Section du Logo -->
        <div class="mb-8 text-center">
            <a href="/" class="flex flex-col items-center no-underline group">
                <!-- Ligne Icône + Texte -->
                <div class="flex items-center justify-center gap-3 mb-1">
                    <!-- Petit Cercle Bleu (#1976D2) avec le "+" -->
                    <div class="flex items-center justify-center w-9 h-9 bg-[#1976D2] rounded-full shadow-md transform transition group-hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    
                    <!-- Texte du Logo : Cabinet (Marine #0D47A1) Médical (Bleu #1E88E5) -->
                    <span class="text-3xl font-extrabold tracking-tight">
                        <span class="text-[#0D47A1] dark:text-blue-400">Cabinet</span><span class="text-[#1E88E5] dark:text-blue-300">Médical</span>
                    </span>
                </div>
                
                <!-- Sous-titre stylé (Gris bleu, Majuscules, Espacé) -->
                <p class="text-slate-400 dark:text-slate-500 font-bold text-[10px] uppercase tracking-[0.15em] mt-1">
                    Portail de gestion des consultations
                </p>
            </a>
        </div>

        <!-- Boîte du formulaire (Largeur XL et Bords très arrondis) -->
        <div class="w-full sm:max-w-xl px-10 py-12 bg-white dark:bg-[#1e293b] shadow-[0_20px_50px_rgba(13,71,161,0.05)] border border-blue-50 dark:border-slate-700 overflow-hidden rounded-[2.5rem] transition-colors">
            <div class="w-full">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Pied de page discret -->
        <p class="mt-8 text-slate-400 dark:text-slate-600 text-[11px] font-bold uppercase tracking-widest">
            © {{ date('Y') }} — Espace Sécurisé CabinetMédical
        </p>
    </div>
</body>
</html>
