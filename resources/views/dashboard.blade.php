
<x-app-layout>
    <!-- On définit les couleurs personnalisées en haut pour plus de clarté -->
    <div class="py-8 bg-[#F0F4F8] dark:bg-[#0f172a] min-h-screen font-sans text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- MESSAGE DE SUCCÈS -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-[#E3F2FD] dark:bg-blue-900/20 border border-[#2196F3] dark:border-blue-800 text-[#0D47A1] dark:text-blue-300 rounded-2xl font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-[#1976D2]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- EN-TÊTE AVEC BANNIÈRE DYNAMIQUE (DÉGRADÉ BLEU PRO) -->
            <div class="relative bg-gradient-to-r from-[#0D47A1] via-[#1565C0] to-[#1976D2] dark:from-[#1e293b] dark:to-[#0f172a] rounded-3xl p-8 mb-8 text-white shadow-xl overflow-hidden border border-transparent dark:border-slate-700">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight">Bonjour, {{ Auth::user()->name }} !</h1>
                        <p class="text-blue-50 mt-2 opacity-90 font-medium">
                            {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — Votre santé, notre priorité.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="h-20 w-20 rounded-full border-4 border-white/20 shadow-2xl object-cover">
                        @else
                            <div class="h-20 w-20 rounded-full bg-white/10 flex items-center justify-center border-4 border-white/20 text-2xl font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Décoration fond -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 opacity-10 text-white">
                    <svg width="250" height="250" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
                </div>
            </div>

            <!-- SECTION 1 : STATISTIQUES (BORDURES DÉGRADÉES DE BLEU) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Prochain RDV -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1E88E5]">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Prochain RDV</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1976D2]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    @if(count($rdv) > 0)
                        <p class="text-3xl font-black text-[#0D47A1]">{{ $rdv[0]['jour'] }} {{ $rdv[0]['mois'] }}</p>
                        <p class="text-[#1E88E5] font-bold mt-1 uppercase text-xs">Dr. {{ $rdv[0]['medecin'] }}</p>
                    @else
                        <p class="text-xl font-bold text-gray-400 mt-2 italic">Aucun RDV prévu</p>
                    @endif
                </div>

                <!-- Total RDV -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1565C0]">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total RDV</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1565C0]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $totalRdv }}</p>
                    <p class="text-gray-400 text-xs font-bold mt-1 uppercase tracking-tighter">Historique complet</p>
                </div>


                <!-- Ordonnances -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#2196F3]">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Ordonnances</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#2196F3]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbOrdonnances }}</p>
                    <p class="text-gray-400 text-xs font-bold mt-1 uppercase tracking-tighter">disponibles</p>
                </div>
            </div>

            <!-- SECTION 2 : CONTENU PRINCIPAL -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- COLONNE GAUCHE -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Carte : Mes prochains rendez-vous -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-[#F8FAFC] flex justify-between items-center">
                            <h2 class="text-lg font-black text-[#0D47A1]">Mes prochains rendez-vous</h2>
                            <a href="{{ route('rdv.mes-rdv') }}" class="text-[#1976D2] text-sm font-black hover:text-[#0D47A1] uppercase tracking-tight transition">Voir tout</a>
                        </div>
                        <div class="p-8">
                            <div class="space-y-4">
                                @forelse ($rdv as $rendezVous)
                                    <div class="flex items-center justify-between p-5 rounded-2xl border border-transparent hover:border-[#BBDEFB] hover:bg-[#F1F8FE] transition-all duration-200">
                                        <div class="flex items-center gap-5">
                                            <div class="bg-[#1976D2] text-white rounded-2xl p-2 flex flex-col items-center justify-center w-16 h-16 shadow-lg shadow-blue-100">
                                                <span class="text-xl font-black leading-none">{{ $rendezVous['jour'] }}</span>
                                                <span class="text-[10px] font-black uppercase tracking-tighter">{{ $rendezVous['mois'] }}</span>
                                            </div>
                                            <div>
                                                <p class="font-black text-[#0D47A1] text-lg leading-tight">Dr. {{ $rendezVous['medecin'] }}</p>
                                                <p class="text-[#1E88E5] text-sm font-bold italic">{{ $rendezVous['specialite'] ?? 'Consultation' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-gray-900 text-base">{{ $rendezVous['heure'] }}</p>
                                            <span class="inline-flex items-center px-4 py-1 mt-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-emerald-100 text-emerald-700">
                                                {{ $rendezVous['statut'] }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-400 font-bold italic">Aucun rendez-vous à venir.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Carte : Notifications -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-8 flex items-center">
                            <span class="w-2 h-6 bg-[#1976D2] rounded-full mr-3"></span>
                            Centre de Notifications
                        </h2>
                        <div class="space-y-6">
                            @forelse ($notifications as $notif)
                                <div class="flex gap-5 p-4 rounded-2xl bg-[#F8FAFC] border border-transparent hover:border-[#BBDEFB] transition duration-300">
                                    <div class="mt-1"><div class="w-2.5 h-2.5 bg-[#1E88E5] rounded-full ring-4 ring-blue-50 shadow-sm"></div></div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $notif['message'] }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase font-black tracking-widest">{{ $notif['date'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-center py-6 italic text-sm">Aucune notification.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE : ACTIONS (RACCOURCIS BLEUS) -->
                <div class="space-y-8">
                    <!-- Actions rapides -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 tracking-tighter">Raccourcis</h2>
                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('rdv.create') }}" class="flex items-center p-4 bg-[#F1F8FE] rounded-2xl border border-[#BBDEFB] group hover:bg-[#1976D2] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1976D2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-black text-[#0D47A1] group-hover:text-white transition text-sm">Prendre RDV</h3>
                                </div>
                            </a>

                            <a href="{{ route('patient.dossier') }}" class="flex items-center p-4 bg-[#E3F2FD] rounded-2xl border border-[#90CAF9] group hover:bg-[#1565C0] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1565C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-black text-[#0D47A1] group-hover:text-white transition text-sm">Dossier Médical</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
