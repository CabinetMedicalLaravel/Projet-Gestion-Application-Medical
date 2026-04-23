@extends('layouts.app')

@section('title', 'Historique médical')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;">
            <i class="bi bi-clock-history" style="color:#1a7f64; margin-right:8px;"></i>Historique médical
        </h2>
        <p style="font-size:13px; color:#7f8c8d;">Consultations passées · Ordonnances · Dossier de <strong>{{ $patient->name }}</strong></p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('patients.show', $patient->id) }}" class="btn-secondary-cm">
            <i class="bi bi-person-lines-fill"></i> Fiche patient
        </a>
        <a href="{{ route('patients.index') }}" class="btn-secondary-cm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 2fr; gap:20px; align-items:start;">

    {{-- Colonne gauche — résumé patient --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="card-section" style="text-align:center; padding:24px 20px;">
            <div style="width:60px; height:60px; border-radius:50%; background:#e6f5f0; color:#1a7f64; font-size:22px; font-weight:700; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                {{ strtoupper(substr($patient->name, 0, 1)) }}
            </div>
            <div style="font-size:16px; font-weight:700; color:#1a2632; margin-bottom:4px;">{{ $patient->name }}</div>
            <span class="badge-patient">Patient</span>
            <div style="margin-top:14px; padding-top:14px; border-top:1px solid #f4f6f9;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; text-align:center;">
                    <div style="background:#f4f6f9; border-radius:10px; padding:12px;">
                        <div style="font-size:20px; font-weight:700; color:#1a2632;">{{ count($consultations ?? []) }}</div>
                        <div style="font-size:11px; color:#7f8c8d;">Consultations</div>
                    </div>
                    <div style="background:#f4f6f9; border-radius:10px; padding:12px;">
                        <div style="font-size:20px; font-weight:700; color:#1a2632;">{{ count($ordonnances ?? []) }}</div>
                        <div style="font-size:11px; color:#7f8c8d;">Ordonnances</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtres --}}
        <div class="card-section">
            <div style="font-size:13px; font-weight:700; color:#1a2632; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                <i class="bi bi-funnel" style="color:#1a7f64;"></i> Filtrer
            </div>
            <form method="GET">
                <div style="margin-bottom:12px;">
                    <label class="form-label-cm">Type</label>
                    <select name="type" class="form-input-cm">
                        <option value="">Tous</option>
                        <option value="consultation">Consultations</option>
                        <option value="ordonnance">Ordonnances</option>
                    </select>
                </div>
                <div style="margin-bottom:12px;">
                    <label class="form-label-cm">Période</label>
                    <select name="periode" class="form-input-cm">
                        <option value="">Toutes</option>
                        <option value="3m">3 derniers mois</option>
                        <option value="6m">6 derniers mois</option>
                        <option value="1y">Cette année</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary-cm" style="width:100%; justify-content:center;">
                    <i class="bi bi-search"></i> Appliquer
                </button>
            </form>
        </div>

    </div>

    {{-- Colonne droite — Timeline --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Consultations --}}
        <div class="card-section">
            <div style="font-size:15px; font-weight:700; color:#1a2632; margin-bottom:18px; padding-bottom:12px; border-bottom:1px solid #f4f6f9; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <i class="bi bi-stethoscope" style="color:#1a7f64;"></i> Consultations passées
                </div>
                <span style="font-size:11px; background:#e6f5f0; color:#1a7f64; padding:3px 10px; border-radius:20px; font-weight:600;">{{ count($consultations ?? []) }} au total</span>
            </div>

            @forelse($consultations ?? [] as $consultation)
            <div class="timeline-item">
                <div class="timeline-dot" style="background:#e6f5f0;">
                    <i class="bi bi-stethoscope" style="color:#1a7f64; font-size:16px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px;">
                        <div style="font-weight:600; color:#1a2632; font-size:13.5px;">{{ $consultation['motif'] ?? 'Consultation générale' }}</div>
                        <span style="font-size:11px; color:#7f8c8d; white-space:nowrap;">{{ $consultation['date'] ?? 'N/A' }}</span>
                    </div>
                    <div style="font-size:12.5px; color:#5f6b7a; margin-bottom:6px;">Dr. {{ $consultation['medecin'] ?? 'Non renseigné' }}</div>
                    @if(isset($consultation['notes']))
                    <div style="font-size:12px; color:#7f8c8d; background:#f4f6f9; border-radius:6px; padding:8px 10px;">
                        {{ $consultation['notes'] }}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:36px 0; color:#b0bec5;">
                <i class="bi bi-stethoscope" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                <div style="font-size:13px;">Aucune consultation enregistrée</div>
            </div>
            @endforelse
        </div>

        {{-- Ordonnances --}}
        <div class="card-section">
            <div style="font-size:15px; font-weight:700; color:#1a2632; margin-bottom:18px; padding-bottom:12px; border-bottom:1px solid #f4f6f9; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <i class="bi bi-file-medical" style="color:#3b82f6;"></i> Ordonnances
                </div>
                <span style="font-size:11px; background:#eff6ff; color:#3b82f6; padding:3px 10px; border-radius:20px; font-weight:600;">{{ count($ordonnances ?? []) }} au total</span>
            </div>

            @forelse($ordonnances ?? [] as $ordonnance)
            <div class="timeline-item">
                <div class="timeline-dot" style="background:#eff6ff;">
                    <i class="bi bi-file-medical" style="color:#3b82f6; font-size:16px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px;">
                        <div style="font-weight:600; color:#1a2632; font-size:13.5px;">{{ $ordonnance['titre'] ?? 'Ordonnance' }}</div>
                        <span style="font-size:11px; color:#7f8c8d; white-space:nowrap;">{{ $ordonnance['date'] ?? 'N/A' }}</span>
                    </div>
                    <div style="font-size:12.5px; color:#5f6b7a; margin-bottom:6px;">Dr. {{ $ordonnance['medecin'] ?? 'Non renseigné' }}</div>
                    <a href="#" style="font-size:12px; color:#3b82f6; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                        <i class="bi bi-download"></i> Télécharger
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:36px 0; color:#b0bec5;">
                <i class="bi bi-file-medical" style="font-size:32px; display:block; margin-bottom:10px;"></i>
                <div style="font-size:13px;">Aucune ordonnance enregistrée</div>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
