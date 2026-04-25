<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Administration — Tableau de Bord') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="mb-8">
        <h2 class="text-2xl font-black text-[#0D47A1] dark:text-blue-400 tracking-tight">Tableau de bord Admin</h2>
        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest mt-1">Vue d'ensemble de la clinique</p>
    </div>

    <!-- GRILLE DES STATISTIQUES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Utilisateurs --}}
        <a href="{{ route('admin.users') }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Utilisateurs</p>
                <p class="text-3xl font-black text-[#0D47A1] dark:text-blue-400">{{ $stats['users'] ?? 0 }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="bi bi-people text-7xl text-[#0D47A1]"></i>
            </div>
        </a>

        {{-- Médecins --}}
        <a href="{{ route('admin.users', ['role' => 'medecin']) }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Médecins</p>
                <p class="text-3xl font-black text-[#1976D2] dark:text-blue-500">{{ $stats['medecins'] ?? 0 }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="bi bi-person-badge text-7xl text-[#1976D2]"></i>
            </div>
        </a>

        {{-- Patients --}}
        <a href="{{ route('admin.users', ['role' => 'patient']) }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Patients</p>
                <p class="text-3xl font-black text-[#2196F3] dark:text-blue-400">{{ $stats['patients'] ?? 0 }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="bi bi-person-heart text-7xl text-[#2196F3]"></i>
            </div>
        </a>

        {{-- Secrétaires --}}
        <a href="{{ route('admin.users', ['role' => 'secretaire']) }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Secrétaires</p>
                <p class="text-3xl font-black text-[#1565C0] dark:text-blue-600">{{ $stats['secretaires'] ?? 0 }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="bi bi-headset text-7xl text-[#1565C0]"></i>
            </div>
        </a>
    </div>

    <!-- DEUXIEME LIGNE STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('rdv.planning') }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-all">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total RDV</p>
            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['rdv_total'] ?? 0 }}</p>
        </a>
        <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">RDV En attente</p>
            <p class="text-2xl font-black text-amber-500">{{ $stats['rdv_attente'] ?? 0 }}</p>
        </div>
        <a href="{{ route('consultations.index') }}" class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-all">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Consultations</p>
            <p class="text-2xl font-black text-emerald-500">{{ $stats['consultations'] ?? 0 }}</p>
        </a>
        <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Ordonnances</p>
            <p class="text-2xl font-black text-blue-500">{{ $stats['ordonnances'] ?? 0 }}</p>
        </div>
    </div>

    <!-- GRAPHIQUES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
            <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Évolution des Rendez-vous</h3>
            <canvas id="chartRdvMois" height="150"></canvas>
        </div>
        <div class="lg:col-span-1 bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
            <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Statuts des RDV</h3>
            <canvas id="chartStatuts"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
            <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Activité par médecin</h3>
            <canvas id="chartMedecins" height="150"></canvas>
        </div>
        <div class="bg-white dark:bg-[#1e293b] rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700">
            <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Répartition des Utilisateurs</h3>
            <div class="flex justify-center">
                <div class="w-64">
                    <canvas id="chartUsers"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- RACCOURCIS & GESTION -->
    <div class="mt-8">
        <h3 class="text-sm font-black text-[#0D47A1] dark:text-blue-400 uppercase tracking-widest mb-6">Gestion & Paramètres</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.creneaux') }}" class="flex items-center p-6 bg-white dark:bg-[#1e293b] rounded-3xl border border-gray-100 dark:border-slate-700 hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-2xl text-[#1976D2] mr-4 group-hover:bg-[#1976D2] group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="font-black text-[#0D47A1] dark:text-blue-400">Gestion des Créneaux</div>
            </a>
            
            <a href="{{ route('admin.users') }}" class="flex items-center p-6 bg-white dark:bg-[#1e293b] rounded-3xl border border-gray-100 dark:border-slate-700 hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 mr-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="font-black text-emerald-700 dark:text-emerald-400">Gestion Utilisateurs</div>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rdvParMois = @json($rdvParMois ?? []);
            const rdvParMedecin = @json($rdvParMedecin ?? []);
            const moisNoms = ['Jan','Fev','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Dec'];

            // 1. Graphique d'évolution
            new Chart(document.getElementById('chartRdvMois'), {
                type: 'line',
                data: {
                    labels: rdvParMois.length ? rdvParMois.map(r => moisNoms[r.mois - 1] + ' ' + r.annee) : ['Aucune donnée'],
                    datasets: [{
                        label: 'Rendez-vous',
                        data: rdvParMois.length ? rdvParMois.map(r => r.total) : [0],
                        borderColor: '#1976D2',
                        backgroundColor: 'rgba(25, 118, 210, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#1976D2',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: { 
                    plugins: { legend: { display: false } },
                    scales: { 
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. Graphique Statuts
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
                        backgroundColor: ['#3B82F6', '#10B981', '#F43F5E'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: { 
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold', size: 10 } } } } 
                }
            });

            // 3. Barres Médecins
            new Chart(document.getElementById('chartMedecins'), {
                type: 'bar',
                data: {
                    labels: rdvParMedecin.length ? rdvParMedecin.map(m => m.name) : ['Aucun'],
                    datasets: [{
                        label: 'RDV',
                        data: rdvParMedecin.length ? rdvParMedecin.map(m => m.total) : [0],
                        backgroundColor: '#0D47A1',
                        borderRadius: 12,
                        barThickness: 25
                    }]
                },
                options: { 
                    plugins: { legend: { display: false } },
                    scales: { 
                        y: { grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 4. Répartition Utilisateurs
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
                        backgroundColor: ['#1976D2', '#2196F3', '#1565C0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'bold', size: 10 } } } }
                }
            });
        });
    </script>
</x-app-layout>