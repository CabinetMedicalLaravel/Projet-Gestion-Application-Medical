<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fiche Patient') }} — {{ $patient->name }}
        </h2>
    </x-slot>

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;" class="dark:text-blue-400">
                <i class="bi bi-person-lines-fill" style="color:#1a7f64; margin-right:8px;"></i>Fiche patient
            </h2>
            <p style="font-size:13px; color:#7f8c8d;" class="dark:text-slate-400">Informations personnelles et détails du patient</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('patients.edit', $patient->id) }}" class="px-6 py-2.5 bg-amber-500 text-white rounded-2xl font-bold text-sm hover:bg-amber-600 transition-all shadow-sm">
                <i class="bi bi-pencil mr-1"></i> Modifier
            </a>
            <a href="{{ route('patients.index') }}" class="px-6 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-200 rounded-2xl font-bold text-sm hover:bg-gray-300 dark:hover:bg-slate-600 transition-all">
                <i class="bi bi-arrow-left mr-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Carte identité --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 text-center shadow-sm border border-gray-100 dark:border-slate-700">
                <div class="w-20 h-20 rounded-2xl bg-[#E3F2FD] dark:bg-blue-900/30 text-[#0D47A1] dark:text-blue-400 text-3xl font-black flex items-center justify-center mx-auto mb-4 shadow-sm">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
                <div class="text-xl font-black text-gray-900 dark:text-white mb-1">{{ $patient->name }}</div>
                <div class="mb-6">
                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-widest">Patient Actif</span>
                </div>
                <div class="pt-6 border-t border-gray-50 dark:border-slate-800 text-[11px] font-bold text-gray-400 uppercase tracking-tighter">
                    Inscrit depuis le {{ $patient->created_at->format('d F Y') }}
                </div>
            </div>

            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-xs font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6 flex items-center">
                    <span class="w-1 h-4 bg-blue-500 rounded-full mr-2"></span>
                    Coordonnées
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-envelope text-blue-500"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mb-0.5">Email</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-slate-300 truncate">{{ $patient->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-telephone text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mb-0.5">Téléphone</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-slate-300">{{ $patient->telephone ?? 'Non renseigné' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Infos détaillées --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-lg font-black text-[#0D47A1] dark:text-blue-400 mb-8 flex items-center">
                    <span class="w-2 h-6 bg-[#1565C0] rounded-full mr-3"></span>
                    Informations du Dossier
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nom complet</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $patient->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Adresse Email</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $patient->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Contact Téléphonique</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $patient->telephone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Date de création</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $patient->created_at->translatedFormat('d F Y à H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Dernière Mise à jour</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $patient->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Actions de gestion</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="flex flex-col items-center p-6 bg-[#F8FAFC] dark:bg-[#0f172a] rounded-2xl hover:bg-[#E3F2FD] dark:hover:bg-slate-800 transition-all group">
                        <div class="p-3 bg-white dark:bg-slate-700 rounded-xl shadow-sm mb-3 group-hover:scale-110 transition-transform text-amber-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <span class="text-sm font-black text-gray-700 dark:text-slate-300">Modifier</span>
                    </a>
                    
                    <a href="{{ route('patients.historique', $patient->id) }}" class="flex flex-col items-center p-6 bg-[#F8FAFC] dark:bg-[#0f172a] rounded-2xl hover:bg-[#E3F2FD] dark:hover:bg-slate-800 transition-all group">
                        <div class="p-3 bg-white dark:bg-slate-700 rounded-xl shadow-sm mb-3 group-hover:scale-110 transition-transform text-blue-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-sm font-black text-gray-700 dark:text-slate-300">Historique</span>
                    </a>

                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce patient ?')" class="flex">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full flex flex-col items-center p-6 bg-red-50 dark:bg-red-900/10 rounded-2xl hover:bg-red-100 dark:hover:bg-red-900/20 transition-all group">
                            <div class="p-3 bg-white dark:bg-slate-700 rounded-xl shadow-sm mb-3 group-hover:scale-110 transition-transform text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <span class="text-sm font-black text-red-600">Supprimer</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
