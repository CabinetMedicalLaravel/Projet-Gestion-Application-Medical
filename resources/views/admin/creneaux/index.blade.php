<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Créneaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">🗓️ Gestion des Créneaux</h1>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">← Retour</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.creneaux') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Selectionner un medecin</label>
                        <select name="medecin_id" class="form-select" onchange="this.form.submit()">
                            @foreach($medecins as $medecin)
                                <option value="{{ $medecin->id }}" {{ $medecin->id == $medecin_id ? 'selected' : '' }}>
                                    {{ $medecin->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">Ajouter un creneau</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.creneaux.store') }}" class="row g-3">
                @csrf
                <input type="hidden" name="medecin_id" value="{{ $medecin_id }}">
                <div class="col-md-3">
                    <label class="form-label">Jour</label>
                    <select name="jour_semaine" class="form-select" required>
                        <option value="1">Lundi</option>
                        <option value="2">Mardi</option>
                        <option value="3">Mercredi</option>
                        <option value="4">Jeudi</option>
                        <option value="5">Vendredi</option>
                        <option value="6">Samedi</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Heure debut</label>
                    <input type="time" name="heure_debut" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Heure fin</label>
                    <input type="time" name="heure_fin" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Duree (min)</label>
                    <select name="duree" class="form-select">
                        <option value="15">15 min</option>
                        <option value="30" selected>30 min</option>
                        <option value="45">45 min</option>
                        <option value="60">1h</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-bold">Creneaux existants</div>
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Jour</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Duree</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $jours = ['', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                @endphp
                @forelse($creneaux as $creneau)
                <tr>
                    <td>{{ $jours[$creneau->jour_semaine] }}</td>
                    <td>{{ \Carbon\Carbon::parse($creneau->heure_debut)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($creneau->heure_fin)->format('H:i') }}</td>
                    <td>{{ $creneau->duree }} min</td>
                    <td>
                        @if($creneau->est_actif)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.creneaux.toggle', $creneau) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm {{ $creneau->est_actif ? 'btn-warning' : 'btn-success' }}">
                                {{ $creneau->est_actif ? 'Desactiver' : 'Activer' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.creneaux.delete', $creneau) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ce creneau ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucun creneau pour ce medecin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</body>
</html>