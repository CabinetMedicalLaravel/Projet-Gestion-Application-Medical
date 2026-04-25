<x-app-layout>
    <div class="py-8 bg-[#F0F4F8] dark:bg-[#0f172a] min-h-screen font-sans text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- EN-TÊTE AVEC BANNIÈRE ADMINISTRATIVE -->
            <div class="relative bg-gradient-to-r from-[#0D47A1] via-[#1565C0] to-[#1976D2] dark:from-[#1e293b] dark:to-[#0f172a] rounded-3xl p-8 mb-8 text-white shadow-xl overflow-hidden border border-transparent dark:border-slate-700">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight">Gestion des Créneaux</h1>
                        <p class="text-blue-50 mt-2 opacity-90 font-medium">
                            Définissez les horaires de travail et les disponibilités des médecins.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl text-sm font-bold text-white transition-all shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Retour au Tableau de Bord
                        </a>
                    </div>
                </div>
                <!-- Décoration fond -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 opacity-10 text-white">
                    <svg width="250" height="250" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
                </div>
            </div>

            <!-- MESSAGE DE SUCCÈS -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-2xl font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- COLONNE GAUCHE : FILTRE ET AJOUT -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- SÉLECTION MÉDECIN -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                        <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-4">Sélectionner un Médecin</h3>
                        <form method="GET" action="{{ route('admin.creneaux') }}">
                            <div class="relative">
                                <select name="medecin_id" onchange="this.form.submit()" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-[#1E88E5] transition-all">
                                    @foreach($medecins as $medecin)
                                        <option value="{{ $medecin->id }}" {{ $medecin->id == $medecinId ? 'selected' : '' }}>
                                            Dr. {{ $medecin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- FORMULAIRE AJOUT -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
                        <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Ajouter un Créneau</h3>
                        <form method="POST" action="{{ route('admin.creneaux.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="medecin_id" value="{{ $medecinId }}">
                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jour de la semaine</label>
                                <select name="jour_semaine" required class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-[#1E88E5]">
                                    <option value="1">Lundi</option>
                                    <option value="2">Mardi</option>
                                    <option value="3">Mercredi</option>
                                    <option value="4">Jeudi</option>
                                    <option value="5">Vendredi</option>
                                    <option value="6">Samedi</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Début</label>
                                    <input type="time" name="heure_debut" required class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-[#1E88E5]">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Fin</label>
                                    <input type="time" name="heure_fin" required class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-[#1E88E5]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Durée (minutes)</label>
                                <select name="duree" class="w-full bg-gray-50 dark:bg-slate-800 border-none rounded-2xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-[#1E88E5]">
                                    <option value="15">15 min</option>
                                    <option value="20">20 min</option>
                                    <option value="30" selected>30 min</option>
                                    <option value="45">45 min</option>
                                    <option value="60">1 heure</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full mt-4 py-4 bg-gradient-to-r from-[#0D47A1] to-[#1976D2] hover:from-[#1565C0] hover:to-[#1E88E5] text-white rounded-2xl font-bold shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                                Ajouter le créneau
                            </button>
                        </form>
                    </div>
                </div>

                <!-- COLONNE DROITE : LISTE -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-[#1e293b] rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 dark:border-slate-800 flex justify-between items-center">
                            <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest">Créneaux Configurés</h3>
                            <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-[#0D47A1] dark:text-blue-400 text-[10px] font-black rounded-full uppercase">
                                {{ count($creneaux) }} Groupes
                            </span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50/50 dark:bg-slate-800/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jour</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Horaires</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Durée</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Statut</th>
                                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                                    @php
                                        $joursMap = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
                                    @endphp
                                    @forelse($creneaux as $jourNum => $groupe)
                                        @foreach($groupe as $creneau)
                                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                                <td class="px-6 py-4">
                                                    <span class="font-bold text-gray-700 dark:text-slate-300">{{ $joursMap[$jourNum] }}</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        <span class="px-2 py-1 bg-gray-100 dark:bg-slate-800 rounded-lg text-xs font-bold mr-2">
                                                            {{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }}
                                                        </span>
                                                        <span class="text-gray-400">—</span>
                                                        <span class="px-2 py-1 bg-gray-100 dark:bg-slate-800 rounded-lg text-xs font-bold ml-2">
                                                            {{ \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-sm font-medium text-gray-500">{{ $creneau->duree }} min</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($creneau->est_actif)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Actif
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 dark:bg-slate-800 dark:text-slate-400">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span> Inactif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex justify-end gap-2">
                                                        <form method="POST" action="{{ route('admin.creneaux.toggle', $creneau) }}">
                                                            @csrf
                                                            <button class="p-2 {{ $creneau->est_actif ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50' }} rounded-xl transition-colors" title="{{ $creneau->est_actif ? 'Désactiver' : 'Activer' }}">
                                                                @if($creneau->est_actif)
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                                @else
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                @endif
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.creneaux.delete', $creneau) }}" onsubmit="return confirm('Supprimer ce créneau ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Supprimer">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <p class="text-gray-400 font-medium">Aucun créneau configuré pour ce médecin.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>