@extends('layouts.app')

@section('title', 'Créer / Modifier patient')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;">
            <i class="bi bi-person-plus" style="color:#1a7f64; margin-right:8px;"></i>Créer un patient
        </h2>
        <p style="font-size:13px; color:#7f8c8d;">Formulaire complet · Secrétaire</p>
    </div>
    <a href="{{ route('patients.index') }}" class="btn-secondary-cm">
        <i class="bi bi-arrow-left"></i> Retour à la liste
    </a>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; align-items:start;">

    {{-- FORMULAIRE PRINCIPAL --}}
    <div class="card-section">
        <div style="font-size:15px; font-weight:700; color:#1a2632; margin-bottom:22px; padding-bottom:14px; border-bottom:1px solid #f4f6f9; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-person-vcard" style="color:#1a7f64;"></i> Informations personnelles
        </div>

        <form method="POST" action="{{ route('patients.store') }}">
            @csrf

            {{-- Identité --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label-cm">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Ex: Amine" class="form-input-cm" required>
                    @error('prenom')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="form-label-cm">Nom *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Benali" class="form-input-cm" required>
                    @error('name')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label-cm">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="form-input-cm">
                    @error('date_naissance')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="form-label-cm">Téléphone *</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 06 12 34 56 78" class="form-input-cm" required>
                    @error('telephone')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-label-cm">Adresse complète</label>
                <textarea name="adresse" placeholder="Rue, ville, code postal..." class="form-input-cm" rows="2">{{ old('adresse') }}</textarea>
            </div>

            {{-- Compte --}}
            <div style="font-size:14px; font-weight:700; color:#1a2632; margin:22px 0 16px; padding-top:14px; border-top:1px solid #f4f6f9; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-lock" style="color:#1a7f64;"></i> Accès au compte
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-label-cm">Adresse email *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="patient@email.com" class="form-input-cm" required>
                @error('email')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <label class="form-label-cm">Mot de passe *</label>
                    <input type="password" name="password" placeholder="Min. 6 caractères" class="form-input-cm" required>
                    @error('password')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="form-label-cm">Confirmer le mot de passe *</label>
                    <input type="password" name="password_confirmation" placeholder="Répéter le mot de passe" class="form-input-cm" required>
                </div>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-primary-cm" style="flex:1; justify-content:center; padding:11px;">
                    <i class="bi bi-check-lg"></i> Enregistrer le patient
                </button>
                <a href="{{ route('patients.index') }}" class="btn-secondary-cm" style="padding:11px 20px;">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    {{-- COLONNE DROITE --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Aide --}}
        <div class="card-section">
            <div style="font-size:14px; font-weight:700; color:#1a2632; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-info-circle" style="color:#1a7f64;"></i> Informations
            </div>
            <ul style="font-size:12.5px; color:#5f6b7a; line-height:1.8; padding-left:16px;">
                <li>Les champs marqués <strong>*</strong> sont obligatoires</li>
                <li>L'email sera utilisé pour la connexion</li>
                <li>Le patient pourra modifier son mot de passe</li>
                <li>Le rôle <em>patient</em> est attribué automatiquement</li>
            </ul>
        </div>

        {{-- Sprint info --}}
        

    </div>
</div>

@endsection
