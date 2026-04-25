<x-guest-layout>
    <div class="font-sans text-center">
        {{-- Icône Mail --}}
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-[#E3F2FD] dark:bg-blue-900/30 rounded-3xl shadow-sm flex items-center justify-center animate-bounce">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-black text-[#0D47A1] dark:text-blue-400 mb-4">Vérifiez votre email</h1>
        
        <p class="text-[#64748B] dark:text-slate-400 text-sm leading-relaxed mb-8">
            {{ __('Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ? Si vous ne l\'avez pas reçu, nous vous en enverrons un autre avec plaisir.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl text-emerald-700 dark:text-emerald-400 text-xs font-bold">
                {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse e-mail fournie lors de l\'inscription.') }}
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-[#1976D2] hover:bg-[#0D47A1] text-white font-black uppercase tracking-widest rounded-2xl shadow-lg transition-all active:scale-95">
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit" class="text-[#64748B] dark:text-slate-500 text-xs font-bold hover:text-[#0D47A1] underline decoration-dotted transition-colors">
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
