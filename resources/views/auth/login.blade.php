<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div style="font-family:'DM Sans',sans-serif;">
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
            <div class="login-field">
                <label for="email" class="login-label">Adresse e-mail</label>
                <div class="login-inp-wrap">
                    <input id="email" name="email" type="email" class="login-input" placeholder="vous@exemple.com" value="{{ old('email') }}" required autofocus autocomplete="username" />
                </div>
                @error('email')<span class="login-err">{{ $message }}</span>@enderror
            </div>
            <div class="login-field">
                <label for="password" class="login-label">Mot de passe</label>
                <div class="login-inp-wrap">
                    <input id="password" name="password" type="password" class="login-input" placeholder="••••••••" required autocomplete="current-password" />
                </div>
                @error('password')<span class="login-err">{{ $message }}</span>@enderror
            </div>
            <div class="login-row">
                <label class="login-chk">
                    <input type="checkbox" name="remember" id="remember_me">
                    Se souvenir de moi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="login-fgt">Mot de passe oublié ?</a>
                @endif
            </div>
            <button type="submit" class="login-btn">Se connecter</button>
        </form>
    </div>
</x-guest-layout>
