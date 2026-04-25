<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historique Médical') }} — {{ $patient->name }}
        </h2>
    </x-slot>

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;" class="dark:text-blue-400">
                <i class="bi bi-clock-history" style="color:#1a7f64; margin-right:8px;"></i>Historique médical
            </h2>
            <p style="font-size:13px; color:#7f8c8d;" class="dark:text-slate-400">Consultations passées · Ordonnances · Dossier de <strong>{{ $patient->name }}</strong></p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('patients.show', $patient->id) }}" class="px-6 py-2.5 bg-blue-500 text-white rounded-2xl font-bold text-sm hover:bg-blue-600 transition-all shadow-sm">
                <i class="bi bi-person-lines-fill mr-1"></i> Fiche patient
            </a>
            <a href="{{ route('patients.index') }}" class="px-6 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-200 rounded-2xl font-bold text-sm hover:bg-gray-300 dark:hover:bg-slate-600 transition-all">
                <i class="bi bi-arrow-left mr-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Colonne gauche — résumé patient --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 text-center shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="w-20 h-20 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-3xl font-black flex items-center justify-center mx-auto mb-4 shadow-sm">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
                <div class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $patient->name }}</div>
                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-widest">Patient Actif</span>
                
                <div class="mt-8 pt-6 border-t border-gray-50 dark:border-slate-800">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-[#0f172a] rounded-2xl p-4">
                            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ count($consultations ?? []) }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Consults</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-[#0f172a] rounded-2xl p-4">
                            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ count($ordonnances ?? []) }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Ordos</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtres --}}
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-xs font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6 flex items-center">
                    <span class="w-1 h-4 bg-blue-500 rounded-full mr-2"></span>
                    Filtrer l'Historique
                </h3>
                <form method="GET" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Type de document</label>
                        <select name="type" class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]">
                            <option value="">Tous les types</option>
                            <option value="consultation">Consultations uniquement</option>
                            <option value="ordonnance">Ordonnances uniquement</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Période</label>
                        <select name="periode" class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]">
                            <option value="">Toute l'historique</option>
                            <option value="3m">3 derniers mois</option>
                            <option value="6m">6 derniers mois</option>
                            <option value="1y">Cette année</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-4 bg-[#1976D2] text-white rounded-2xl font-black text-xs shadow-lg hover:bg-[#0D47A1] transition-all transform hover:-translate-y-1">
                        Appliquer les filtres
                    </button>
                </form>
            </div>
        </div>

        {{-- Colonne droite — Timeline --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Consultations --}}
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-lg font-black text-[#0D47A1] dark:text-blue-400 mb-8 flex items-center">
                    <span class="w-2 h-6 bg-[#1565C0] rounded-full mr-3"></span>
                    Chronologie des Consultations
                </h3>

                <div class="space-y-8 relative before:content-[''] before:absolute before:left-5 before:top-4 before:bottom-0 before:w-0.5 before:bg-gray-100 dark:before:bg-slate-800">
                    @forelse($consultations ?? [] as $consultation)
                    <div class="relative pl-12">
                        <div class="absolute left-0 top-1 w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center z-10 border-4 border-white dark:border-[#1e293b]">
                            <i class="bi bi-stethoscope"></i>
                        </div>
                        <div class="bg-[#F8FAFC] dark:bg-[#0f172a] rounded-2xl p-6 shadow-sm border border-gray-50 dark:border-slate-800">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-black text-gray-900 dark:text-white">{{ $consultation['motif'] ?? 'Consultation standard' }}</h4>
                                <span class="text-[10px] font-black text-blue-500 uppercase">{{ $consultation['date'] ?? 'Date inconnue' }}</span>
                            </div>
                            <p class="text-xs font-bold text-gray-500 dark:text-slate-400 mb-4">Dr. {{ $consultation['medecin'] ?? 'Praticien' }}</p>
                            @if(isset($consultation['notes']))
                            <div class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed italic bg-white dark:bg-slate-800/50 p-4 rounded-xl border-l-4 border-blue-200 dark:border-blue-900">
                                "{{ $consultation['notes'] }}"
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-400 font-bold italic text-sm">Aucune consultation dans l'historique.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Ordonnances --}}
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-lg font-black text-[#0D47A1] dark:text-blue-400 mb-8 flex items-center">
                    <span class="w-2 h-6 bg-emerald-500 rounded-full mr-3"></span>
                    Documents & Ordonnances
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($ordonnances ?? [] as $ordonnance)
                    <div class="flex items-center gap-4 p-4 bg-[#F8FAFC] dark:bg-[#0f172a] rounded-2xl border border-gray-50 dark:border-slate-800 hover:border-emerald-200 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-file-earmark-medical text-xl"></i>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-sm font-black text-gray-900 dark:text-white truncate">{{ $ordonnance['titre'] ?? 'Ordonnance médicale' }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $ordonnance['date'] ?? 'N/A' }}</p>
                        </div>
                        <a href="#" class="p-2 bg-white dark:bg-slate-700 rounded-lg text-emerald-600 dark:text-emerald-400 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-10">
                        <p class="text-gray-400 font-bold italic text-sm">Aucun document disponible.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
