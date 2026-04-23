<x-app-layout>
    <div class="py-8 bg-white min-h-screen font-sans text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- EN-TÊTE DYNAMIQUE -->
            <div class="mb-8 mt-4">
                <h1 class="text-3xl font-semibold text-gray-900">Bonjour, {{ Auth::user()->name }}</h1>
                <p class="text-gray-500 mt-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — voici un résumé de votre espace patient
                </p>
            </div>

            <!-- SECTION 1 : STATISTIQUES DYNAMIQUES -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Bloc 1 -->
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">Prochain RDV</p>
                    @if(count($rdv) > 0)
                        <p class="text-3xl font-semibold text-gray-900 mb-1">{{ $rdv[0]['jour'] }} {{ $rdv[0]['mois'] }}</p>
                        <a href="#" class="text-blue-600 font-medium text-sm hover:underline">{{ $rdv[0]['medecin'] }} — {{ $rdv[0]['heure'] }}</a>
                    @else
                        <p class="text-xl font-semibold text-gray-400 mb-1 mt-3">Aucun RDV prévu</p>
                    @endif
                </div>
                <!-- Bloc 2 -->
                <div class="bg-[#F8F7F4] rounded-2xl p-6">
                    <p class="text-sm font-medium text-gray-600 mb-2">Total de vos RDV</p>
                    <p class="text-3xl font-semibold text-gray-900 mb-1">{{ count($rdv) }}</p>
                    <p class="text-gray-500 text-sm">enregistrés dans le système</p>
                </div>
                <!-- Bloc 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <span class="text-gray-400 text-sm">Ordonnances</span>
                <h3 class="text-3xl font-bold mt-2">
                  {{ count($ordonnances ?? []) }}
                </h3>
                      <p class="text-xs text-gray-400 mt-1">téléchargeables</p>
                 </div>
            </div>

            <!-- SECTION 2 : Contenu principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- COLONNE GAUCHE -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Carte : Mes prochains rendez-vous (BOUCLE DYNAMIQUE) -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Mes prochains rendez-vous</h2>
                        
                        <div class="space-y-6">
                            @forelse ($rdv as $rendezVous)
                                <div class="flex items-center justify-between pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-[#EEF4FF] text-blue-700 rounded-xl p-3 flex flex-col items-center justify-center w-14 h-14">
                                            <span class="text-lg font-bold leading-none">{{ $rendezVous['jour'] }}</span>
                                            <span class="text-xs font-semibold uppercase mt-1 leading-none">{{ $rendezVous['mois'] }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 text-base">{{ $rendezVous['medecin'] }}</p>
                                            <p class="text-gray-500 text-sm">{{ $rendezVous['specialite'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900 mb-1">{{ $rendezVous['heure'] }}</p>
                                        <span class="bg-[#E6F6ED] text-[#0A7B45] text-xs font-semibold px-2.5 py-1 rounded-full">{{ $rendezVous['statut'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <!-- MESSAGE AFFICHE SI LE PATIENT N'A PAS DE RDV -->
                                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-gray-500 font-medium">Vous n'avez aucun rendez-vous à venir.</p>
                                    <a href="#" class="mt-3 inline-block text-blue-600 text-sm hover:underline">Prendre un rendez-vous maintenant</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Carte : Notifications récentes -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Notifications récentes</h2>
                        <ul class="space-y-5">
                            @forelse ($notifications as $notif)
                                <li class="relative pl-6 pb-5 border-b border-gray-100">
                                    <span class="absolute left-0 top-1.5 w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                    <p class="text-sm font-medium text-gray-900">{{ $notif['message'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notif['date'] }}</p>
                                </li>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4">Aucune notification pour le moment.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- COLONNE DROITE : Raccourcis (Ceux-ci restent statiques car ce sont des menus) -->
                <div class="space-y-8">
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Raccourcis</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="block bg-[#F8F7F4] rounded-xl p-4 hover:bg-gray-100 transition">
                                <div class="bg-white w-8 h-8 rounded-lg shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 text-sm">Prendre RDV</h3>
                                <p class="text-xs text-gray-500 mt-1">Réserver un créneau</p>
                            </a>
                            <!-- ... J'ai gardé le premier bouton, vous pouvez remettre les 3 autres ici ... -->
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>