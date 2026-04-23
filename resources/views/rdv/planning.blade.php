<x-app-layout>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --accent: #1976D2;
            --accent-dark: #0D47A1;
            --accent-glow: rgba(25, 118, 210, .15);
            --bg-page: #F4F8FB;
            --bg-card: #ffffff;
            --border: #e5e7eb;
            --text-main: #111827;
            --text-sub: #6b7280;
        }

        .dark {
            --bg-page: #0f172a;
            --bg-card: #1e293b;
            --border: #334155;
            --text-main: #f1f5f9;
            --text-sub: #94a3b8;
        }

        .plan-page {
            background: var(--bg-page);
            min-height: calc(100vh - 64px);
            padding: 2.5rem 1.5rem;
            font-family: 'DM Sans', sans-serif;
        }

        .plan-wrap {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .plan-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .plan-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 500;
            color: var(--text-main);
            letter-spacing: -.3px;
        }

        .plan-sub {
            font-size: 13px;
            color: var(--text-sub);
            margin-top: .2rem;
        }

        /* Controls */
        .plan-controls {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .ctrl-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--text-sub);
            transition: all .15s;
        }

        .ctrl-btn:hover {
            border-color: var(--accent);
            color: var(--accent-dark);
        }

        .ctrl-today {
            padding: .4rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-main);
            text-decoration: none;
            transition: all .15s;
        }

        .ctrl-today:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .view-toggle {
            display: flex;
            border-radius: 9px;
            border: 1px solid var(--border);
            overflow: hidden;
            background: var(--bg-card);
        }

        .view-toggle a {
            padding: .4rem 1rem;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-sub);
            transition: all .15s;
        }

        .view-toggle a.active {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
        }

        /* Stats row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .75rem;
            margin-bottom: 1.5rem;
        }

        .stat-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            text-align: center;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 500;
            color: var(--text-main);
            line-height: 1.1;
        }

        .stat-lbl {
            font-size: 11.5px;
            color: var(--text-sub);
            margin-top: .3rem;
        }

        .stat-box.total {}

        .stat-box.pending {
            background: #fff7ed;
            border-color: #fde68a;
        }

        .stat-box.pending .stat-num {
            color: #c2410c;
        }

        .stat-box.confirmed {
            background: #ecfdf5;
            border-color: #6ee7b7;
        }

        .stat-box.confirmed .stat-num {
            color: #065f46;
        }

        .stat-box.done {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .stat-box.done .stat-num {
            color: #1d4ed8;
        }

        .dark .stat-box.pending {
            background: rgba(251, 146, 60, .08);
            border-color: rgba(251, 146, 60, .2);
        }

        .dark .stat-box.pending .stat-num {
            color: #fb923c;
        }

        .dark .stat-box.confirmed {
            background: rgba(52, 211, 153, .08);
            border-color: rgba(52, 211, 153, .2);
        }

        .dark .stat-box.confirmed .stat-num {
            color: #34d399;
        }

        .dark .stat-box.done {
            background: rgba(25, 118, 210, .08);
            border-color: rgba(99, 102, 241, .2);
        }

        .dark .stat-box.done .stat-num {
            color: #1E88E5;
        }

        /* Day list */
        .rdv-list {
            display: flex;
            flex-direction: column;
            gap: .65rem;
        }

        .rdv-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 1rem 1.3rem;
            display: flex;
            align-items: center;
            gap: 1.1rem;
            transition: box-shadow .2s;
        }

        .rdv-item:hover {
            box-shadow: 0 4px 16px var(--accent-glow);
            border-color: var(--accent);
        }

        .rdv-time-badge {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--accent);
            width: 54px;
            flex-shrink: 0;
            text-align: center;
        }

        .rdv-vline {
            width: 1px;
            height: 36px;
            background: var(--border);
            flex-shrink: 0;
        }

        .rdv-name {
            font-weight: 700;
            font-size: 14px;
            color: var(--text-main);
        }

        .rdv-reason {
            font-size: 12px;
            color: var(--text-sub);
            margin-top: .2rem;
            font-style: italic;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            font-size: 11px;
            font-weight: 600;
            padding: .25rem .65rem;
            border-radius: 100px;
        }

        .badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-orange {
            background: rgba(251, 146, 60, .12);
            color: #c2410c;
        }

        .dark .badge-orange {
            color: #fb923c;
        }

        .badge-orange .badge-dot {
            background: #f97316;
        }

        .badge-blue {
            background: rgba(25, 118, 210, .12);
            color: #0D47A1;
        }

        .dark .badge-blue {
            color: #1E88E5;
        }

        .badge-blue .badge-dot {
            background: var(--accent);
        }

        .badge-green {
            background: rgba(52, 211, 153, .12);
            color: #059669;
        }

        .dark .badge-green {
            color: #34d399;
        }

        .badge-green .badge-dot {
            background: #10b981;
        }

        .badge-gray {
            background: rgba(148, 163, 184, .10);
            color: #64748b;
        }

        .badge-gray .badge-dot {
            background: #94a3b8;
        }

        .btn-sm {
            font-size: 12px;
            padding: .4rem .85rem;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            transition: all .15s;
        }

        .btn-confirm {
            background: rgba(25, 118, 210, .12);
            color: var(--accent);
        }

        .btn-confirm:hover {
            background: var(--accent);
            color: white;
        }

        .btn-done {
            background: rgba(52, 211, 153, .12);
            color: #059669;
        }

        .dark .btn-done {
            color: #34d399;
        }

        .btn-done:hover {
            background: #10b981;
            color: white;
        }

        .btn-disabled {
            background: rgba(148, 163, 184, .08);
            color: #94a3b8;
            cursor: not-allowed;
            font-size: 11px;
            padding: .4rem .7rem;
            border-radius: 7px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
        }

        /* Week grid */
        .week-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: .6rem;
        }

        .week-col {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 13px;
            overflow: hidden;
            min-width: 0;
        }

        .week-col.today {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .week-head {
            padding: .65rem .5rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            background: var(--bg-page);
        }

        .week-col.today .week-head {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-bottom-color: transparent;
        }

        .week-dow {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-sub);
        }

        .week-col.today .week-dow {
            color: rgba(255, 255, 255, .7);
        }

        .week-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .week-col.today .week-num {
            color: white;
        }

        .week-body {
            padding: .5rem;
            min-height: 110px;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        .week-slot {
            background: rgba(25, 118, 210, .10);
            border: 1px solid rgba(25, 118, 210, .2);
            border-radius: 7px;
            padding: .35rem .5rem;
        }

        .dark .week-slot {
            background: rgba(25, 118, 210, .15);
            border-color: rgba(25, 118, 210, .3);
        }

        .week-slot-time {
            font-size: 11px;
            font-weight: 700;
            color: var(--accent);
        }

        .week-slot-name {
            font-size: 11px;
            color: var(--text-main);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 1px;
        }

        .week-empty {
            text-align: center;
            font-size: 11.5px;
            color: var(--border);
            padding-top: 1.5rem;
        }

        /* Empty state */
        .rdv-empty {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 3.5rem 2rem;
            text-align: center;
        }

        .success-bar {
            background: rgba(52, 211, 153, .10);
            border: 1px solid rgba(52, 211, 153, .3);
            color: #059669;
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: 13px;
            margin-bottom: 1.25rem;
        }

        .dark .success-bar {
            color: #34d399;
        }
    </style>

    <div class="plan-page">
        <div class="plan-wrap">

            <div class="plan-header">
                <div>
                    <h1 class="plan-title">Mon planning</h1>
                    <p class="plan-sub">
                        @if($vue === 'semaine')
                            Semaine du {{ $date->copy()->startOfWeek()->translatedFormat('d M') }} au
                            {{ $date->copy()->endOfWeek()->translatedFormat('d M Y') }}
                        @else
                            {{ ucfirst($date->translatedFormat('l d F Y')) }}
                        @endif
                    </p>
                </div>
                <div class="plan-controls">
                    @php
                        $prev = $vue === 'semaine' ? $date->copy()->subWeek()->format('Y-m-d') : $date->copy()->subDay()->format('Y-m-d');
                        $next = $vue === 'semaine' ? $date->copy()->addWeek()->format('Y-m-d') : $date->copy()->addDay()->format('Y-m-d');
                    @endphp
                    <a href="{{ route('rdv.planning', ['vue' => $vue, 'date' => $prev]) }}" class="ctrl-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                    </a>
                    <a href="{{ route('rdv.planning', ['vue' => $vue, 'date' => now()->format('Y-m-d')]) }}"
                        class="ctrl-today">Aujourd'hui</a>
                    <a href="{{ route('rdv.planning', ['vue' => $vue, 'date' => $next]) }}" class="ctrl-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </a>
                    <div class="view-toggle">
                        <a href="{{ route('rdv.planning', ['vue' => 'jour', 'date' => $date->format('Y-m-d')]) }}"
                            class="{{ $vue === 'jour' ? 'active' : '' }}">Jour</a>
                        <a href="{{ route('rdv.planning', ['vue' => 'semaine', 'date' => $date->format('Y-m-d')]) }}"
                            class="{{ $vue === 'semaine' ? 'active' : '' }}">Semaine</a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="success-bar">✓ {{ session('success') }}</div>
            @endif

            @if($vue === 'jour')
                @php $rdvList = $rdvs; @endphp
                @if($rdvList->isEmpty())
                    <div class="rdv-empty">
                        <svg style="width:48px;height:48px;color:var(--border);margin:0 auto 1rem;" fill="none"
                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        <p style="font-size:15px;font-weight:700;color:var(--text-main);">Aucun rendez-vous ce jour</p>
                        <p style="font-size:13px;color:var(--text-sub);margin-top:.4rem;">Journée libre</p>
                    </div>
                @else
                    <div class="stats-row">
                        <div class="stat-box">
                            <div class="stat-num">{{ $rdvList->count() }}</div>
                            <div class="stat-lbl">Total</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num" style="color:#f97316;">{{ $rdvList->where('status', 'en_attente')->count() }}
                            </div>
                            <div class="stat-lbl">En attente</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num" style="color:var(--accent);">{{ $rdvList->where('status', 'confirme')->count() }}
                            </div>
                            <div class="stat-lbl">Confirmés</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-num" style="color:#10b981;">{{ $rdvList->where('status', 'termine')->count() }}
                            </div>
                            <div class="stat-lbl">Terminés</div>
                        </div>
                    </div>

                    <div class="rdv-list">
                        @foreach($rdvList as $rdv)
                            @php
                                $dt = \Carbon\Carbon::parse($rdv->appointment_date);
                                $bc = match ($rdv->status) { 'en_attente' => 'badge-orange', 'confirme' => 'badge-blue', 'termine' => 'badge-green', default => 'badge-gray'};
                                $lbl = ['en_attente' => 'En attente', 'confirme' => 'Confirmé', 'termine' => 'Terminé', 'annule' => 'Annulé'][$rdv->status] ?? $rdv->status;
                            @endphp
                            <div class="rdv-item">
                                <div class="rdv-time-badge">{{ $dt->format('H:i') }}</div>
                                <div class="rdv-vline"></div>
                                <div style="flex:1;min-width:0;">
                                    <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
                                        <span class="rdv-name">{{ $rdv->patient_display_name }}</span>
                                        <span class="badge {{ $bc }}"><span class="badge-dot"></span>{{ $lbl }}</span>
                                    </div>
                                    @if($rdv->reason)
                                    <div class="rdv-reason">"{{ Str::limit($rdv->reason, 70) }}"</div>@endif
                                </div>
                                <div style="display:flex;gap:.4rem;flex-shrink:0;">
                                    @if($rdv->status === 'en_attente')
                                        <form method="POST" action="{{ route('rdv.statut', $rdv) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="confirme">
                                            <button type="submit" class="btn-sm btn-confirm">Confirmer</button>
                                        </form>
                                    @elseif($rdv->status === 'confirme')
                                        @if($rdv->canBeMarkedDone())
                                            <form method="POST" action="{{ route('rdv.statut', $rdv) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="termine">
                                                <button type="submit" class="btn-sm btn-done">Terminer</button>
                                            </form>
                                        @else
                                            <span class="btn-disabled">Pas encore passé</span>
                                        @endif
                                    @endif
                                    @if(in_array($rdv->status, ['en_attente', 'confirme']))
                                        @if($rdv->canBeCancelledByStaff())
                                            <form method="POST" action="{{ route('rdv.statut', $rdv) }}"
                                                onsubmit="return confirm('Annuler ?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="annule">
                                                <button type="submit" class="btn-sm"
                                                    style="background:rgba(248,113,113,.1);color:#ef4444;">Annuler</button>
                                            </form>
                                        @else
                                            <span class="btn-disabled">
                                                < 24h</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            @else
                {{-- WEEK VIEW --}}
                @php
                    $jours = [];
                    $start = $date->copy()->startOfWeek();
                    for ($i = 0; $i < 7; $i++)
                        $jours[] = $start->copy()->addDays($i);
                @endphp
                <div class="week-grid">
                    @foreach($jours as $jour)
                        @php
                            $ds = $jour->toDateString();
                            $rdvJour = $rdvs[$ds] ?? collect();
                            $isToday = $jour->isToday();
                        @endphp
                        <div class="week-col {{ $isToday ? 'today' : '' }}">
                            <div class="week-head">
                                <div class="week-dow">{{ $jour->translatedFormat('D') }}</div>
                                <div class="week-num">{{ $jour->format('d') }}</div>
                            </div>
                            <div class="week-body">
                                @if($rdvJour->isEmpty())
                                    <div class="week-empty">—</div>
                                @else
                                    @foreach($rdvJour as $rdv)
                                        <div class="week-slot">
                                            <div class="week-slot-time">
                                                {{ \Carbon\Carbon::parse($rdv->appointment_date)->format('H:i') }}</div>
                                            <div class="week-slot-name">{{ $rdv->patient_display_name }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>