<x-app-layout>
    <div class="py-8 bg-white min-h-screen font-sans text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- EN-TÊTE -->
            <div class="mb-8 mt-4">
                <h1 class="text-3xl font-semibold text-gray-900">Bonjour, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 mt-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — gestion de la clinique
                </p>
            </div>

            <!-- STATISTIQUES -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">RDV aujourd'hui</p>
                    <p class="text-3xl font-semibold text-gray-900 mb-1">{{ $nbRdvAujourdhui ?? 0 }}</p>
                    <p class="text-gray-500 text-sm">toutes salles confondues</p>
                </div>
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">En attente</p>
                    <p class="text-3xl font-semibold text-gray-900 mb-1">{{ $nbEnAttente ?? 0 }}</p>
                    <p class="text-gray-500 text-sm">à confirmer</p>
                </div>
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">Nouveaux patients</p>
                    <p class="text-3xl font-semibold text-gray-900 mb-1">{{ $nbNouveauxPatients ?? 0 }}</p>
                    <p class="text-gray-500 text-sm">inscrits ce mois</p>
                </div>
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">Médecins actifs</p>
                    <p class="text-3xl font-semibold text-gray-900 mb-1">{{ $nbMedecins ?? 0 }}</p>
                    <p class="text-gray-500 text-sm">dans la clinique</p>
                </div>
            </div>

            <!-- CONTENU PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- COLONNE GAUCHE -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- RDV en attente de confirmation -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold">Demandes en attente</h2>
                            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Voir tout</a>
                        </div>

                        <div class="space-y-6">
                            @forelse ($rdvEnAttente ?? [] as $rdv)
                                <div class="flex items-center justify-between pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center font-semibold text-sm">
                                            {{ strtoupper(substr($rdv['patient'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-base">{{ $rdv['patient'] }}</p>
                                            <p class="text-gray-500 text-sm">{{ $rdv['medecin'] }} — {{ $rdv['date'] }} à {{ $rdv['heure'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="bg-[#E6F6ED] text-[#0A7B45] text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-green-200 transition">
                                            Confirmer
                                        </button>
                                        <button class="bg-red-50 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-red-100 transition">
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">Aucune demande en attente.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Agenda du jour (tous médecins) -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold">Agenda du jour</h2>
                            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Agenda complet</a>
                        </div>
                        <div class="space-y-4">
                            @forelse ($rdvAujourdhui ?? [] as $rdv)
                                <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-[#EEF4FF] text-blue-700 rounded-xl px-3 py-2 text-sm font-bold min-w-[56px] text-center">
                                            {{ $rdv['heure'] }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-sm">{{ $rdv['patient'] }}</p>
                                            <p class="text-gray-500 text-xs">{{ $rdv['medecin'] }}</p>
                                        </div>
                                    </div>
                                    @if(($rdv['statut'] ?? '') === 'confirmé')
                                        <span class="bg-[#E6F6ED] text-[#0A7B45] text-xs font-semibold px-2.5 py-1 rounded-full">Confirmé</span>
                                    @else
                                        <span class="bg-yellow-50 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">En attente</span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">Aucun rendez-vous aujourd'hui.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE -->
                <div class="space-y-8">

                    <!-- Raccourcis -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Raccourcis</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">Nouveau RDV</h3>
                                <p class="text-xs text-gray-500 mt-1">Créer manuellement</p>
                            </a>
                            <a href="#" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">Patients</h3>
                                <p class="text-xs text-gray-500 mt-1">Liste complète</p>
                            </a>
                            <a href="#" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">Agenda</h3>
                                <p class="text-xs text-gray-500 mt-1">Vue hebdomadaire</p>
                            </a>
                            <a href="#" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">Messages</h3>
                                <p class="text-xs text-gray-500 mt-1">Contacter patients</p>
                            </a>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Notifications</h2>
                        <ul class="space-y-4">
                            @forelse ($notifications ?? [] as $notif)
                                <li class="relative pl-6 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                    <span class="absolute left-0 top-1.5 w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                    <p class="text-sm font-medium text-gray-900">{{ $notif['message'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notif['date'] }}</p>
                                </li>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">Aucune notification.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
