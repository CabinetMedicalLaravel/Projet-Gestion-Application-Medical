@extends('layouts.app')

@section('title', 'Liste des patients')

@section('content')

{{-- En-tête --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div>
        <h2 style="font-size:20px; font-weight:700; color:#1a2632; margin-bottom:4px;">
            <i class="bi bi-people" style="color:#1a7f64; margin-right:8px;"></i>Liste des patients
        </h2>
        <p style="font-size:13px; color:#7f8c8d;">Tableau de bord · Gestion des patients</p>
    </div>
    <a href="{{ route('patients.create') }}" class="btn-primary-cm">
        <i class="bi bi-person-plus"></i> Nouveau patient
    </a>
</div>

{{-- Barre recherche + filtres --}}
<div class="card-section" style="margin-bottom:20px;">
    <form method="GET" action="{{ route('patients.index') }}">
        <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div style="flex:1; min-width:200px; position:relative;">
                <label class="form-label-cm">Rechercher</label>
                <div style="position:relative;">
                    <i class="bi bi-search" style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#b0bec5; font-size:14px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..." class="form-input-cm" style="padding-left:34px;">
                </div>
            </div>
            <div style="min-width:160px;">
                <label class="form-label-cm">Trier par</label>
                <select name="sort" class="form-input-cm">
                    <option value="recent" {{ request('sort','recent')=='recent' ? 'selected' : '' }}>Plus récent</option>
                    <option value="nom" {{ request('sort')=='nom' ? 'selected' : '' }}>Nom (A-Z)</option>
                    <option value="ancien" {{ request('sort')=='ancien' ? 'selected' : '' }}>Plus ancien</option>
                </select>
            </div>
            <div style="display:flex; gap:8px; padding-bottom:0;">
                <button type="submit" class="btn-primary-cm"><i class="bi bi-funnel"></i> Filtrer</button>
                <a href="{{ route('patients.index') }}" class="btn-secondary-cm"><i class="bi bi-x"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

{{-- Tableau --}}
<div class="card-section">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
        <p style="font-size:13px; color:#7f8c8d; margin:0;">
            <strong style="color:#1a2632;">{{ $patients->total() }}</strong> patient(s) trouvé(s)
        </p>
        <span style="font-size:12px; color:#b0bec5;">Page {{ $patients->currentPage() }} / {{ $patients->lastPage() }}</span>
    </div>

    <table class="cm-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Inscrit le</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div class="patient-avatar">{{ strtoupper(substr($patient->name, 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:600; color:#1a2632; font-size:13.5px;">{{ $patient->name }}</div>
                            <div style="font-size:11px; color:#7f8c8d;">ID #{{ $patient->id }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#5f6b7a;">{{ $patient->email }}</td>
                <td style="color:#5f6b7a;">{{ $patient->telephone ?? '—' }}</td>
                <td style="color:#5f6b7a; font-size:12.5px;">{{ $patient->created_at->format('d/m/Y') }}</td>
                <td><span class="badge-patient"><i class="bi bi-check-circle" style="margin-right:4px;"></i>Actif</span></td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn-edit-cm">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn-edit-cm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Supprimer ce patient ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-cm"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:50px 20px; color:#7f8c8d;">
                    <i class="bi bi-people" style="font-size:32px; display:block; margin-bottom:10px; color:#e8ecf0;"></i>
                    Aucun patient trouvé
                    <div style="margin-top:12px;">
                        <a href="{{ route('patients.create') }}" class="btn-primary-cm">Ajouter le premier patient</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:18px;">
        {{ $patients->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
