<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Problème technique - Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F9FAFB] min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-md w-full text-center p-8">
        <!-- Illustration Technique (Rythme Cardiaque plat) -->
        <div class="mb-8 relative">
            <div class="text-[120px] font-black text-blue-50 opacity-60">500</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-indigo-700 p-5 rounded-3xl shadow-2xl shadow-indigo-200">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <h1 class="text-3xl font-black text-gray-900 mb-4">Incident technique</h1>
        <p class="text-gray-500 mb-8 font-medium leading-relaxed">
            Notre serveur rencontre une difficulté imprévue. Nous tentons de rétablir la connexion au plus vite.
        </p>

        <div class="bg-white border border-indigo-100 p-4 rounded-2xl mb-8">
            <p class="text-xs text-indigo-600 font-bold uppercase mb-1">Conseil</p>
            <p class="text-sm text-gray-600 font-medium italic">Essayez de rafraîchir la page ou de revenir dans quelques minutes.</p>
        </div>

        <div class="space-y-4">
            <button onclick="window.location.reload()" class="block w-full py-4 bg-indigo-700 hover:bg-indigo-800 text-white font-bold rounded-2xl shadow-lg transition-all active:scale-95">
                Actualiser la page
            </a>
            
            <a href="mailto:support@cabinetmedical.ma" class="block w-full py-4 bg-white border border-gray-200 text-gray-600 font-bold rounded-2xl hover:bg-gray-50 transition-all">
                Contacter l'administrateur
            </a>
        </div>

        <p class="mt-12 text-xs text-gray-400 font-black uppercase tracking-widest italic">
            Diagnostic : Erreur Interne du Serveur
        </p>
    </div>

</body>
</html>