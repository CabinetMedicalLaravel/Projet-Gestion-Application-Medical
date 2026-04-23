<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page introuvable - Cabinet Médical</title>
    <!-- On utilise Tailwind CSS via le CDN pour la page d'erreur -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F9FAFB] min-h-screen flex items-center justify-center font-sans antialiased">

    <div class="max-w-md w-full text-center p-8">
        
        <!-- Illustration / Icône -->
        <div class="mb-8 relative">
            <div class="text-[120px] font-black text-blue-50 opacity-50">404</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-blue-600 p-5 rounded-3xl shadow-2xl shadow-blue-200">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-3xl font-black text-gray-900 mb-4">Oups ! Page introuvable</h1>
        <p class="text-gray-500 mb-8 font-medium leading-relaxed">
            Il semble que le dossier ou la page que vous recherchez n'existe pas ou a été déplacée.
        </p>

        <!-- Boutons d'action -->
        <div class="space-y-4">
            <a href="{{ url('/dashboard') }}" class="block w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                Retour au Tableau de Bord
            </a>
            
            <a href="{{ url('/') }}" class="block w-full py-4 bg-white border border-gray-200 text-gray-600 font-bold rounded-2xl hover:bg-gray-50 transition-all">
                Aller à l'accueil
            </a>
        </div>

        <!-- Footer -->
        <p class="mt-12 text-sm text-gray-400 font-bold uppercase tracking-widest">
            © {{ date('Y') }} CabinetMédical — Support technique
        </p>
    </div>

</body>
</html>