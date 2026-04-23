<x-app-layout>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        /* ── Palette ──────────────────────────────────────────────── */
        :root {
            --accent: #1976D2;
            /* indigo-violet */
            --accent-dark: #0D47A1;
            --accent-glow: rgba(25, 118, 210, .15);
            --green: #34D399;
            --green-bg: rgba(52, 211, 153, .12);
            --green-border: rgba(52, 211, 153, .35);
            --red: #F87171;
            --red-bg: rgba(248, 113, 113, .10);
            --red-border: rgba(248, 113, 113, .30);
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
            --green-bg: rgba(52, 211, 153, .08);
            --red-bg: rgba(248, 113, 113, .08);
        }

        /* ── Layout ──────────────────────────────────────────────── */
        .cal-page {
            background: var(--bg-page);
            min-height: calc(100vh - 64px);
            padding: 2.5rem 1.5rem;
            font-family: 'DM Sans', sans-serif;
        }

        .cal-wrap {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ── Header ──────────────────────────────────────────────── */
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .cal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 500;
            color: var(--text-main);
            letter-spacing: -.3px;
        }

        .cal-sub {
            font-size: 13px;
            color: var(--text-sub);
            margin-top: .2rem;
        }

        .btn-accent {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            padding: .7rem 1.4rem;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
        }

        .btn-accent:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(25, 118, 210, .4);
        }

        /* ── Filter card ─────────────────────────────────────────── */
        .filter-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .filter-label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--text-sub);
            margin-bottom: .35rem;
            display: block;
        }

        .filter-select,
        .filter-month {
            background: var(--bg-page);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .6rem 1rem;
            font-size: 13.5px;
            color: var(--text-main);
            outline: none;
            font-family: 'DM Sans', sans-serif;
            transition: border .18s, box-shadow .18s;
        }

        .filter-select:focus,
        .filter-month:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-light);
        }

        /* ── Doctor banner ───────────────────────────────────────── */
        .doctor-banner {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 14px;
            padding: 1rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
            color: white;
        }

        .doctor-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* ── Legend ──────────────────────────────────────────────── */
        .legend {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.25rem;
            font-size: 13px;
            color: var(--text-sub);
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .leg-dot {
            width: 12px;
            height: 12px;
            border-radius: 4px;
        }

        .leg-free {
            background: var(--green);
        }

        .leg-taken {
            background: var(--red);
        }

        /* ── Calendar grid ───────────────────────────────────────── */
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1rem;
        }

        .cal-day {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: box-shadow .2s, border-color .2s;
        }

        .cal-day:hover {
            border-color: var(--blue);
            box-shadow: 0 4px 20px var(--blue-light);
        }

        .cal-day.today {
            border-color: var(--blue);
            box-shadow: 0 0 0 2px var(--blue-light);
        }

        .cal-day-head {
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--border);
            background: var(--bg-page);
        }

        .cal-day.today .cal-day-head {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-bottom-color: transparent;
        }

        .cal-day-name {
            font-weight: 700;
            font-size: 13px;
            color: var(--text-main);
            text-transform: capitalize;
        }

        .cal-day.today .cal-day-name {
            color: white;
        }

        .cal-day-date {
            font-size: 11.5px;
            color: var(--text-sub);
            margin-top: .1rem;
        }

        .cal-day.today .cal-day-date {
            color: rgba(255, 255, 255, .75);
        }

        .cal-slots {
            padding: .6rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .35rem;
        }

        /* Free slot — green */
        .slot-free {
            display: block;
            text-align: center;
            font-size: 12.5px;
            font-weight: 600;
            padding: .45rem .2rem;
            border-radius: 8px;
            background: var(--green-bg);
            color: #059669;
            border: 1px solid var(--green-border);
            text-decoration: none;
            transition: all .15s;
        }

        .dark .slot-free {
            color: var(--green);
        }

        .slot-free:hover {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
            transform: translateY(-1px);
        }

        /* Taken slot — red */
        .slot-taken {
            display: block;
            text-align: center;
            font-size: 12.5px;
            font-weight: 500;
            padding: .45rem .2rem;
            border-radius: 8px;
            background: var(--red-bg);
            color: #b91c1c;
            border: 1px solid var(--red-border);
            text-decoration: line-through;
            cursor: not-allowed;
            opacity: .65;
        }

        .dark .slot-taken {
            color: var(--red);
        }

        /* ── Success / empty ─────────────────────────────────────── */
        .cal-success {
            background: var(--green-bg);
            border: 1px solid var(--green-border);
            color: #065f46;
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: 13px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .dark .cal-success {
            color: var(--green);
        }
    </style>

    <div class="cal-page">
        <div class="cal-wrap">

            {{-- Header --}}
            <div class="cal-header">
                <div>
                    <h1 class="cal-title">Calendrier des disponibilités</h1>
                    <p class="cal-sub">Cliquez sur un créneau vert pour réserver</p>
                </div>
                @if(Auth::user()->role === 'patient')
                    <a href="{{ route('rdv.create') }}" class="btn-accent">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Prendre un RDV
                    </a>
                @elseif(Auth::user()->role === 'secretaire')
                    <a href="{{ route('secretaire.rdv.create') }}" class="btn-accent">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Nouveau RDV
                    </a>
                @endif
            </div>

            @if(session('success'))
                <div class="cal-success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="filter-card">
                <form method="GET" style="display:flex;flex-wrap:wrap;gap:1.25rem;align-items:flex-end;">
                    <div>
                        <span class="filter-label">Médecin</span>
                        <select name="doctor_id" class="filter-select" onchange="this.form.submit()">
                            @foreach($medecins as $m)
                                <option value="{{ $m->id }}" @selected($medecin && $medecin->id === $m->id)>Dr. {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <span class="filter-label">Mois</span>
                        <input type="month" name="mois" value="{{ $mois }}" class="filter-month"
                            onchange="this.form.submit()">
                    </div>
                </form>
            </div>

            @if($medecin)
                {{-- Doctor banner --}}
                <div class="doctor-banner">
                    <div class="doctor-avatar">{{ strtoupper(substr($medecin->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-weight:700;font-size:1rem;">Dr. {{ $medecin->name }}</div>
                        <div style="font-size:12px;opacity:.75;margin-top:.1rem;">Médecin</div>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="legend">
                    <div class="legend-item"><span class="leg-dot leg-free"></span> Disponible — cliquez pour réserver</div>
                    <div class="legend-item"><span class="leg-dot leg-taken"></span> Créneau occupé</div>
                </div>

                {{-- Calendar --}}
                @php $today = \Carbon\Carbon::today(); @endphp

                @php $hasVisible = collect($calendar)->filter(fn($_, $date) => \Carbon\Carbon::parse($date)->gte($today))->isNotEmpty(); @endphp

                @if(!$hasVisible)
                    <div style="text-align:center;padding:4rem 2rem;color:var(--text-sub);">
                        <svg style="width:48px;height:48px;margin:0 auto 1rem;opacity:.4;" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        <p style="font-size:15px;font-weight:600;">Aucune disponibilité ce mois-ci</p>
                        <p style="font-size:13px;margin-top:.4rem;">Essayez le mois suivant.</p>
                    </div>
                @else
                    <div class="cal-grid">
                        @foreach($calendar as $date => $creneaux)
                            @php
                                $day = \Carbon\Carbon::parse($date);
                                $isPast = $day->lt($today);
                                $isDayToday = $day->isToday();
                            @endphp
                            @if($isPast) @continue @endif
                            <div class="cal-day {{ $isDayToday ? 'today' : '' }}">
                                <div class="cal-day-head">
                                    <div class="cal-day-name">{{ $day->translatedFormat('l') }}</div>
                                    <div class="cal-day-date">{{ $day->format('d/m/Y') }}</div>
                                </div>
                                <div class="cal-slots">
                                    @foreach($creneaux as $c)
                                        @if($c['disponible'])
                                            @if(Auth::user()->role === 'secretaire')
                                                <a href="{{ route('secretaire.rdv.create', ['doctor_id' => $medecin->id, 'date' => $date, 'heure' => $c['heure']]) }}"
                                                    class="slot-free">{{ $c['heure'] }}</a>
                                            @else
                                                <a href="{{ route('rdv.create', ['doctor_id' => $medecin->id, 'date' => $date, 'heure' => $c['heure']]) }}"
                                                    class="slot-free">{{ $c['heure'] }}</a>
                                            @endif
                                        @else
                                            <span class="slot-taken">{{ $c['heure'] }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>