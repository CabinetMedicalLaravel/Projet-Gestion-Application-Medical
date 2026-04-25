<x-app-layout>
    <div class="py-12 bg-[#F8FAFC] min-h-screen font-sans">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-[#1E88E5] hover:text-[#1565C0] mb-8 group transition-all">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour au tableau de bord
            </a>

            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-4xl font-black text-[#0D47A1] tracking-tight">Nouvelle Consultation</h1>
                <p class="text-gray-500 mt-2 font-medium">Remplissez les détails cliniques et générez une ordonnance.</p>
            </div>

            <form action="{{ route('consultation.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Section 1: Patient Selection -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-blue-900/5 border border-gray-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-[#E3F2FD] rounded-2xl flex items-center justify-center text-[#1976D2]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h2 class="text-xl font-black text-gray-800">Sélection du Patient</h2>
                    </div>

                    <div class="relative">
                        <select name="patient_id" id="patient_id" required 
                                class="w-full bg-[#F8FAFC] border-2 border-gray-100 focus:border-[#1E88E5] focus:ring-0 rounded-2xl p-4 font-bold text-gray-700 transition-all appearance-none cursor-pointer">
                            <option value="" disabled {{ !isset($selectedPatient) ? 'selected' : '' }}>-- Choisissez un patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ (isset($selectedPatient) && $selectedPatient && $selectedPatient->id == $patient->id) ? 'selected' : '' }}>
                                    {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    @error('patient_id') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <!-- Section 2: Clinical Details -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-blue-900/5 border border-gray-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-[#E8EAF6] rounded-2xl flex items-center justify-center text-[#3F51B5]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-xl font-black text-gray-800">Détails Cliniques</h2>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Diagnostic & Observations</label>
                            <textarea name="diagnostic" rows="3" required 
                                      class="w-full bg-[#F8FAFC] border-2 border-gray-100 focus:border-[#1E88E5] focus:ring-0 rounded-2xl p-5 font-medium text-gray-700 transition-all placeholder:text-gray-300"
                                      placeholder="Saisissez vos observations médicales...">{{ old('diagnostic') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Protocole de Traitement</label>
                            <textarea name="traitement" rows="3" required 
                                      class="w-full bg-[#F8FAFC] border-2 border-gray-100 focus:border-[#1E88E5] focus:ring-0 rounded-2xl p-5 font-medium text-gray-700 transition-all placeholder:text-gray-300"
                                      placeholder="Décrivez le traitement à suivre...">{{ old('traitement') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Prescription -->
                <div class="bg-[#0D47A1] rounded-[2.5rem] p-8 shadow-2xl shadow-blue-900/20 text-white relative overflow-hidden">
                    <!-- Decoration -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <h2 class="text-xl font-black">Ordonnance (Médicaments)</h2>
                        </div>
                        
                        <textarea name="medicaments" rows="5" 
                                  class="w-full bg-white/10 border-2 border-white/10 focus:border-white/30 focus:ring-0 rounded-2xl p-5 font-bold text-white transition-all placeholder:text-white/30"
                                  placeholder="Ex: Paracétamol 500mg - 1 tab 3x par jour pendant 5 jours...">{{ old('medicaments') }}</textarea>
                        <p class="text-xs text-blue-200 mt-4 italic font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            Ce texte sera automatiquement formaté sur le document PDF officiel.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4">
                    <a href="{{ route('consultations.index') }}" class="text-gray-400 font-black uppercase text-xs tracking-widest hover:text-gray-600 transition p-4">
                        Annuler & Retour
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-[#1976D2] hover:bg-[#0D47A1] text-white px-12 py-5 rounded-2xl font-black text-lg shadow-xl shadow-blue-200 transform transition active:scale-95">
                        Enregistrer la Consultation
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>