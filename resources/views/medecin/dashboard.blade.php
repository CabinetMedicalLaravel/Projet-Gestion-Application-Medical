<x-app-layout>
    <div class="py-8 bg-[#F0F4F8] min-h-screen font-sans text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- EN-TÊTE AVEC BANNIÈRE MÉDICALE (DÉGRADÉ BLEU PREMIUM) -->
            <div class="relative bg-gradient-to-r from-[#0D47A1] via-[#1565C0] to-[#1976D2] rounded-3xl p-8 mb-8 text-white shadow-xl overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div class="flex items-center gap-6">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="h-24 w-24 rounded-full border-4 border-white/20 shadow-2xl object-cover">
                        @else
                            <div class="h-24 w-24 rounded-full bg-white/10 flex items-center justify-center border-4 border-white/20 text-3xl font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold tracking-tight">Bonjour, Dr. {{ Auth::user()->name }} ! 👨‍⚕️</h1>
                            <p class="text-blue-100 mt-1 opacity-90 font-medium italic">
                                Spécialité : {{ Auth::user()->specialite ?? 'Généraliste' }}
                            </p>
                            <p class="text-xs text-blue-200 mt-2 uppercase tracking-widest font-black">
                                {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 md:mt-0">
                        <div class="bg-white/10 px-6 py-3 rounded-2xl backdrop-blur-md border border-white/10 text-center">
                            <p class="text-[10px] uppercase font-black text-blue-100">Statut Professionnel</p>
                            <p class="text-sm font-bold">En Consultation</p>
                        </div>
                    </div>
                </div>
                <!-- Décoration fond -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 opacity-10">
                    <svg width="300" height="300" fill="white" viewBox="0 0 100 100"><path d="M50 0 L100 50 L50 100 L0 50 Z"/></svg>
                </div>
            </div>

            <!-- SECTION 1 : STATISTIQUES (BORDURES DÉGRADÉES DE BLEU) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- RDV Aujourd'hui -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#0D47A1]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">RDV Aujourd'hui</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#0D47A1]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbRdvAujourdhui ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-bold mt-1">Consultations</p>
                </div>

                <!-- Patients Total -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1565C0]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">Patients Total</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1565C0]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbPatients ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-bold mt-1">Base active</p>
                </div>

                <!-- En attente -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1E88E5]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">En attente</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1E88E5]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbEnAttente ?? 0 }}</p>
                    <p class="text-[11px] text-[#1E88E5] font-black mt-1">À traiter</p>
                </div>

                <!-- Ordonnances -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#2196F3]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">Ordonnances</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#2196F3]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbOrdonnances ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400 font-bold mt-1">Ce mois</p>
                </div>
            </div>

            <!-- SECTION 2 : CONTENU PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- COLONNE GAUCHE (RDV & PATIENTS) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- RDV du jour -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-[#F8FAFC]">
                            <h2 class="text-lg font-black text-[#0D47A1] flex items-center">
                                <span class="w-2 h-6 bg-[#1976D2] rounded-full mr-3"></span>
                                Prochaines consultations
                            </h2>
                            <button class="text-[#1976D2] text-sm font-bold hover:underline">Agenda complet</button>
                        </div>

                        <div class="p-8 space-y-4">
                            @forelse ($rdvAujourdhui ?? [] as $rdv)
                                <div class="flex items-center justify-between p-4 rounded-2xl border border-transparent hover:border-[#BBDEFB] hover:bg-[#F1F8FE] transition-all group">
                                    <div class="flex items-center gap-5">
                                        <div class="bg-white text-[#1976D2] px-4 py-2 rounded-xl text-sm font-black shadow-sm border border-blue-50 group-hover:bg-[#1976D2] group-hover:text-white transition-all">
                                            {{ $rdv['heure'] }}
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-900 text-base">{{ $rdv['patient'] }}</p>
                                            <p class="text-gray-400 text-xs font-bold uppercase">{{ $rdv['motif'] ?? 'Consultation' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $rdv['statut'] === 'confirmé' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $rdv['statut'] }}
                                        </span>
                                        <button class="text-gray-300 hover:text-[#1E88E5]"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg></button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-gray-400 font-bold italic">Aucune consultation aujourd'hui.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Derniers patients -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 flex items-center">
                            <span class="w-2 h-6 bg-[#1565C0] rounded-full mr-3"></span>
                            Derniers patients consultés
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse ($derniersPatients ?? [] as $patient)
                                <div class="flex items-center justify-between p-4 bg-[#F8FAFC] rounded-2xl hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-[#90CAF9]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#1565C0] to-[#1E88E5] text-white flex items-center justify-center font-black text-sm">
                                            {{ strtoupper(substr($patient['nom'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-800 text-sm leading-tight">{{ $patient['nom'] }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $patient['date_derniere_visite'] }}</p>
                                        </div>
                                    </div>
                                    <a href="#" class="p-2 bg-white text-[#1976D2] rounded-lg shadow-sm hover:bg-[#1976D2] hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </a>
                                </div>
                            @empty
                                <p class="text-gray-400 text-xs italic font-bold">Historique vide.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
               

                <!-- COLONNE DROITE (RACCOURCIS & NOTIFS) -->
                <div class="space-y-8">

                    <!-- Actions -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 tracking-tight">Raccourcis</h2>
                        <div class="grid grid-cols-1 gap-4">
                            <a href="#" class="flex items-center p-4 bg-[#F1F8FE] rounded-2xl border border-[#BBDEFB] group hover:bg-[#1976D2] transition-all duration-300">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1976D2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="ml-4 text-sm font-black text-[#0D47A1] group-hover:text-white transition">Agenda complet</div>
                            </a>
<<<<<<< HEAD
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
=======

                            <a href="#" class="flex items-center p-4 bg-[#E3F2FD] rounded-2xl border border-[#90CAF9] group hover:bg-[#1565C0] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1565C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
>>>>>>> 1a9fef19a87a0a690b3701666bf2609ac82c8e3b
                                </div>
                                <div class="ml-4 text-sm font-black text-[#0D47A1] group-hover:text-white transition">Ordonnances</div>
                            </a>

                            <a href="#" class="flex items-center p-4 bg-[#F0F7FF] rounded-2xl border border-[#1E88E5]/20 group hover:bg-[#1E88E5] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1E88E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4 text-sm font-black text-[#0D47A1] group-hover:text-white transition">Statistiques</div>
                            </a>
                        </div>
                    </div>

                    <!-- Activité (Timeline Bleue) -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 flex justify-between items-center">
                            Activité & notifications
                            <span class="w-2 h-2 bg-[#1E88E5] rounded-full animate-ping"></span>
                        </h2>
                        <div class="space-y-6">
                            @forelse ($notifications ?? [] as $notif)
                                <div class="flex gap-4 relative">
                                    <div class="z-10 bg-[#1E88E5] h-2.5 w-2.5 rounded-full mt-1.5 shadow-sm"></div>
                                    <div class="border-l border-gray-100 pl-4 -ml-5.5 pb-2">
                                        <p class="text-xs font-black text-gray-800 leading-tight">{{ $notif['message'] }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">{{ $notif['date'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-xs font-bold text-center py-4 italic">Aucune alerte.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Conseil (BLEU MARINE FONCÉ) -->
                    <div class="bg-[#0D47A1] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                        <div class="relative z-10">
                            <h3 class="font-black text-lg mb-2 italic tracking-tight">Astuce Médicale</h3>
                            <p class="text-blue-100 text-xs leading-relaxed opacity-80">
                                Synchronisez vos dossiers patients avant la fin de la journée pour vos rapports mensuels.
                            </p>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/5 rounded-full"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>