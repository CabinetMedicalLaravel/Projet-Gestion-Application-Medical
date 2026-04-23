<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root {
    --bg-page: #F4F8FB; --bg-card: #fff; --border: #e5e7eb;
    --text: #111827; --sub: #6b7280;
    --accent: #1976D2; --accent-dark: #0D47A1;
}
.dark { --bg-page:#0f172a; --bg-card:#1a2332; --border:#233044; --text:#e8eef8; --sub:#7a8fa6; }

.dash-page  { background:var(--bg-page); min-height:calc(100vh - 64px); padding:2.5rem 1.5rem; font-family:'DM Sans',sans-serif; }
.dash-wrap  { max-width:1200px; margin:0 auto; }
.dash-title { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:500; color:var(--text); letter-spacing:-.3px; }
.dash-sub   { font-size:13px; color:var(--sub); margin-top:.25rem; margin-bottom:2rem; }

/* Stat cards */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:2rem; }
@media(max-width:900px){ .stats-grid { grid-template-columns:repeat(2,1fr); } }
.stat-card  { background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:1.4rem 1.6rem; }
.stat-card-label { font-size:12px; font-weight:500; color:var(--sub); text-transform:uppercase; letter-spacing:.4px; margin-bottom:.6rem; }
.stat-card-num   { font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:500; color:var(--text); line-height:1; margin-bottom:.4rem; }
.stat-card-desc  { font-size:12px; color:var(--sub); }

/* Main grid */
.main-grid  { display:grid; grid-template-columns:1fr 340px; gap:1.5rem; }
@media(max-width:1024px){ .main-grid { grid-template-columns:1fr; } }

/* Panels */
.panel { background:var(--bg-card); border:1px solid var(--border); border-radius:18px; padding:1.5rem; }
.panel-title { font-weight:700; font-size:15px; color:var(--text); }
.panel-link  { font-size:13px; color:var(--blue); font-weight:500; text-decoration:none; }
.panel-link:hover { text-decoration:underline; }

