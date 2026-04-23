<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="font-sans">

        {{-- Logo Icône (Bleu #1E88E5) --}}
        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 bg-[#1E88E5] rounded-2xl shadow-lg flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-black text-[#0D47A1] text-center mb-2">Bienvenue</h1>
        <p class="text-[#64748B] text-center font-medium mb-8">Connectez-vous à votre compte CabinetMédical</p>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-bold rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Champ Email --}}
            <div class="space-y-2">
                <label for="email" class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Adresse e-mail</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#1E88E5]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m2 7 10 7 10-7"/>
                        </svg>
                    </div>
                    <input id="email" name="email" type="email"
                        class="block w-full pl-11 pr-4 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all"
                        placeholder="vous@exemple.com"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username" />
                </div>
            </div>

            {{-- Champ Mot de passe --}}
            <div class="space-y-2">
                <label for="password" class="text-xs font-black text-[#0D47A1] uppercase tracking-widest ml-1">Mot de passe</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#1E88E5]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input id="password" name="password" type="password"
                        class="block w-full pl-11 pr-12 py-4 bg-[#F8FAFC] border-none rounded-2xl text-sm focus:ring-2 focus:ring-[#2196F3] transition-all"
                        placeholder="••••••••"
                        required autocomplete="current-password" />
                    
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#94A3B8] hover:text-[#1976D2]"
                        onclick="const i=document.getElementById('password');i.type=i.type==='password'?'text':'password'">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between px-1">
                <label class="flex items-center text-sm font-bold text-[#64748B] cursor-pointer">
                    <input type="checkbox" name="remember" id="remember_me" class="rounded border-[#BBDEFB] text-[#1976D2] focus:ring-[#1976D2] mr-2">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#1976D2] hover:text-[#0D47A1] transition">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            {{-- Bouton Se connecter (Bleu Marine #0D47A1 vers #1976D2) --}}
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#0D47A1] to-[#1976D2] text-white font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-blue-200 hover:shadow-xl transform transition active:scale-95">
                Se connecter
            </button>

            {{-- Séparateur --}}
            <div class="relative py-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-[#E2E8F0]"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-4 font-bold text-[#94A3B8]">ou</span></div>
            </div>

            {{-- Bouton créer un compte (Contour Bleu #1565C0) --}}
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="block w-full text-center py-4 bg-white border-2 border-[#1565C0] text-[#1565C0] font-black uppercase tracking-widest rounded-2xl hover:bg-[#F1F8FE] transition">
                    Créer un compte patient
                </a>
            @endif

        </form>

        <p class="mt-8 text-center text-[#94A3B8] text-sm font-medium">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-[#1976D2] font-black hover:underline ml-1">S'inscrire gratuitement</a>
        </p>
    </div>
</x-guest-layout>