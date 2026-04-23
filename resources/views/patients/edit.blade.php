@extends('layouts.app')

@section('title', 'Modifier le patient')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;">
            <i class="bi bi-pencil" style="color:#1a7f64; margin-right:8px;"></i>Modifier le patient
        </h2>
        <p style="font-size:13px; color:#7f8c8d;">Formulaire complet · {{ $patient->name }}</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('patients.show', $patient->id) }}" class="btn-secondary-cm">
            <i class="bi bi-arrow-left"></i> Retour à la fiche
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; align-items:start;">
    <div class="card-section">
        <div style="font-size:15px; font-weight:700; color:#1a2632; margin-bottom:22px; padding-bottom:14px; border-bottom:1px solid #f4f6f9; display:flex; align-items:center; gap:8px;">
            <i class="bi bi-person-vcard" style="color:#1a7f64;"></i> Informations personnelles
        </div>

        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label class="form-label-cm">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', explode(' ', $patient->name)[0] ?? '') }}" class="form-input-cm" required>
                </div>
                <div>
                    <label class="form-label-cm">Nom *</label>
                    <input type="text" name="name" value="{{ old('name', $patient->name) }}" class="form-input-cm" required>
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-label-cm">Téléphone *</label>
                <input type="text" name="telephone" value="{{ old('telephone', $patient->telephone) }}" class="form-input-cm" required>
            </div>

            <div style="font-size:14px; font-weight:700; color:#1a2632; margin:22px 0 16px; padding-top:14px; border-top:1px solid #f4f6f9; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-lock" style="color:#1a7f64;"></i> Accès au compte
            </div>

            <div style="margin-bottom:16px;">
                <label class="form-label-cm">Adresse email *</label>
                <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="form-input-cm" required>
                @error('email')<span style="color:#e74c3c; font-size:11px;">{{ $message }}</span>@enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:8px;">
                <div>
                    <label class="form-label-cm">Nouveau mot de passe</label>
                    <input type="password" name="password" placeholder="Laisser vide pour ne pas changer" class="form-input-cm">
                </div>
                <div>
                    <label class="form-label-cm">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="Répéter..." class="form-input-cm">
                </div>
            </div>
            <p style="font-size:11px; color:#b0bec5; margin-bottom:24px;">Laissez les champs vides pour conserver le mot de passe actuel.</p>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-primary-cm" style="flex:1; justify-content:center; padding:11px;">
                    <i class="bi bi-check-lg"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('patients.show', $patient->id) }}" class="btn-secondary-cm" style="padding:11px 20px;">Annuler</a>
            </div>
        </form>
    </div>

    <div class="card-section" style="text-align:center; padding:28px 22px;">
        <div style="width:60px; height:60px; border-radius:50%; background:#e6f5f0; color:#1a7f64; font-size:22px; font-weight:700; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            {{ strtoupper(substr($patient->name, 0, 1)) }}
        </div>
        <div style="font-size:16px; font-weight:700; color:#1a2632; margin-bottom:4px;">{{ $patient->name }}</div>
        <span class="badge-patient">Patient</span>
        <div style="margin-top:14px; padding-top:14px; border-top:1px solid #f4f6f9; font-size:12px; color:#7f8c8d;">
            Inscrit le {{ $patient->created_at->format('d/m/Y') }}
        </div>
        <div style="margin-top:16px;">
            <a href="{{ route('patients.historique', $patient->id) }}" class="btn-secondary-cm" style="width:100%; justify-content:center; margin-bottom:8px;">
                <i class="bi bi-clock-history"></i> Historique médical
            </a>
        </div>
    </div>
</div>

@endsection
