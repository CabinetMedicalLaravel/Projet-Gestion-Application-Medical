<x-app-layout>
<style>
    :root { --blue: #1976D2; --blue-dark: #0D47A1; --blue-light: #1976D21a; --bg: #F4F8FB; }
    .rdv-page { background: var(--bg); min-height: calc(100vh - 64px); padding: 2.5rem 1.5rem; font-family: 'DM Sans', sans-serif; }
    .rdv-wrap { max-width: 900px; margin: 0 auto; }

    .rdv-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
    .rdv-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 500; color: #111; letter-spacing: -.3px; }
    .rdv-sub { font-size: 13px; color: #6b7280; margin-top: .2rem; }

    .rdv-btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        background: linear-gradient(135deg, var(--blue), var(--blue-dark));
        color: white; padding: .7rem 1.4rem; border-radius: 10px;
        font-size: 13.5px; font-weight: 500; text-decoration: none;
        transition: transform .15s, box-shadow .15s;
    }
    .rdv-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px #1976D240; }

    .rdv-success { background: #ecfdf5; border: 0.5px solid #6ee7b7; color: #065f46; border-radius: 10px; padding: .75rem 1rem; font-size: 13px; margin-bottom: 1.25rem; display:flex; align-items:center; gap:.5rem; }
    .rdv-empty { background: white; border-radius: 16px; border: 0.5px solid #e5e7eb; padding: 4rem 2rem; text-align: center; }

    .stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card { background: white; border-radius: 14px; border: 0.5px solid #e5e7eb; padding: 1.2rem; text-align: center; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 500; }
    .stat-label { font-size: 12px; color: #6b7280; margin-top: .25rem; }
    .stat-purple .stat-num { color: var(--blue); }
    .stat-green  .stat-num { color: #059669; }
    .stat-red    .stat-num { color: #dc2626; }

    .rdv-list { display: flex; flex-direction: column; gap: .75rem; }
    .rdv-item { background: white; border-radius: 14px; border: 0.5px solid #e5e7eb; padding: 1.1rem 1.4rem; display: flex; align-items: center; gap: 1.2rem; transition: box-shadow .2s; }
    .rdv-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }

    .rdv-date-box { flex-shrink: 0; width: 60px; text-align: center; background: #f9fafb; border-radius: 10px; padding: .6rem .4rem; border: 0.5px solid #e5e7eb; }
    .rdv-day { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 500; color: #111; line-height: 1; }
    .rdv-month { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: .4px; margin-top: .2rem; }
    .rdv-time { font-size: 12px; font-weight: 600; color: var(--blue); margin-top: .25rem; }

    .rdv-info { flex: 1; }
    .rdv-doctor { font-weight: 600; font-size: 14px; color: #111; }
    .rdv-reason { font-size: 12.5px; color: #6b7280; margin-top: .2rem; font-style: italic; }

    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 11.5px; font-weight: 500; padding: .25rem .7rem; border-radius: 100px;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-orange { background: #fff7ed; color: #c2410c; }
    .badge-orange .badge-dot { background: #f97316; }
    .badge-blue { background: var(--blue-light); color: var(--blue-dark); }
    .badge-blue .badge-dot { background: var(--blue); }
    .badge-green  { background: #ecfdf5; color: #065f46; }
    .badge-green .badge-dot  { background: #10b981; }
    .badge-gray   { background: #f9fafb; color: #6b7280; }
    .badge-gray .badge-dot   { background: #9ca3af; }

    .rdv-actions { display: flex; gap: .5rem; flex-shrink: 0; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 12.5px; padding: .5rem .9rem; border-radius: 8px;
        border: 0.5px solid #e5e7eb; background: white; color: #374151;
        text-decoration: none; cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif;
    }
    .btn-edit:hover { border-color: var(--blue); color: var(--blue); }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: 12.5px; padding: .5rem .9rem; border-radius: 8px;
        border: 0.5px solid #fca5a5; background: white; color: #dc2626;
        cursor: pointer; transition: all .15s; font-family: 'DM Sans', sans-serif;
    }
    .btn-cancel:hover { background: #fef2f2; }

    /* ── Dark mode ── */
    .dark { --bg: #0f172a; }
    .dark .rdv-page { background: #0f172a; }
    .dark .rdv-title { color: #f1f5f9; }
    .dark .rdv-sub { color: #94a3b8; }
    .dark .rdv-success { background: rgba(16,185,129,.1); border-color: rgba(52,211,153,.3); color: #34d399; }
    .dark .rdv-empty { background: #1e293b; border-color: #334155; }
    .dark .rdv-empty p { color: #f1f5f9; }
    .dark .stat-card { background: #1e293b; border-color: #334155; }
    .dark .stat-label { color: #94a3b8; }
    .dark .rdv-item { background: #1e293b; border-color: #334155; }
    .dark .rdv-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,.3); }
    .dark .rdv-date-box { background: #0f172a; border-color: #334155; }
    .dark .rdv-day { color: #f1f5f9; }
    .dark .rdv-month { color: #94a3b8; }
    .dark .rdv-doctor { color: #f1f5f9; }
    .dark .rdv-reason { color: #94a3b8; }
    .dark .badge-orange { background: rgba(251,146,60,.12); color: #fb923c; }
    .dark .badge-blue { background: rgba(25,118,210,.15); color: #1E88E5; }
    .dark .badge-green  { background: rgba(16,185,129,.12); color: #34d399; }
    .dark .badge-gray   { background: #334155; color: #94a3b8; }
    .dark .btn-edit { background: #1e293b; border-color: #334155; color: #cbd5e1; }
    .dark .btn-edit:hover { border-color: var(--blue); color: #1E88E5; }
    .dark .btn-cancel { background: #1e293b; border-color: rgba(248,113,113,.4); color: #f87171; }
    .dark .btn-cancel:hover { background: rgba(248,113,113,.08); }
</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<div class="rdv-page">
<div class="rdv-wrap">

    <div class="rdv-header">
        <div>
            <h1 class="rdv-title">Mes rendez-vous</h1>
            <p class="rdv-sub">Historique et gestion de vos consultations</p>
        </div>
        <a href="{{ route('rdv.create') }}" class="rdv-btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Nouveau RDV
        </a>
    </div>

    @if(session('success'))
        <div class="rdv-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($rdvs->isEmpty())
        <div class="rdv-empty">
            <svg style="width:56px;height:56px;margin:0 auto 1rem;opacity:.3;" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            <p class="rdv-doctor" style="font-size:15px;">Aucun rendez-vous</p>
            <p class="rdv-reason" style="margin:.5rem 0 1.5rem;">Vous n'avez pas encore de rendez-vous enregistré.</p>
            <a href="{{ route('rdv.create') }}" class="rdv-btn-primary">Prendre mon premier RDV</a>
        </div>
    @else
        @php
            $aVenir   = $rdvs->whereIn('status', ['en_attente','confirme'])->count();
            $termines = $rdvs->where('status','termine')->count();
            $annules  = $rdvs->where('status','annule')->count();
        @endphp

        <div class="stats-grid">
            <div class="stat-card stat-purple">
                <div class="stat-num">{{ $aVenir }}</div>
                <div class="stat-label">À venir</div>
            </div>
            <div class="stat-card stat-green">
                <div class="stat-num">{{ $termines }}</div>
                <div class="stat-label">Terminés</div>
            </div>
            <div class="stat-card stat-red">
                <div class="stat-num">{{ $annules }}</div>
                <div class="stat-label">Annulés</div>
            </div>
        </div>

        <div class="rdv-list">
            @foreach($rdvs as $rdv)
                @php
                    $dt = \Carbon\Carbon::parse($rdv->appointment_date);
                    $badgeClass = match($rdv->status) {
                        'en_attente' => 'badge-orange',
                        'confirme'   => 'badge-blue',
                        'termine'    => 'badge-green',
                        default      => 'badge-gray',
                    };
                    $label = ['en_attente'=>'En attente','confirme'=>'Confirmé','termine'=>'Terminé','annule'=>'Annulé'][$rdv->status] ?? $rdv->status;
                @endphp
                <div class="rdv-item">
                    <div class="rdv-date-box">
                        <div class="rdv-day">{{ $dt->format('d') }}</div>
                        <div class="rdv-month">{{ $dt->translatedFormat('M') }}</div>
                        <div class="rdv-time">{{ $dt->format('H:i') }}</div>
                    </div>
                    <div class="rdv-info">
                        <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
                            <span class="rdv-doctor">Dr. {{ $rdv->doctor->name }}</span>
                            <span class="badge {{ $badgeClass }}">
                                <span class="badge-dot"></span>{{ $label }}
                            </span>
                        </div>
                        @if($rdv->reason)
                            <div class="rdv-reason">"{{ Str::limit($rdv->reason, 80) }}"</div>
                        @endif
                    </div>
                    @if(in_array($rdv->status, ['en_attente','confirme']))
                        <div class="rdv-actions">
                            <a href="{{ route('rdv.edit', $rdv) }}" class="btn-edit">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('rdv.annuler', $rdv) }}" onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-cancel">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    Annuler
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>
</div>
</x-app-layout>
