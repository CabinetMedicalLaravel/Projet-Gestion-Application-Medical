<x-guest-layout>
    <div class="font-sans">
        {{-- Logo Icône --}}
        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 bg-[#1976D2] rounded-2xl shadow-lg flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-black text-[#0D47A1] text-center mb-2">Créer un compte</h1>
        <p class="text-[#64748B] text-center font-medium mb-8">Choisissez votre profil pour commencer</p>

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="role" id="role-input" value="patient" />

            {{-- Sélection du rôle --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <!-- Carte Patient -->
                <div id="role-patient" onclick="selectRole('patient')" 
                    class="cursor-pointer p-5 rounded-[1.5rem] border-2 border-[#E3F2FD] bg-[#F8FAFC] transition-all duration-300 hover:border-[#2196F3] active-role shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center mb-3 text-[#1976D2]" id="icon-patient">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <p class="font-black text-[#0D47A1] text-sm">Patient</p>
                    <p class="text-[11px] text-[#64748B] font-medium leading-tight">Accès à vos rendez-vous</p>
                </div>

                <!-- Carte Staff -->
                <div id="role-staff" onclick="selectRole('staff')" 
                    class="cursor-pointer p-5 rounded-[1.5rem] border-2 border-[#E3F2FD] bg-[#F8FAFC] transition-all duration-300 hover:border-[#2196F3] shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center mb-3 text-[#64748B]" id="icon-staff">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <p class="font-black text-[#0D47A1] text-sm">Médecin / Secrétaire</p>
                    <p class="text-[11px] text-[#64748B] font-medium leading-tight">Accès personnel médical</p>
                </div>
            </div>

            {{-- Code d'accès (Masqué par défaut) --}}
            <div id="code-box" class="hidden animate-fade-in bg-[#FFFBEB] border border-[#FEF3C7] p-5 rounded-2xl">
                <label class="text-xs font-black text-[#92400E] uppercase tracking-widest mb-1 block">Code d'accès secret</label>
                <p class="text-[11px] text-[#B45309] font-medium mb-3">Réservé au personnel. Contactez l'administrateur.</p>
                <input type="password" id="access_code" name="access_code"
                    class="block w-full px-4 py-3 bg-white border-none rounded-xl text-sm focus:ring-2 focus:ring-[#D97706]" placeholder="Ex: MEDECIN2026" />
            </div>

            {{-- Nom complet --}}
            <div class="space-y-2">
                <label for="name" class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Nom complet</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#1E88E5]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="block w-full pl-11 pr-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" placeholder="Hajar Benali" />
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <label for="email" class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Adresse e-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#1E88E5]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 7 10-7"/></svg>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="block w-full pl-11 pr-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" placeholder="vous@exemple.com" />
                </div>
            </div>

            {{-- Téléphone --}}
            <div id="phone-field" class="space-y-2">
                <label for="telephone" class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Numéro de téléphone</label>
                <div class="flex gap-2">
                    <select name="indicatif" class="bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] py-4">
                        <option value="+212">🇲🇦 +212</option>
                        <option value="+33">🇫🇷 +33</option>
                    </select>
                    <input id="telephone" name="telephone" type="tel" value="{{ old('telephone') }}"
                        class="block w-full px-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" placeholder="06 12 34 56 78" />
                </div>
            </div>

            {{-- Mots de passe --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Mot de passe</label>
                    <input id="password" name="password" type="password" required
                        class="block w-full px-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" placeholder="••••••••" />
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Confirmation</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block w-full px-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" placeholder="••••••••" />
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#0D47A1] to-[#1976D2] text-white font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-blue-200 hover:shadow-xl transform transition active:scale-95">
                S'inscrire
            </button>

            <p class="text-center text-[#94A3B8] text-sm font-medium mt-6">
                Déjà inscrit ? <a href="{{ route('login') }}" class="text-[#1976D2] font-black hover:underline ml-1">Se connecter</a>
            </p>
        </form>
    </div>

    <style>
        .active-role { 
            border-color: #0D47A1 !important; 
            background-color: #F0F7FF !important; 
            box-shadow: 0 10px 20px -5px rgba(13, 71, 161, 0.1) !important;
        }
    </style>

    <script>
    function selectRole(r) {
        const isPatient = r === 'patient';
        
        // Classes des cartes
        document.getElementById('role-patient').classList.toggle('active-role', isPatient);
        document.getElementById('role-staff').classList.toggle('active-role', !isPatient);
        
        // Icônes
        document.getElementById('icon-patient').classList.toggle('text-[#1976D2]', isPatient);
        document.getElementById('icon-patient').classList.toggle('text-[#64748B]', !isPatient);
        document.getElementById('icon-staff').classList.toggle('text-[#1976D2]', !isPatient);
        document.getElementById('icon-staff').classList.toggle('text-[#64748B]', isPatient);

        // Visibilité des champs
        document.getElementById('code-box').classList.toggle('hidden', isPatient);
        document.getElementById('phone-field').classList.toggle('hidden', !isPatient);
        
        // Valeurs des inputs
        document.getElementById('role-input').value = r;
        document.getElementById('telephone').required = isPatient;
        document.getElementById('access_code').required = !isPatient;
    }
    </script>
</x-guest-layout>