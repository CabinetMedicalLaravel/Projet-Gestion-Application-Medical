<x-guest-layout>

    {{-- Logo --}}
    <div class="login-logo">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
        </svg>
    </div>

    <h1 class="login-heading">Créer un compte</h1>
    <p class="login-sub">Choisissez votre profil pour commencer</p>

    {{-- Sélection du rôle --}}
    <div class="role-grid">
        <div class="role-card active" id="role-patient" onclick="selectRole('patient')">
            <div class="role-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div class="role-name">Patient</div>
            <div class="role-desc">Accès à vos rendez-vous</div>
        </div>
        <div class="role-card" id="role-staff" onclick="selectRole('staff')">
            <div class="role-icon">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </div>
            <div class="role-name">Médecin / Secrétaire</div>
            <div class="role-desc">Accès personnel médical</div>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="role" id="role-input" value="patient" />

        {{-- Code d'accès (visible seulement pour le personnel) --}}
        <div class="code-box" id="code-box">
            <label class="lbl">Code d'accès</label>
            <p class="code-hint">Réservé au personnel de la clinique. Contactez l'administrateur si vous ne l'avez pas.
            </p>
            <div class="login-inp-wrap">
                <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input type="password" id="access_code" name="access_code" class="login-input"
                    placeholder="Ex: MEDECIN2026" autocomplete="off" />
            </div>
            @error('access_code')
                <span class="login-err">{{ $message }}</span>
            @enderror
        </div>

        {{-- Nom --}}
        <div class="login-field">
            <label for="name" class="login-label">Nom complet</label>
            <div class="login-inp-wrap">
                <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input id="name" name="name" type="text" class="login-input" placeholder="Jean Mark"
                    value="{{ old('name') }}" required autofocus />
            </div>
            @error('name')
                <span class="login-err">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="login-field">
            <label for="email" class="login-label">Adresse e-mail</label>
            <div class="login-inp-wrap">
                <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="m2 7 10 7 10-7" />
                </svg>
                <input id="email" name="email" type="email" class="login-input" placeholder="vous@exemple.com"
                    value="{{ old('email') }}" required />
            </div>
            @error('email')
                <span class="login-err">{{ $message }}</span>
            @enderror
        </div>

        {{-- Téléphone (visible uniquement pour les patients) --}}
        <div class="login-field" id="phone-field">
            <label for="telephone" class="login-label">Numéro de téléphone</label>
            <div class="login-inp-wrap">
                <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                {{-- Indicatif pays --}}
                <select name="indicatif" id="indicatif" class="login-input-select">
                    <option value="+212" {{ old('indicatif', '+212') === '+212' ? 'selected' : '' }}>🇲🇦 +212</option>
                    <option value="+33" {{ old('indicatif') === '+33' ? 'selected' : '' }}>🇫🇷 +33</option>
                    <option value="+32" {{ old('indicatif') === '+32' ? 'selected' : '' }}>🇧🇪 +32</option>
                    <option value="+41" {{ old('indicatif') === '+41' ? 'selected' : '' }}>🇨🇭 +41</option>
                    <option value="+1" {{ old('indicatif') === '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                </select>
                <input id="telephone" name="telephone" type="tel" class="login-input-phone" placeholder="06 12 34 56 78"
                    value="{{ old('telephone') }}" />
            </div>
            @error('telephone')
                <span class="login-err">{{ $message }}</span>
            @enderror
        </div>

        {{-- Mots de passe côte à côte --}}
        <div class="reg-cols">
            <div class="login-field" style="margin-bottom:0">
                <label for="password" class="login-label">Mot de passe</label>
                <div class="login-inp-wrap">
                    <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input id="password" name="password" type="password" class="login-input" placeholder="••••••••"
                        required />
                    <button type="button" class="login-eye" onclick="togglePw('password')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="login-err">{{ $message }}</span>
                @enderror
            </div>

            <div class="login-field" style="margin-bottom:0">
                <label for="password_confirmation" class="login-label">Confirmer</label>
                <div class="login-inp-wrap">
                    <svg class="login-ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="login-input"
                        placeholder="••••••••" required />
                    <button type="button" class="login-eye" onclick="togglePw('password_confirmation')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <button type="submit" class="login-btn" style="margin-top:1.25rem">S'inscrire</button>

        <p class="login-signup-link" style="margin-top:1rem">
            Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>

    <script>
        function selectRole(r) {
            document.getElementById('role-patient').classList.toggle('active', r === 'patient');
            document.getElementById('role-staff').classList.toggle('active', r === 'staff');
            document.getElementById('code-box').classList.toggle('visible', r === 'staff');
            document.getElementById('phone-field').style.display = r === 'patient' ? 'block' : 'none';
            document.getElementById('role-input').value = r;
            document.getElementById('access_code').required = r === 'staff';
            document.getElementById('telephone').required = r === 'patient';
        }

        function togglePw(id) {
            const i = document.getElementById(id);
            i.type = i.type === 'password' ? 'text' : 'password';
        }

        // Init au chargement
        document.getElementById('telephone').required = true;
    </script>

</x-guest-layout>