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
                            <h1 class="text-3xl font-bold tracking-tight">Bonjour, Dr. {{ Auth::user()->name }} !</h1>
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
                    <div class="bg-white dark:bg-[#1e293b] rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" 
                         x-data="{ 
                            rdvs: {{ json_encode($rdvAujourdhui) }},
                            loading: false,
                            fetchRdvs() {
                                this.loading = true;
                                fetch('{{ route('medecin.api.rdv') }}')
                                    .then(res => res.json())
                                    .then(data => {
                                        this.rdvs = data;
                                        this.loading = false;
                                    });
                            }
                         }"
                         x-init="setInterval(() => fetchRdvs(), 30000)">
                        <div class="px-8 py-6 border-b border-gray-50 dark:border-slate-700 flex justify-between items-center bg-[#F8FAFC] dark:bg-slate-800/50">
                            <h2 class="text-lg font-black text-[#0D47A1] dark:text-blue-400 flex items-center">
                                <span class="w-2 h-6 bg-[#1976D2] rounded-full mr-3"></span>
                                Prochaines consultations
                                <template x-if="loading">
                                    <span class="ml-3 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                    </span>
                                </template>
                            </h2>
                            <a href="{{ route('rdv.planning') }}" class="text-[#1976D2] dark:text-blue-400 text-sm font-bold hover:underline">Agenda complet</a>
                        </div>

                        <div class="p-8 space-y-4">
                            <template x-if="rdvs.length > 0">
                                <template x-for="rdv in rdvs" :key="rdv.heure + rdv.patient">
                                    <div class="flex items-center justify-between p-4 rounded-2xl border border-transparent hover:border-[#BBDEFB] dark:hover:border-slate-600 hover:bg-[#F1F8FE] dark:hover:bg-slate-800 transition-all group">
                                        <div class="flex items-center gap-5">
                                            <div class="bg-white dark:bg-slate-700 text-[#1976D2] dark:text-blue-300 px-4 py-2 rounded-xl text-sm font-black shadow-sm border border-blue-50 dark:border-slate-600 group-hover:bg-[#1976D2] group-hover:text-white transition-all" x-text="rdv.heure">
                                            </div>
                                            <div>
                                                <p class="font-black text-gray-900 dark:text-white text-base" x-text="rdv.patient"></p>
                                                <p class="text-gray-400 dark:text-slate-500 text-xs font-bold uppercase" x-text="rdv.motif || 'Consultation'"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter" 
                                                  :class="rdv.statut === 'confirmé' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400'"
                                                  x-text="rdv.statut">
                                            </span>

                                        </div>
                                    </div>
                                </template>
                            </template>
                            <template x-if="rdvs.length === 0">
                                <div class="text-center py-12">
                                    <p class="text-gray-400 dark:text-slate-500 font-bold italic">Aucun rendez-vous à venir.</p>
                                </div>
                            </template>
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
                                            {{ strtoupper(substr($patient->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-800 text-sm leading-tight">{{ $patient->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">
                                                Dernière visite : {{ $patient->consultationsAsPatient->first()?->created_at->format('d/m/Y') ?? 'Inconnue' }}
                                            </p>
                                        </div>
                                    </div>

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
                            <a href="{{ route('rdv.planning') }}" class="flex items-center p-4 bg-[#F1F8FE] rounded-2xl border border-[#BBDEFB] group hover:bg-[#1976D2] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1976D2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="ml-4 text-sm font-black text-[#0D47A1] group-hover:text-white transition">Agenda complet</div>
                            </a>
                             <a href="{{ route('consultation.create') }}" class="flex items-center p-4 bg-[#F8F7F4] rounded-2xl border border-gray-100 group hover:bg-gray-200 transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="ml-4 text-sm font-black text-gray-700 transition">Créer Ordonnance</div>
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