/* Pending RDV items */
.rdv-pending-item { display:flex; align-items:center; gap:1rem; padding:1rem 0; border-bottom:1px solid var(--border); }
.rdv-pending-item:last-child { border-bottom:none; padding-bottom:0; }
.rdv-avatar { width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0; background:#fef3c7; color:#b45309; }
.rdv-pending-name { font-weight:600; font-size:14px; color:var(--text); }
.rdv-pending-sub  { font-size:12px; color:var(--sub); margin-top:.15rem; }
.rdv-actions { margin-left:auto; display:flex; gap:.4rem; flex-shrink:0; }

.btn-confirm { background:#e6f6ed; color:#0a7b45; border:none; border-radius:20px; font-size:12px; font-weight:600; padding:.4rem .9rem; cursor:pointer; transition:background .15s; font-family:'DM Sans',sans-serif; }
.btn-confirm:hover { background:#bbf7d0; }
.btn-deny    { background:#fff0f0; color:#dc2626; border:1px solid #fca5a5; border-radius:20px; font-size:12px; font-weight:600; padding:.4rem .9rem; cursor:pointer; transition:background .15s; font-family:'DM Sans',sans-serif; }
.btn-deny:hover    { background:#fee2e2; }
.dark .btn-confirm { background:rgba(16,185,129,.12); color:#34d399; }
.dark .btn-deny    { background:rgba(239,68,68,.08); border-color:rgba(239,68,68,.3); color:#f87171; }

/* Today schedule items */
.agenda-item { display:flex; align-items:center; gap:.85rem; padding:.75rem 0; border-bottom:1px solid var(--border); }
.agenda-item:last-child { border-bottom:none; padding-bottom:0; }
.agenda-time { font-size:13px; font-weight:700; color:var(--blue); min-width:48px; }
.agenda-name { font-size:13.5px; font-weight:600; color:var(--text); }
.agenda-sub  { font-size:12px; color:var(--sub); }

/* Badge */
.badge { display:inline-flex; align-items:center; gap:.3rem; font-size:11px; font-weight:600; padding:.2rem .65rem; border-radius:100px; }
.badge-dot { width:5px; height:5px; border-radius:50%; }
.badge-orange { background:#fff7ed; color:#c2410c; }
.badge-orange .badge-dot { background:#f97316; }
.badge-green  { background:#ecfdf5; color:#065f46; }
.badge-green .badge-dot  { background:#10b981; }
.dark .badge-orange { background:rgba(251,146,60,.12); color:#fb923c; }
.dark .badge-green  { background:rgba(52,211,153,.12); color:#34d399; }

/* Shortcuts */
.shortcuts-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
.shortcut-card  { background:var(--bg-page); border-radius:12px; padding:1rem; text-decoration:none; display:block; transition:box-shadow .2s, border-color .2s; border:1px solid var(--border); }
.shortcut-card:hover { border-color:var(--blue); box-shadow:0 4px 14px rgba(25,118,210,.15); }
.shortcut-icon { width:34px; height:34px; border-radius:9px; background:var(--bg-card); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; margin-bottom:.65rem; }
.shortcut-name { font-size:13px; font-weight:700; color:var(--text); }
.shortcut-desc { font-size:11px; color:var(--sub); margin-top:.15rem; }

/* Notifications */
.notif-item { display:flex; align-items:flex-start; gap:.7rem; padding:.75rem 0; border-bottom:1px solid var(--border); }
.notif-item:last-child { border-bottom:none; padding-bottom:0; }
.notif-dot  { width:8px; height:8px; border-radius:50%; background:#f97316; margin-top:.3rem; flex-shrink:0; }
.notif-dot.warning { background:#f59e0b; }
.notif-msg  { font-size:13px; color:var(--text); font-weight:500; }
.notif-date { font-size:11px; color:var(--sub); margin-top:.15rem; }
</style>

<div class="dash-page">
<div class="dash-wrap">

    <h1 class="dash-title">Bonjour, {{ Auth::user()->name }}</h1>
    <p class="dash-sub">{{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }} — gestion de la clinique</p>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-label">RDV aujourd'hui</div>
            <div class="stat-card-num">{{ $nbRdvAujourdhui ?? 0 }}</div>
            <div class="stat-card-desc">toutes salles confondues</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">En attente</div>
            <div class="stat-card-num">{{ $nbEnAttente ?? 0 }}</div>
            <div class="stat-card-desc">à confirmer</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Nouveaux patients</div>
            <div class="stat-card-num">{{ $nbNouveauxPatients ?? 0 }}</div>
            <div class="stat-card-desc">inscrits ce mois</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Médecins actifs</div>
            <div class="stat-card-num">{{ $nbMedecins ?? 0 }}</div>
            <div class="stat-card-desc">dans la clinique</div>
        </div>
    </div>

    <div class="main-grid">
        {{-- LEFT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Pending requests --}}
            <div class="panel">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.1rem;">
                    <span class="panel-title">Demandes en attente</span>
                    <a href="{{ route('rdv.planning') }}" class="panel-link">Voir tout</a>
                </div>
                @forelse($rdvEnAttente ?? [] as $rdv)
                    <div class="rdv-pending-item">
                        <div class="rdv-avatar">{{ strtoupper(substr($rdv['patient'],0,1)) }}</div>
                        <div>
                            <div class="rdv-pending-name">{{ $rdv['patient'] }}</div>
                            <div class="rdv-pending-sub">{{ $rdv['medecin'] }} — {{ $rdv['date'] }} à {{ $rdv['heure'] }}</div>
                        </div>
                        <div class="rdv-actions">
                            @php $appt = \App\Models\Appointment::find($rdv['id']); @endphp
                            @if($appt)
                            <form method="POST" action="{{ route('rdv.statut', $appt) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="confirme">
                                <button type="submit" class="btn-confirm">Confirmer</button>
                            </form>
                            @if($appt->canBeCancelledByStaff())
                            <form method="POST" action="{{ route('rdv.statut', $appt) }}" style="display:inline;" onsubmit="return confirm('Annuler ce RDV ?')">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="annule">
                                <button type="submit" class="btn-deny">Annuler</button>
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:2rem 1rem;color:var(--sub);">
                        <svg style="width:36px;height:36px;margin:0 auto .75rem;opacity:.4;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p style="font-size:13px;">Aucune demande en attente.</p>
                    </div>
                @endforelse
            </div>

            {{-- Today's agenda --}}
            <div class="panel">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.1rem;">
                    <span class="panel-title">Agenda du jour</span>
                    <a href="{{ route('rdv.planning') }}" class="panel-link">Agenda complet</a>
                </div>
                @forelse($rdvAujourdhui ?? [] as $rdv)
                    <div class="agenda-item">
                        <span class="agenda-time">{{ $rdv['heure'] }}</span>
                        <div style="flex:1;">
                            <div class="agenda-name">{{ $rdv['patient'] }}</div>
                            <div class="agenda-sub">{{ $rdv['medecin'] }}</div>
                        </div>
                        @if($rdv['statut'] === 'confirme')
                            <span class="badge badge-green"><span class="badge-dot"></span>Confirmé</span>
                        @else
                            <span class="badge badge-orange"><span class="badge-dot"></span>En attente</span>
                        @endif
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--sub);text-align:center;padding:1.5rem 0;">Aucun rendez-vous aujourd'hui.</p>
                @endforelse
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Shortcuts --}}
            <div class="panel">
                <div class="panel-title" style="margin-bottom:1rem;">Raccourcis</div>
                <div class="shortcuts-grid">
                    <a href="{{ route('secretaire.rdv.create') }}" class="shortcut-card">
                        <div class="shortcut-icon">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div class="shortcut-name">Nouveau RDV</div>
                        <div class="shortcut-desc">Créer manuellement</div>
                    </a>
                    <a href="{{ route('rdv.calendrier') }}" class="shortcut-card">
                        <div class="shortcut-icon">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </div>
                        <div class="shortcut-name">Agenda</div>
                        <div class="shortcut-desc">Vue hebdomadaire</div>
                    </a>
                    <a href="{{ route('rdv.planning') }}" class="shortcut-card">
                        <div class="shortcut-icon">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div class="shortcut-name">Planning</div>
                        <div class="shortcut-desc">Vue planning</div>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="shortcut-card">
                        <div class="shortcut-icon">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="shortcut-name">Mon profil</div>
                        <div class="shortcut-desc">Paramètres</div>
                    </a>
                </div>
            </div>

            {{-- Notifications --}}
            <div class="panel">
                <div class="panel-title" style="margin-bottom:1rem;">Notifications</div>
                @forelse($notifications ?? [] as $notif)
                    <div class="notif-item">
                        <span class="notif-dot warning"></span>
                        <div>
                            <div class="notif-msg">{{ $notif['message'] }}</div>
                            <div class="notif-date">{{ $notif['date'] }}</div>
                        </div>
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--sub);text-align:center;padding:1rem 0;">Aucune notification.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
</x-app-layout>
