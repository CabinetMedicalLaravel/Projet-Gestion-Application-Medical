<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div style="font-family:'DM Sans',sans-serif;">

        {{-- Logo --}}
        <div class="login-logo">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>

        <h1 class="login-heading">Bienvenue</h1>
        <p class="login-sub">Connectez-vous à votre compte pour continuer</p>

        @if ($errors->any())
            <div class="login-alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="login-field">
                <label for="email" class="login-label">Adresse e-mail</label>
                <div class="login-inp-wrap">
                    <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="m2 7 10 7 10-7"/>
                    </svg>
                    <input id="email" name="email" type="email"
                        class="login-input"
                        placeholder="vous@exemple.com"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username" />
                </div>
                @error('email')<span class="login-err">{{ $message }}</span>@enderror
            </div>

            {{-- Password --}}
            <div class="login-field">
                <label for="password" class="login-label">Mot de passe</label>
                <div class="login-inp-wrap">
                    <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input id="password" name="password" type="password"
                        class="login-input"
                        placeholder="••••••••"
                        required autocomplete="current-password" />
                    <button type="button" class="login-eye"
                        onclick="const i=document.getElementById('password');i.type=i.type==='password'?'text':'password'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')<span class="login-err">{{ $message }}</span>@enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="login-row">
                <label class="login-chk">
                    <input type="checkbox" name="remember" id="remember_me">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="login-fgt">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button type="submit" class="login-btn">Se connecter</button>

        {{-- Séparateur --}}
        <div class="login-divider"><span>ou</span></div>

        {{-- Bouton créer un compte --}}
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="login-btn-register">
                Créer un compte
            </a>
        @endif

        {{-- Lien discret en bas --}}
        <p class="login-signup-link">
            Pas encore de compte ?
            <a href="{{ route('register') }}">S'inscrire gratuitement</a>
        </p>
        </form>
    </div>
</x-guest-layout>