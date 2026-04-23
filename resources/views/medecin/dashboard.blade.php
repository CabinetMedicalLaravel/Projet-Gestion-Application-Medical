<x-app-layout>
    <div
        class="py-8 bg-white dark:bg-gray-900 min-h-screen font-sans text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- EN-TÊTE -->
            <div class="mb-8 mt-4">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Bonjour, Dr.
                    {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — voici un résumé de votre activité
                </p>
            </div>

            <!-- STATISTIQUES -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-[#F8F7F4] dark:bg-gray-800 rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">RDV aujourd'hui</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $nbRdvAujourdhui ?? 0 }}
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">consultations prévues</p>
                </div>
                <div class="bg-[#F8F7F4] dark:bg-gray-800 rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Patients total</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $nbPatients ?? 0 }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">dans votre liste</p>
                </div>
                <div class="bg-[#F8F7F4] dark:bg-gray-800 rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">En attente</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $nbEnAttente ?? 0 }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">demandes à confirmer</p>
                </div>
                <div class="bg-[#F8F7F4] dark:bg-gray-800 rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Ordonnances</p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $nbOrdonnances ?? 0 }}
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">émises ce mois</p>
                </div>
            </div>

            <!-- CONTENU PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- COLONNE GAUCHE -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- RDV du jour -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 dark:bg-gray-800/50">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold dark:text-gray-100">Rendez-vous du jour</h2>
                            <a href="{{ route('medecin.agenda') }}"
                                class="text-blue-600 text-sm font-medium hover:underline">Voir l'agenda</a>
                        </div>

                        <div class="space-y-6">
                            @forelse ($rdvAujourdhui ?? [] as $rdv)
                                <div
                                    class="flex items-center justify-between pb-6 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="bg-[#EEF4FF] dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl p-3 flex flex-col items-center justify-center w-14 h-14">
                                            <span class="text-lg font-bold leading-none">{{ $rdv['heure'] }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-gray-100 text-base">
                                                {{ $rdv['patient'] }}</p>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $rdv['motif'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($rdv['statut'] === 'confirmé')
                                            <span
                                                class="bg-[#E6F6ED] dark:bg-green-900/30 text-[#0A7B45] dark:text-green-400 text-xs font-semibold px-2.5 py-1 rounded-full">Confirmé</span>
                                        @else
                                            <span
                                                class="bg-yellow-50 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">En
                                                attente</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center py-10 bg-gray-50 dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Aucun rendez-vous prévu
                                        aujourd'hui.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Derniers patients -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 dark:bg-gray-800/50">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold dark:text-gray-100">Derniers patients consultés</h2>
                            <a href="{{ route('medecin.agenda') }}"
                                class="text-blue-600 text-sm font-medium hover:underline">Voir tous</a>
                        </div>
                        <ul class="space-y-4">
                            @forelse ($derniersPatients ?? [] as $patient)
                                <li
                                    class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 flex items-center font-semibold text-sm justify-center">
                                            {{ strtoupper(substr($patient['nom'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                                {{ $patient['nom'] }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $patient['date_derniere_visite'] }}</p>
                                        </div>
                                    </div>
                                    <a href="#" class="text-xs text-blue-600 hover:underline">Dossier</a>
                                </li>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">Aucun patient récent.
                                </p>
                            @endforelse
                        </ul>
                    </div>
                </div>
               

                <!-- COLONNE DROITE -->
                <div class="space-y-8">

                    <!-- Raccourcis -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 dark:bg-gray-800/50">
                        <h2 class="text-lg font-semibold mb-6 dark:text-gray-100">Raccourcis</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('medecin.agenda') }}"
                                class="block bg-[#F8F7F4] dark:bg-gray-700 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div
                                    class="bg-white dark:bg-gray-800 w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">Mon agenda</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Gérer les créneaux</p>
                            </a>
<<<<<<< HEAD
                            <a href="{{ url('/consultation/create/' . $patient->id) }}" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
=======
                            <a href="#"
                                class="block bg-[#F8F7F4] dark:bg-gray-700 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div
                                    class="bg-white dark:bg-gray-800 w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
>>>>>>> c786c016ab5bdb026b76331043925fce08a52a25
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">Ordonnances</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Rédiger / envoyer</p>
                            </a>
                            <a href="#"
                                class="block bg-[#F8F7F4] dark:bg-gray-700 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div
                                    class="bg-white dark:bg-gray-800 w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">Patients</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Voir les dossiers</p>
                            </a>
                            <a href="#"
                                class="block bg-[#F8F7F4] dark:bg-gray-700 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <div
                                    class="bg-white dark:bg-gray-800 w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-sm">Statistiques</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Activité du mois</p>
                            </a>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 dark:bg-gray-800/50">
                        <h2 class="text-lg font-semibold mb-6 dark:text-gray-100">Notifications</h2>
                        <ul class="space-y-4">
                            @forelse ($notifications ?? [] as $notif)
                                <li
                                    class="relative pl-6 pb-4 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                    <span class="absolute left-0 top-1.5 w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $notif['message'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $notif['date'] }}</p>
                                </li>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">Aucune notification.
                                </p>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>