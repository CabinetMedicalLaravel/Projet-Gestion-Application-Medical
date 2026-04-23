<x-app-layout>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --blue: #1976D2;
            --blue-dark: #0D47A1;
            --blue-light: #1976D21a;
        }

        .rdv-page {
            min-height: calc(100vh - 64px);
            padding: 2.5rem 1.5rem;
            font-family: 'DM Sans', sans-serif;
            background: #F4F8FB;
        }

        .dark .rdv-page {
            background: #0f172a;
        }

        .rdv-wrap {
            max-width: 660px;
            margin: 0 auto;
        }

        .page-back {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: color .15s;
        }

        .page-back:hover {
            color: var(--blue);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 500;
            color: #111;
            letter-spacing: -.3px;
        }

        .dark .page-title {
            color: #f1f5f9;
        }

        .page-sub {
            font-size: 13px;
            color: #6b7280;
            margin-top: .25rem;
            margin-bottom: 1.75rem;
        }

        .dark .page-sub {
            color: #94a3b8;
        }

        .form-card {
            background: white;
            border-radius: 18px;
            border: 0.5px solid #e5e7eb;
            padding: 2rem;
        }

        .dark .form-card {
            background: #1e293b;
            border-color: #334155;
        }

        .patient-banner {
            display: flex;
            align-items: center;
            gap: .75rem;
            background: linear-gradient(135deg, #1976D215, #0D47A110);
            border: 0.5px solid #1976D233;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            font-size: 13px;
            color: #1976D2;
        }

        .dark .patient-banner {
            color: #c4b5fd;
            background: #1976D210;
            border-color: #1976D230;
        }

        .step-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6b7280;
            margin-bottom: .6rem;
        }

        .dark .step-label {
            color: #94a3b8;
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .form-field {
            margin-bottom: 1.4rem;
        }

        .form-input {
            width: 100%;
            padding: .75rem 1rem .75rem 2.6rem;
            background: #f9fafb;
            border: 0.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13.5px;
            color: #111;
            outline: none;
            transition: border .18s, box-shadow .18s;
            font-family: 'DM Sans', sans-serif;
            box-sizing: border-box;
        }

        .form-input-plain {
            padding-left: 1rem;
        }

        .dark .form-input {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }

        .form-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-light);
        }

        .inp-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .inp-ico {
            position: absolute;
            left: 12px;
            width: 16px;
            height: 16px;
            opacity: .4;
            pointer-events: none;
        }

        .dark .inp-ico {
            opacity: .5;
            filter: invert(1);
        }

        .slots-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .45rem;
        }

        .slot-btn {
            padding: .6rem .25rem;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 500;
            border: 0.5px solid #e5e7eb;
            background: #f9fafb;
            color: #374151;
            cursor: pointer;
            transition: all .18s;
            font-family: 'DM Sans', sans-serif;
            text-align: center;
        }

        .dark .slot-btn {
            background: #0f172a;
            border-color: #334155;
            color: #cbd5e1;
        }

        .slot-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .slot-btn.selected {
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: white;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-light);
        }

        .form-textarea {
            width: 100%;
            padding: .75rem 1rem;
            background: #f9fafb;
            border: 0.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 13.5px;
            color: #111;
            outline: none;
            resize: none;
            font-family: 'DM Sans', sans-serif;
            transition: border .18s, box-shadow .18s;
            box-sizing: border-box;
        }

        .dark .form-textarea {
            background: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }

        .form-textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-light);
        }

        .alert-err {
            background: #fef2f2;
            border: 0.5px solid #fca5a5;
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 1.2rem;
        }

        .field-err {
            font-size: 12px;
            color: #dc2626;
            margin-top: .3rem;
            display: block;
        }

        .btn-primary {
            width: 100%;
            padding: .85rem;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, var(--blue), var(--blue-dark));
            color: #fff;
            font-size: 14.5px;
            font-weight: 500;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px #1976D240;
        }

        .btn-secondary {
            display: block;
            width: 100%;
            padding: .8rem;
            border-radius: 10px;
            border: 0.5px solid #e5e7eb;
            background: transparent;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            transition: background .15s;
            font-family: 'DM Sans', sans-serif;
            margin-top: .75rem;
        }

        .dark .btn-secondary {
            border-color: #334155;
            color: #cbd5e1;
        }

        .dark .btn-secondary:hover {
            background: #0f172a;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.25rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 0.5px;
            background: #e5e7eb;
        }

        .dark .divider::before,
        .dark .divider::after {
            background: #334155;
        }

        .dark .alert-err {
            background: rgba(220, 38, 38, .1);
            border-color: rgba(248, 113, 113, .3);
            color: #f87171;
        }

        .dark .field-err {
            color: #f87171;
        }

        .dark .divider span {
            color: #475569;
        }

        .divider span {
            font-size: 12px;
            color: #9ca3af;
        }
    </style>

    <div class="rdv-page">
        <div class="rdv-wrap">

            <a href="{{ route('secretaire.dashboard') }}" class="page-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 5l-7 7 7 7" />
                </svg>
                Retour au tableau de bord
            </a>
            <h1 class="page-title">Nouveau rendez-vous</h1>
            <p class="page-sub">Créer un rendez-vous pour un patient (avec ou sans compte)</p>

            <div class="patient-banner">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4m0 4h.01" />
                </svg>
                En tant que secrétaire, ce rendez-vous sera directement confirmé et attribué au nom du
                patient saisi.
            </div>

            <div class="form-card">

                @if($errors->any())
                    <div class="alert-err">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('rdv.store') }}" id="rdv-form">
                    @csrf

                    {{-- Patient name (select from registered patients) --}}
                    <div class="form-field">
                        <div class="step-label">
                            <span class="step-badge">1</span> Nom du patient
                        </div>
                        <div class="inp-wrap">
                            <svg class="inp-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <select name="patient_name" required class="form-input" style="cursor:pointer;">
                                <option value="">— Sélectionner un patient —</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->name }}" @selected(old('patient_name') === $p->name)>{{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('patient_name')<span class="field-err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Médecin --}}
                    <div class="form-field">
                        <div class="step-label">
                            <span class="step-badge">2</span> Choisir un médecin
                        </div>
                        <div class="inp-wrap">
                            <svg class="inp-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                            <select name="doctor_id" id="doctor_id" required class="form-input" style="cursor:pointer;"
                                onchange="reloadCreneaux()">
                                <option value="">— Sélectionner un médecin —</option>
                                @foreach($medecins as $m)
                                    <option value="{{ $m->id }}" @selected(old('doctor_id', $doctorId) == $m->id)>Dr.
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('doctor_id')<span class="field-err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Date --}}
                    <div class="form-field">
                        <div class="step-label">
                            <span class="step-badge">3</span> Choisir une date
                        </div>
                        <div class="inp-wrap">
                            <svg class="inp-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <path d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                            <input type="date" name="date" id="date" required value="{{ old('date', $date) }}"
                                min="{{ now()->format('Y-m-d') }}" class="form-input" onchange="reloadCreneaux()">
                        </div>
                        @error('date')<span class="field-err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Créneau --}}
                    <div class="form-field">
                        <div class="step-label">
                            <span class="step-badge">4</span> Créneau horaire
                        </div>
                        <input type="hidden" name="heure" id="heure-hidden"
                            value="{{ old('heure', $preselectedHeure) }}">
                        <div class="slots-grid" id="creneaux-grid">
                            @forelse($creneauxDisponibles as $c)
                                <button type="button" onclick="selectCreneau(this, '{{ $c }}')"
                                    class="slot-btn {{ old('heure', $preselectedHeure) === $c ? 'selected' : '' }}">
                                    {{ $c }}
                                </button>
                            @empty
                                <p
                                    style="grid-column:span 4; font-size:13px; color:#9ca3af; font-style:italic; padding:.5rem 0; opacity:.8;">
                                    @if($doctorId) Aucun créneau disponible pour cette date.
                                    @else Sélectionnez un médecin et une date pour voir les créneaux.
                                    @endif
                                </p>
                            @endforelse
                        </div>
                        @error('heure')<span class="field-err">{{ $message }}</span>@enderror
                    </div>

                    {{-- Motif --}}
                    <div class="form-field">
                        <div class="step-label">
                            <span class="step-badge">5</span> Motif de consultation
                        </div>
                        <textarea name="reason" rows="3" required maxlength="500"
                            placeholder="Décrivez brièvement la raison de la consultation..."
                            class="form-textarea">{{ old('reason') }}</textarea>
                        @error('reason')<span class="field-err">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="btn-primary">
                        Confirmer le rendez-vous
                    </button>
                    <a href="{{ route('secretaire.dashboard') }}" class="btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectCreneau(btn, heure) {
            document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            document.getElementById('heure-hidden').value = heure;
        }
        function reloadCreneaux() {
            const doctorId = document.getElementById('doctor_id').value;
            const dateInput = document.getElementById('date');
            const date = dateInput.value;
            if (!date) return;
            // Block past dates client-side
            const today = new Date(); today.setHours(0, 0, 0, 0);
            const chosen = new Date(date + 'T00:00:00');
            if (chosen < today) {
                dateInput.value = today.toISOString().split('T')[0];
                return;
            }
            if (!doctorId || !date) return;
            const url = new URL(window.location.href);
            url.searchParams.set('doctor_id', doctorId);
            url.searchParams.set('date', dateInput.value);
            window.location.href = url.toString();
        }
    </script>
</x-app-layout>