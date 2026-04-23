@extends('layouts.app')

@section('title', 'Fiche patient')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;">
            <i class="bi bi-person-lines-fill" style="color:#1a7f64; margin-right:8px;"></i>Fiche patient
        </h2>
        <p style="font-size:13px; color:#7f8c8d;">Informations personnelles et détails du patient</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn-edit-cm" style="padding:8px 16px; font-size:13px;">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <a href="{{ route('patients.index') }}" class="btn-secondary-cm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 2fr; gap:20px; align-items:start;">

    {{-- Carte identité --}}
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div class="card-section" style="text-align:center; padding:28px 22px;">
            <div style="width:70px; height:70px; border-radius:50%; background:#e6f5f0; color:#1a7f64; font-size:26px; font-weight:700; display:flex; align-items:center; justify-content:center; margin:0 auto 14px;">
                {{ strtoupper(substr($patient->name, 0, 1)) }}
            </div>
            <div style="font-size:17px; font-weight:700; color:#1a2632; margin-bottom:4px;">{{ $patient->name }}</div>
            <div style="margin-bottom:14px;">
                <span class="badge-patient"><i class="bi bi-person" style="margin-right:4px;"></i>Patient</span>
            </div>
            <div style="font-size:12px; color:#7f8c8d; border-top:1px solid #f4f6f9; padding-top:14px;">
                Inscrit le {{ $patient->created_at->format('d/m/Y') }}
            </div>
        </div>

        <div class="card-section">
            <div style="font-size:13px; font-weight:700; color:#1a2632; margin-bottom:14px;">Coordonnées</div>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:flex; align-items:center; gap:10px; font-size:13px;">
                    <div style="width:30px; height:30px; background:#f4f6f9; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-envelope" style="color:#1a7f64;"></i>
                    </div>
                    <div style="overflow:hidden;">
                        <div style="font-size:10px; color:#b0bec5; text-transform:uppercase; font-weight:600;">Email</div>
                        <div style="color:#374151; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $patient->email }}</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:10px; font-size:13px;">
                    <div style="width:30px; height:30px; background:#f4f6f9; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="bi bi-telephone" style="color:#1a7f64;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#b0bec5; text-transform:uppercase; font-weight:600;">Téléphone</div>
                        <div style="color:#374151;">{{ $patient->telephone ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Infos détaillées --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="card-section">
            <div style="font-size:15px; font-weight:700; color:#1a2632; margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid #f4f6f9; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-person-vcard" style="color:#1a7f64;"></i> Informations personnelles
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Nom complet</div>
                    <div style="font-size:14px; font-weight:600; color:#1a2632;">{{ $patient->name }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Email</div>
                    <div style="font-size:14px; color:#374151;">{{ $patient->email }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Téléphone</div>
                    <div style="font-size:14px; color:#374151;">{{ $patient->telephone ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Date d'inscription</div>
                    <div style="font-size:14px; color:#374151;">{{ $patient->created_at->format('d/m/Y à H:i') }}</div>
                </div>
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Rôle</div>
                    <span class="badge-patient">Patient</span>
                </div>
                <div>
                    <div style="font-size:11px; color:#b0bec5; text-transform:uppercase; font-weight:600; margin-bottom:4px;">Statut</div>
                    <span style="background:#e6f5f0; color:#1a7f64; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;"><i class="bi bi-check-circle" style="margin-right:3px;"></i>Actif</span>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="card-section">
            <div style="font-size:14px; font-weight:700; color:#1a2632; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-lightning" style="color:#1a7f64;"></i> Actions rapides
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                <a href="{{ route('patients.edit', $patient->id) }}" style="background:#f4f6f9; border-radius:10px; padding:14px; text-align:center; text-decoration:none; color:#374151; transition:background .15s;" onmouseover="this.style.background='#e6f5f0'" onmouseout="this.style.background='#f4f6f9'">
                    <i class="bi bi-pencil" style="font-size:20px; color:#1a7f64; display:block; margin-bottom:6px;"></i>
                    <span style="font-size:12px; font-weight:600;">Modifier</span>
                </a>
                <a href="{{ route('patients.historique', $patient->id) }}" style="background:#f4f6f9; border-radius:10px; padding:14px; text-align:center; text-decoration:none; color:#374151; transition:background .15s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#f4f6f9'">
                    <i class="bi bi-clock-history" style="font-size:20px; color:#3b82f6; display:block; margin-bottom:6px;"></i>
                    <span style="font-size:12px; font-weight:600;">Historique</span>
                </a>
                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Supprimer ce patient ?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="width:100%; background:#fef2f2; border:none; border-radius:10px; padding:14px; text-align:center; cursor:pointer; color:#374151;">
                        <i class="bi bi-trash" style="font-size:20px; color:#e74c3c; display:block; margin-bottom:6px;"></i>
                        <span style="font-size:12px; font-weight:600; color:#e74c3c;">Supprimer</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
