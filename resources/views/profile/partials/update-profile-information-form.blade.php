
<style>
.dark input, .dark textarea, .dark select {
    background: #141e2e !important;
    border-color: #233044 !important;
    color: #e2e8f0 !important;
}
.dark label { color: #7a8fa6 !important; }
.dark p.text-sm { color: #7a8fa6 !important; }
.dark h2 { color: #e8eef8 !important; }
</style>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center gap-2">
            <span class="p-1 bg-indigo-100 rounded text-indigo-600">👤</span>
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de votre compte, votre photo de profil et vos coordonnées.") }}
        </p>

        <!-- Affichage du Rôle (Badge) -->
        <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 uppercase tracking-wider">
                 {{ __($user->role) }}
            </span>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Champ Photo de Profil -->
        <div>
            <x-input-label for="profile_photo" :value="__('Photo de profil')" />
            
            <div class="flex items-center gap-4 mt-2">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500 shadow-sm">
                @else
                    <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center border-2 border-gray-300">
                        <svg class="h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif

                <input id="profile_photo" name="profile_photo" type="file" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100 transition-colors" 
                />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Champ Nom -->
            <div>
                <x-input-label for="name" :value="__('Nom complet')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Champ Téléphone -->
            <div>
                <x-input-label for="telephone" :value="__('Numéro de téléphone')" />
                <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone', $user->telephone)" placeholder="+212..." />
                <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
            </div>
        </div>

        @if($user->role === 'medecin')
            <!-- Champ Spécialité (Visible uniquement pour les médecins) -->
            <div>
                <x-input-label for="specialite" :value="__('Spécialité médicale')" />
                <x-text-input id="specialite" name="specialite" type="text" class="mt-1 block w-full bg-gray-50" :value="old('specialite', $user->specialite)" />
                <p class="mt-1 text-xs text-gray-500 italic">Ce champ est réservé aux comptes médecins.</p>
                <x-input-error class="mt-2" :messages="$errors->get('specialite')" />
            </div>
        @endif

        <!-- Champ Email -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Bouton Sauvegarder -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer les modifications') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 font-medium"
                >✅ {{ __('Modifications enregistrées.') }}</p>
            @endif
        </div>
    </form>
</section>