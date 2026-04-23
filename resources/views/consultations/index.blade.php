<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl p-8 border border-gray-100">
            
            <div class="flex justify-between items-center mb-10">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 flex items-center gap-2 mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span class="text-sm font-medium">Retour</span>
            </a>

                <div>
                    <h2 class="text-3xl font-extrabold text-[#0D47A1]">Historique Médical</h2>
                    @vite(['resources/css/app.css', 'resources/js/app.js'])
                    <p class="text-gray-500 text-sm mt-1">Liste complète des consultations rédigées</p>
                </div>
                <span class="bg-[#2196F3]/10 text-[#1976D2] text-xs font-bold px-4 py-2 rounded-full border border-[#2196F3]/20">
                    {{ $consultations->count() }} consultations au total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-[#1565C0] text-xs uppercase tracking-widest px-6">
                            <th class="px-6 py-4 font-bold">Date</th>
                            <th class="px-6 py-4 font-bold">Patient</th>
                            <th class="px-6 py-4 font-bold">Diagnostic</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr class="bg-white hover:bg-blue-50/50 transition-all shadow-sm border border-gray-100">
                            <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-50">
                                <span class="block font-bold text-gray-900">{{ $consultation->created_at->format('d/m/Y') }}</span>
                                <span class="text-xs text-[#1E88E5]">{{ $consultation->created_at->format('H:i') }}</span>
                            </td>
                            
                            <td class="px-6 py-5 border-y border-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#2196F3]/10 flex items-center justify-center text-[#1976D2] font-bold text-xs">
                                        {{ substr($consultation->patient->name ?? 'P', 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-800">{{ strtoupper($consultation->patient->name ?? 'Inconnu') }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-5 border-y border-gray-50">
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-[#2196F3]/5 text-[#0D47A1] border border-[#2196F3]/10">
                                    {{ Str::limit($consultation->diagnostic, 30) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
    <a href="{{ route('consultation.pdf', $consultation->id) }}" 
       class="inline-flex items-center px-4 py-2 bg-[#1976D2] text-white rounded-lg hover:bg-[#0D47A1] transition-all">
        
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>

        Imprimer
    </a>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>