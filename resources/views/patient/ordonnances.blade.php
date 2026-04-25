<x-app-layout>
    <div class="py-12 bg-[#F8FAFC] dark:bg-[#0f172a] min-h-screen transition-colors duration-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-4xl font-black text-[#0D47A1] dark:text-blue-400 tracking-tight">Mes Ordonnances</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Retrouvez tous vos traitements prescrits par nos médecins.</p>
            </div>

            @if($ordonnances->isEmpty())
                <div class="bg-white rounded-[2.5rem] p-20 text-center shadow-xl shadow-blue-900/5 border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-2">Aucune ordonnance</h3>
                    <p class="text-gray-500 font-medium">Vous n'avez pas encore d'ordonnances disponibles.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($ordonnances as $ordonnance)
                        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden group hover:border-blue-200 transition-all">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-sm font-black text-gray-400">{{ \Carbon\Carbon::parse($ordonnance->date)->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-green-100">Disponible</div>
                                </div>

                                <div class="mb-8">
                                    <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Médecin</div>
                                    <div class="text-xl font-black text-gray-800">Dr. {{ $ordonnance->consultation->medecin->name ?? 'Cabinet Médical' }}</div>
                                </div>

                                <div class="bg-[#F8FAFC] rounded-2xl p-6 border border-gray-50 mb-8 min-h-[120px]">
                                    <div class="text-[10px] text-[#1976D2] font-black uppercase tracking-widest mb-3">Traitement</div>
                                    <p class="text-gray-700 font-bold leading-relaxed">{!! nl2br(e($ordonnance->contenu)) !!}</p>
                                </div>

                                <a href="{{ route('consultation.pdf', $ordonnance->consultation_id) }}" class="w-full flex items-center justify-center gap-2 py-4 bg-[#1976D2] hover:bg-[#0D47A1] text-white rounded-xl font-black transition shadow-lg shadow-blue-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Télécharger le PDF
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
