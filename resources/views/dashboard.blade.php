@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span>Patients</span>
            <div class="stat-icon" style="background: #e8eaf6; color: #5c6bc0;">
                <i class="bi bi-people"></i>
            </div>
        </div>
        <div class="stat-number">{{ $stats['total_patients'] }}</div>
        <small style="color: #7f8c8d;">Total inscrits</small>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Médecins</span>
            <div class="stat-icon" style="background: #e8f5e9; color: #4caf50;">
                <i class="bi bi-person-badge"></i>
            </div>
        </div>
        <div class="stat-number">{{ $stats['total_medecins'] }}</div>
        <small style="color: #7f8c8d;">Médecins actifs</small>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Secrétaires</span>
            <div class="stat-icon" style="background: #e3f2fd; color: #2196f3;">
                <i class="bi bi-person-check"></i>
            </div>
        </div>
        <div class="stat-number">{{ $stats['total_secretaires'] }}</div>
        <small style="color: #7f8c8d;">Personnel admin</small>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Consultations</span>
            <div class="stat-icon" style="background: #fff3e0; color: #ff9800;">
                <i class="bi bi-file-text"></i>
            </div>
        </div>
        <div class="stat-number">{{ $stats['consultations_mois'] }}</div>
        <small style="color: #7f8c8d;">Ce mois</small>
    </div>
</div>

<!-- Graphiques -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
    <div class="stat-card">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">
            <i class="bi bi-calendar-week" style="color: #7F77DD;"></i> Rendez-vous par mois
        </h3>
        <canvas id="rdvChart" style="max-height: 250px;"></canvas>
    </div>
    
    <div class="stat-card">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">
            <i class="bi bi-pie-chart" style="color: #7F77DD;"></i> Statut des rendez-vous
        </h3>
        <canvas id="statusChart" style="max-height: 250px;"></canvas>
    </div>
</div>

<!-- Rendez-vous du jour -->
<div class="stat-card" style="margin-bottom: 25px;">
    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">
        <i class="bi bi-calendar-today" style="color: #7F77DD;"></i> Rendez-vous aujourd'hui
        <span style="float: right; font-size: 12px; color: #7f8c8d;">{{ $todayRdv->count() }} RDV</span>
    </h3>
    
    @if($todayRdv->count() > 0)
        <div class="table-container">
            <table style="width: 100%;">
                <thead>
                    <tr><th>Heure</th><th>Patient</th><th>Médecin</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($todayRdv as $rdv)
                    <tr>
                        <td style="font-weight: 500;">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</td>
                        <td>{{ $rdv->patient->prenom ?? 'N/A' }} {{ $rdv->patient->nom ?? '' }}</td>
                        <td>Dr. {{ $rdv->medecin->user->name ?? 'N/A' }}</td>
                        <td>
                            <span style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500;
                                @if($rdv->statut == 'confirmé') background: #d4edda; color: #155724;
                                @elseif($rdv->statut == 'en attente') background: #fff3cd; color: #856404;
                                @elseif($rdv->statut == 'terminé') background: #cce5ff; color: #004085;
                                @else background: #f8d7da; color: #721c24; @endif">
                                {{ $rdv->statut }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-btn" title="Voir"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="text-align: center; color: #7f8c8d; padding: 40px;">
            <i class="bi bi-calendar-check" style="font-size: 48px;"></i><br>
            Aucun rendez-vous aujourd'hui
        </p>
    @endif
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des rendez-vous par mois
    const ctx1 = document.getElementById('rdvChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($moisLabels) !!},
            datasets: [{
                label: 'Rendez-vous',
                data: {!! json_encode($rdvData) !!},
                borderColor: '#7F77DD',
                backgroundColor: 'rgba(127, 119, 221, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'top' } }
        }
    });
    
    // Graphique des statuts
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statutLabels) !!},
            datasets: [{
                data: {!! json_encode($statutData) !!},
                backgroundColor: ['#4caf50', '#ff9800', '#f44336', '#2196f3', '#9c27b0']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
