<x-app-layout>
    <div class="py-8 bg-[#F0F4F8] min-h-screen font-sans text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- EN-TÊTE AVEC BANNIÈRE ADMINISTRATIVE (DÉGRADÉ BLEU DE TON IMAGE) -->
            <div class="relative bg-gradient-to-r from-[#0D47A1] via-[#1565C0] to-[#1976D2] rounded-3xl p-8 mb-8 text-white shadow-xl overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Portail Secrétariat — {{ Auth::user()->name }}</h1>
                        <p class="text-blue-50 mt-2 opacity-90 font-medium">
                            {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — Supervision du flux clinique
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center bg-white/10 px-6 py-3 rounded-2xl backdrop-blur-md border border-white/20">
                        <div class="text-right mr-4">
                            <p class="text-xs uppercase font-bold text-blue-100">Statut Clinique</p>
                            <p class="text-sm font-bold">Opérationnel</p>
                        </div>
                        <div class="h-3 w-3 bg-[#4ade80] rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 opacity-10">
                    <svg width="300" height="300" fill="white" viewBox="0 0 100 100"><rect width="100" height="100" rx="20" transform="rotate(25)"/></svg>
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
                </div>

                <!-- En Attente -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1976D2]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">En Attente</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1976D2]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbEnAttente ?? 0 }}</p>
                </div>

                <!-- Nouveaux Patients -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#1E88E5]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">Nouveaux Patients</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#1E88E5]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbNouveauxPatients ?? 0 }}</p>
                </div>

                <!-- Médecins -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all border-l-4 border-[#2196F3]">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-black text-gray-400 uppercase">Médecins Actifs</p>
                        <div class="p-2 bg-[#E3F2FD] rounded-xl text-[#2196F3]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                    </div>
                    <p class="text-3xl font-black text-[#0D47A1]">{{ $nbMedecins ?? 0 }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

/* Main grid */
.main-grid  { display:grid; grid-template-columns:1fr 340px; gap:1.5rem; }
@media(max-width:1024px){ .main-grid { grid-template-columns:1fr; } }

                    <!-- Demandes en attente -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-[#F1F8FE] flex justify-between items-center">
                            <h2 class="text-lg font-black text-[#0D47A1] flex items-center">
                                <span class="w-2 h-6 bg-[#1976D2] rounded-full mr-3"></span>
                                Demandes en attente
                            </h2>
                            <button class="text-[#1565C0] text-sm font-bold hover:underline">Gérer tout</button>
                        </div>
                        <div class="p-8 space-y-4">
                            @forelse ($rdvEnAttente ?? [] as $rdv)
                                <div class="flex items-center justify-between p-4 rounded-2xl border border-transparent hover:border-[#BBDEFB] transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-[#E3F2FD] text-[#0D47A1] flex items-center justify-center font-black">
                                            {{ strtoupper(substr($rdv['patient'], 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-900">{{ $rdv['patient'] }}</p>
                                            <p class="text-gray-400 text-xs font-bold uppercase italic">Dr. {{ $rdv['medecin'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-colors shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></button>
                                        <button class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-400 py-4 font-bold italic">Aucune demande.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Agenda global -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 flex items-center">
                            <span class="w-2 h-6 bg-[#1565C0] rounded-full mr-3"></span>
                            Agenda global du jour
                        </h2>
                        <div class="space-y-4">
                            @forelse ($rdvAujourdhui ?? [] as $rdv)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-[#F8FAFC]">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-white text-[#1565C0] px-3 py-1 rounded-lg text-sm font-black border border-[#BBDEFB] shadow-sm">{{ $rdv['heure'] }}</div>
                                        <p class="font-black text-gray-800 text-sm">{{ $rdv['patient'] }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-emerald-100 text-emerald-700">{{ $rdv['statut'] }}</span>
                                </div>
                            @empty
                                <p class="text-gray-400 text-center font-bold italic">Rien de prévu.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:2rem 1rem;color:var(--sub);">
                        <svg style="width:36px;height:36px;margin:0 auto .75rem;opacity:.4;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p style="font-size:13px;">Aucune demande en attente.</p>
                    </div>
                @endforelse
            </div>

                <!-- COLONNE DROITE -->
                <div class="space-y-8">
                    <!-- Actions -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6">Raccourcis</h2>
                        <div class="grid grid-cols-1 gap-4">
                            <a href="#" class="flex items-center p-4 bg-[#F1F8FE] rounded-2xl border border-[#BBDEFB] group hover:bg-[#1976D2] transition-all duration-300">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1976D2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <div class="ml-4"><p class="font-black text-[#0D47A1] group-hover:text-white transition text-sm">Nouveau RDV</p></div>
                            </a>
                            <a href="#" class="flex items-center p-4 bg-[#E3F2FD] rounded-2xl border border-[#90CAF9] group hover:bg-[#1565C0] transition-all duration-300 shadow-sm">
                                <div class="bg-white p-3 rounded-xl shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-[#1565C0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="ml-4"><p class="font-black text-[#0D47A1] group-hover:text-white transition text-sm">Registre Patients</p></div>
                            </a>
                        </div>
                        @if($rdv['statut'] === 'confirme')
                            <span class="badge badge-green"><span class="badge-dot"></span>Confirmé</span>
                        @else
                            <span class="badge badge-orange"><span class="badge-dot"></span>En attente</span>
                        @endif
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--sub);text-align:center;padding:1.5rem 0;">Aucun rendez-vous aujourd'hui.</p>
                @endforelse
            </div>
        </div>

                    <!-- Activités & Notifications -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <h2 class="text-lg font-black text-[#0D47A1] mb-6 flex justify-between items-center">
                            Activité <span class="w-2 h-2 bg-[#1E88E5] rounded-full animate-ping"></span>
                        </h2>
                        <div class="space-y-6">
                            @forelse ($notifications ?? [] as $notif)
                                <div class="flex gap-4 relative">
                                    <div class="z-10 bg-[#1E88E5] h-2.5 w-2.5 rounded-full mt-1.5 shadow-sm"></div>
                                    <div class="border-l border-gray-100 pl-4 -ml-5.5 pb-2">
                                        <p class="text-sm font-black text-gray-800 leading-tight">{{ $notif['message'] }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase">{{ $notif['date'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-center text-xs font-bold italic">Rien à signaler.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Bloc Aide/Contact Urgent (BLEU MARINE FONCÉ) -->
                    <div class="bg-[#0D47A1] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl">
                        <h3 class="font-black text-lg mb-2 relative z-10 tracking-tight">Assistance Admin</h3>
                        <p class="text-blue-100 text-xs mb-6 relative z-10 font-medium opacity-80 leading-relaxed">Contacter l'administrateur système pour toute erreur technique.</p>
                        <a href="mailto:admin@clinique.com" class="block text-center py-3 bg-white/10 hover:bg-white/20 rounded-xl font-black text-sm transition relative z-10 tracking-widest uppercase border border-white/10 shadow-inner">Support Technique</a>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#1976D2] rounded-full opacity-30"></div>
                    </div>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="panel">
                <div class="panel-title" style="margin-bottom:1rem;">Notifications</div>
                @forelse($notifications ?? [] as $notif)
                    <div class="notif-item">
                        <span class="notif-dot warning"></span>
                        <div>
                            <div class="notif-msg">{{ $notif['message'] }}</div>
                            <div class="notif-date">{{ $notif['date'] }}</div>
                        </div>
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--sub);text-align:center;padding:1rem 0;">Aucune notification.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
