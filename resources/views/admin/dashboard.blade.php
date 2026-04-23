@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="d-flex justify-content-between align-items-center mb-4 px-2">
    <div>
        <h2 style="font-size:24px; font-weight:800; color:#0D47A1; letter-spacing:-0.5px;">Tableau de bord Admin</h2>
        <p style="font-size:13px; color:#64748B; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Statistiques globales de la clinique</p>
    </div>
</div>

<!-- GRILLE DES STATISTIQUES (8 BLOCS) -->
<div class="row g-3 mb-4">
    {{-- Total Utilisateurs --}}
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #0D47A1;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Total Utilisateurs</div>
            <div class="stat-number" style="color:#0D47A1;">{{ $stats['users'] ?? 0 }}</div>
        </div>
    </div>
    {{-- Médecins --}}
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #1976D2;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Médecins</div>
            <div class="stat-number" style="color:#1976D2;">{{ $stats['medecins'] ?? 0 }}</div>
        </div>
    </div>
    {{-- Patients --}}
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #2196F3;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Patients</div>
            <div class="stat-number" style="color:#2196F3;">{{ $stats['patients'] ?? 0 }}</div>
        </div>
    </div>
    {{-- Secrétaires --}}
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #1565C0;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Secrétaires</div>
            <div class="stat-number" style="color:#1565C0;">{{ $stats['secretaires'] ?? 0 }}</div>
        </div>
    </div>
    
    {{-- Ligne 2 --}}
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #0D47A1;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Total RDV</div>
            <div class="stat-number">{{ $stats['rdv_total'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #F59E0B;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">RDV En attente</div>
            <div class="stat-number" style="color:#F59E0B;">{{ $stats['rdv_attente'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #8B5CF6;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Consultations</div>
            <div class="stat-number" style="color:#8B5CF6;">{{ $stats['consultations'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="border-left: 4px solid #10B981;">
            <div style="font-size:10px;font-weight:800;color:#94A3B8;text-transform:uppercase; letter-spacing:1px;">Ordonnances</div>
            <div class="stat-number" style="color:#10B981;">{{ $stats['ordonnances'] ?? 0 }}</div>
        </div>
    </div>
</div>

<!-- GRAPHIQUES -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card-section" style="border-radius: 24px; padding: 30px;">
            <div style="font-size:16px; font-weight:800; color:#0D47A1; margin-bottom:20px;">Evolution des Rendez-vous</div>
            <canvas id="chartRdvMois" height="120"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-section" style="border-radius: 24px; padding: 30px;">
            <div style="font-size:16px; font-weight:800; color:#0D47A1; margin-bottom:20px;">Statuts des RDV</div>
            <canvas id="chartStatuts"></canvas>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-section" style="border-radius: 24px; padding: 30px;">
            <div style="font-size:16px; font-weight:800; color:#0D47A1; margin-bottom:20px;">Activité par médecin</div>
            <canvas id="chartMedecins" height="150"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card-section" style="border-radius: 24px; padding: 30px;">
            <div style="font-size:16px; font-weight:800; color:#0D47A1; margin-bottom:20px;">Répartition des Utilisateurs</div>
            <canvas id="chartUsers" height="150"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Sécurité pour les données JSON (évite les erreurs si vide)
const rdvParMois = @json($rdvParMois ?? []);
const rdvParMedecin = @json($rdvParMedecin ?? []);
const moisNoms = ['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'];

// 1. Graphique d'évolution (Bleu Royal)
new Chart(document.getElementById('chartRdvMois'), {
    type: 'line',
    data: {
        labels: rdvParMois.length ? rdvParMois.map(r => moisNoms[r.mois - 1] + ' ' + r.annee) : ['Aucune donnée'],
        datasets: [{
            label: 'Rendez-vous',
            data: rdvParMois.length ? rdvParMois.map(r => r.total) : [0],
            borderColor: '#1976D2',
            backgroundColor: 'rgba(25, 118, 210, 0.05)',
            fill: true,
            tension: 0.4,
            borderWidth: 3
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// 2. Graphique Statuts (Doughnut)
new Chart(document.getElementById('chartStatuts'), {
    type: 'doughnut',
    data: {
        labels: ['En attente', 'Confirmé', 'Annulé'],
        datasets: [{
            data: [
                {{ $stats['rdv_attente'] ?? 0 }}, 
                {{ $stats['rdv_confirme'] ?? 0 }}, 
                {{ $stats['rdv_annule'] ?? 0 }}
            ],
            backgroundColor: ['#F59E0B', '#10B981', '#EF4444'],
            borderWidth: 0
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});

// 3. Barres Médecins (Bleu Marine)
new Chart(document.getElementById('chartMedecins'), {
    type: 'bar',
    data: {
        labels: rdvParMedecin.length ? rdvParMedecin.map(m => m.name) : ['Aucun'],
        datasets: [{
            label: 'RDV',
            data: rdvParMedecin.length ? rdvParMedecin.map(m => m.total) : [0],
            backgroundColor: '#0D47A1',
            borderRadius: 8
        }]
    },
    options: { plugins: { legend: { display: false } } }
});

// 4. Répartition Utilisateurs (Pie)
new Chart(document.getElementById('chartUsers'), {
    type: 'pie',
    data: {
        labels: ['Médecins', 'Patients', 'Secrétaires'],
        datasets: [{
            data: [
                {{ $stats['medecins'] ?? 0 }}, 
                {{ $stats['patients'] ?? 0 }}, 
                {{ $stats['secretaires'] ?? 0 }}
            ],
            backgroundColor: ['#1976D2', '#2196F3', '#1565C0']
        }]
    }
});
</script>
@endsection