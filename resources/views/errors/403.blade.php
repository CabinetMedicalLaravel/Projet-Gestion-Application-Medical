<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé - Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F9FAFB] min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-md w-full text-center p-8">
        <!-- Illustration Sécurité -->
        <div class="mb-8 relative">
            <div class="text-[120px] font-black text-amber-50 opacity-60 uppercase">403</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-amber-500 p-5 rounded-3xl shadow-2xl shadow-amber-200">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <h1 class="text-3xl font-black text-gray-900 mb-4">Espace réservé</h1>
        <p class="text-gray-500 mb-8 font-medium leading-relaxed italic">
            Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cet espace médical sécurisé.
        </p>

        <div class="space-y-4">
            <a href="{{ url('/dashboard') }}" class="block w-full py-4 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl shadow-lg transition-all active:scale-95">
                Retourner à mon espace
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-4 text-gray-500 font-bold hover:text-red-600 transition-all">
                    Se déconnecter
                </button>
            </form>
        </div>

        <p class="mt-12 text-xs text-gray-400 font-black uppercase tracking-widest">
            🛡️ Sécurité CabinetMédical activée
        </p>
    </div>

</body>
</html>