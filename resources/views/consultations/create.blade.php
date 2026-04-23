<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 mt-4">
        
    </div>

    <div class="py-10 bg-[#FBFBFA] min-h-screen">
        <div class="max-w-3xl mx-auto px-4">

            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 flex items-center gap-2 mb-6 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span class="text-sm font-medium">Retour</span>
            </a>

            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Nouvelle consultation</h1>
                
            </div>

            <form action="{{ route('consultation.store') }}" method="POST" class="space-y-8">


                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Patient concerné</label>
                    <select name="patient_id" id="patient_id" class="form-control">
    <option value="">-- Sélectionnez le patient --</option>
    @foreach($patients as $patient)
        <option value="{{ $patient->id }}" {{ (isset($selectedPatient) && $selectedPatient->id == $patient->id) ? 'selected' : '' }}>
            {{ $patient->name }} {{-- Utilise 'name' car c'est le champ par défaut de la table users --}}
        </option>
    @endforeach
</select>
                </div>

                @csrf <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Examen clinique</h2>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Diagnostic</label>
                            <textarea name="diagnostic" rows="3" required class="w-full border-gray-200 rounded-2xl focus:ring-indigo-500 p-4 bg-gray-50/50" placeholder="Observations...">{{ old('diagnostic') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Traitement</label>
                            <textarea name="traitement" rows="3" required class="w-full border-gray-200 rounded-2xl focus:ring-indigo-500 p-4 bg-gray-50/50" placeholder="Protocole...">{{ old('traitement') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Ordonnance</h2>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Médicaments et posologie</label>
                        <textarea name="medicaments" rows="5" class="w-full border-gray-200 rounded-2xl focus:ring-green-500 p-4 bg-gray-50/50" placeholder="Ex: Paracétamol...">{{ old('medicaments') }}</textarea>
                        <p class="text-xs text-gray-400 mt-2 italic">Ce texte apparaîtra sur le PDF généré.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('consultations.index') }}" class="px-6 py-4 text-gray-500 font-medium hover:bg-gray-100 rounded-2xl transition">
                        Voir l'historique
                    </a>
                    <button type="submit" class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-black transition-all shadow-lg">
                        Enregistrer la consultation
                    </button>
                </div>
                
           @csrf </form>
        </div>
    </div>
</x-app-layout>