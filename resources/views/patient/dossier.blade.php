<x-app-layout>
    <div class="py-12 bg-[#F8FAFC] dark:bg-[#0f172a] min-h-screen transition-colors duration-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-4xl font-black text-[#0D47A1] dark:text-blue-400 tracking-tight">Mon Dossier Médical</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Historique de vos consultations et diagnostics.</p>
                </div>
                <div class="bg-white dark:bg-[#1e293b] p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest">Total</div>
                        <div class="text-xl font-black text-gray-800 dark:text-white">{{ $consultations->count() }} Visites</div>
                    </div>
                </div>
            </div>

            @if($consultations->isEmpty())
                <div class="bg-white rounded-[2.5rem] p-20 text-center shadow-xl shadow-blue-900/5 border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-2.586 2.586a1 1 0 01-1.414 0L10 13l-2.586 2.586a1 1 0 01-1.414 0L4 13"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-2">Dossier vide</h3>
                    <p class="text-gray-500 font-medium">Vous n'avez pas encore de consultations enregistrées.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($consultations as $consultation)
                        <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] overflow-hidden shadow-xl shadow-blue-900/5 border border-gray-100 dark:border-slate-700 group hover:border-blue-200 dark:hover:border-blue-500/30 transition-all">
                            <div class="p-8">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 bg-[#E3F2FD] dark:bg-blue-900/30 rounded-2xl flex flex-col items-center justify-center text-[#1976D2] dark:text-blue-400">
                                            <span class="text-lg font-black leading-none">{{ $consultation->created_at->format('d') }}</span>
                                            <span class="text-[10px] font-black uppercase tracking-widest">{{ $consultation->created_at->translatedFormat('M') }}</span>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest">Médecin traitant</div>
                                            <div class="text-xl font-black text-gray-800 dark:text-white">Dr. {{ $consultation->medecin->name ?? 'Inconnu' }}</div>
                                        </div>
                                    </div>
                                    
                                    @if($consultation->ordonnance)
                                        <a href="{{ route('consultation.pdf', $consultation->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#1976D2] hover:bg-[#0D47A1] text-white rounded-xl font-black text-sm transition shadow-lg shadow-blue-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                            Télécharger l'ordonnance
                                        </a>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="bg-[#F8FAFC] rounded-2xl p-6 border border-gray-50">
                                        <div class="text-[10px] text-[#1976D2] font-black uppercase tracking-[0.2em] mb-3">Diagnostic</div>
                                        <p class="text-gray-700 font-medium leading-relaxed italic">"{{ $consultation->diagnostic }}"</p>
                                    </div>
                                    <div class="bg-[#F8FAFC] rounded-2xl p-6 border border-gray-50">
                                        <div class="text-[10px] text-[#3F51B5] font-black uppercase tracking-[0.2em] mb-3">Traitement préconisé</div>
                                        <p class="text-gray-700 font-medium leading-relaxed">{{ $consultation->traitement }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
