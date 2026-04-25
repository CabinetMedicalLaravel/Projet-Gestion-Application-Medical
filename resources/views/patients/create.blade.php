<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enregistrer un Nouveau Patient') }}
        </h2>
    </x-slot>

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;" class="dark:text-blue-400">
                <i class="bi bi-person-plus" style="color:#1a7f64; margin-right:8px;"></i>Créer un patient
            </h2>
            <p style="font-size:13px; color:#7f8c8d;" class="dark:text-slate-400">Formulaire d'inscription rapide pour le secrétariat</p>
        </div>
        <a href="{{ route('patients.index') }}" class="px-6 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-200 rounded-2xl font-bold text-sm hover:bg-gray-300 dark:hover:bg-slate-600 transition-all">
            <i class="bi bi-arrow-left mr-1"></i> Retour à la liste
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        {{-- FORMULAIRE PRINCIPAL --}}
        <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
            <h3 class="text-lg font-black text-[#0D47A1] dark:text-blue-400 mb-8 flex items-center">
                <span class="w-2 h-6 bg-[#1565C0] rounded-full mr-3"></span>
                Informations du Patient
            </h3>

            <form method="POST" action="{{ route('patients.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex: Amine" 
                            class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" required />
                        @error('prenom')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Nom de famille *</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Benali" 
                            class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all" required />
                        @error('name')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" 
                            class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]" />
                        @error('date_naissance')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">N° de téléphone *</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 06 00 00 00 00" 
                            class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]" required />
                        @error('telephone')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Adresse Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="patient@exemple.com" 
                        class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]" required />
                    @error('email')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                </div>

                <div class="pt-6 border-t border-gray-50 dark:border-slate-800">
                    <h4 class="text-xs font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Sécurité du Compte</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Mot de passe *</label>
                            <input type="password" name="password" placeholder="••••••••" 
                                class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]" required />
                            @error('password')<p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2 block">Confirmation *</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" 
                                class="block w-full px-4 py-3 bg-[#F8FAFC] dark:bg-[#0f172a] dark:text-white border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3]" required />
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 px-8 py-4 bg-[#1976D2] text-white rounded-2xl font-black text-sm shadow-lg hover:bg-[#0D47A1] transition-all transform hover:-translate-y-1">
                        <i class="bi bi-check-lg mr-2"></i> Créer le compte Patient
                    </button>
                    <a href="{{ route('patients.index') }}" class="px-8 py-4 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded-2xl font-black text-sm hover:bg-gray-200 transition-all">
                        Annuler
                    </a>
                </div>
            </form>
    </div>
</x-app-layout>
