<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registre des Patients') }}
        </h2>
    </x-slot>

    {{-- En-tête --}}
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;" class="dark:text-blue-400">
                <i class="bi bi-people" style="color:#1a7f64; margin-right:8px;"></i>Liste des patients
            </h2>
            <p style="font-size:13px; color:#7f8c8d;" class="dark:text-slate-400">Tableau de bord · Gestion des patients</p>
        </div>
        <a href="{{ route('patients.create') }}" class="btn-primary-cm">
            <i class="bi bi-person-plus"></i> Nouveau patient
        </a>
    </div>

    {{-- Barre recherche + filtres --}}
    <div class="bg-white dark:bg-[#1e293b] p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 mb-8">
        <form method="GET" action="{{ route('patients.index') }}">
            <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                <div style="flex:1; min-width:200px; position:relative;">
                    <label class="text-xs font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest ml-1 mb-2 block">Rechercher</label>
                    <div style="position:relative;">
                        <i class="bi bi-search" style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#b0bec5; font-size:14px;"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..." 
                            class="block w-full pl-10 pr-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" />
                    </div>
                </div>
                <div style="min-width:160px;">
                    <label class="text-xs font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest ml-1 mb-2 block">Trier par</label>
                    <select name="sort" class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]">
                        <option value="recent" {{ request('sort','recent')=='recent' ? 'selected' : '' }}>Plus récent</option>
                        <option value="nom" {{ request('sort')=='nom' ? 'selected' : '' }}>Nom (A-Z)</option>
                        <option value="ancien" {{ request('sort')=='ancien' ? 'selected' : '' }}>Plus ancien</option>
                    </select>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="submit" class="px-6 py-3 bg-[#1976D2] text-white rounded-2xl font-bold text-sm shadow-sm hover:bg-[#0D47A1] transition-all">Filtrer</button>
                    <a href="{{ route('patients.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-2xl font-bold text-sm hover:bg-gray-200 transition-all">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tableau --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden p-6">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <p style="font-size:13px; color:#7f8c8d; margin:0;" class="dark:text-slate-400">
                <strong class="text-[#1a2632] dark:text-white">{{ $patients->total() }}</strong> patient(s) trouvé(s)
            </p>
            <span style="font-size:12px; color:#b0bec5;">Page {{ $patients->currentPage() }} / {{ $patients->lastPage() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="text-[#0D47A1] dark:text-blue-400 text-xs font-black uppercase tracking-widest">
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Téléphone</th>
                        <th class="px-4 py-3">Inscrit le</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr class="bg-[#F8FAFC] dark:bg-[#0f172a] hover:bg-[#F1F8FE] dark:hover:bg-slate-800 transition-colors">
                        <td class="px-4 py-4 rounded-l-2xl">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 text-[#1976D2] shadow-sm flex items-center justify-center font-black">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-black text-gray-900 dark:text-white text-sm">{{ $patient->name }}</div>
                                    <div class="text-[10px] text-gray-400 dark:text-slate-500 font-bold uppercase">ID #{{ $patient->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-600 dark:text-slate-400">{{ $patient->email }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-600 dark:text-slate-400">{{ $patient->telephone ?? '—' }}</td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-600 dark:text-slate-400">{{ $patient->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-4 rounded-r-2xl">
                            <div style="display:flex; gap:6px;">
                                <a href="{{ route('patients.show', $patient->id) }}" class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 font-bold italic text-sm">
                            <i class="bi bi-people" style="font-size:32px; display:block; margin-bottom:10px; color:#e8ecf0;"></i>
                            Aucun patient trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $patients->links() }}
        </div>
    </div>
</x-app-layout>
