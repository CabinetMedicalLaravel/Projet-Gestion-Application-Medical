<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    :root { --blue: #1976D2; --blue-dark: #0D47A1; --blue-light: #1976D21a; }
    .rdv-page { min-height: calc(100vh - 64px); padding: 2.5rem 1.5rem; font-family: 'DM Sans', sans-serif; background: #F4F8FB; }
    .rdv-wrap { max-width: 620px; margin: 0 auto; }

    .page-back { display: inline-flex; align-items: center; gap: .4rem; font-size: 13px; color: #6b7280; text-decoration: none; margin-bottom: 1rem; transition: color .15s; }
    .page-back:hover { color: var(--blue); }
    .page-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 500; color: #111; letter-spacing: -.3px; }
    .page-sub { font-size: 13px; color: #6b7280; margin-top: .25rem; margin-bottom: 1.75rem; }

    .current-rdv { background: linear-gradient(135deg, #1976D215, #0D47A110); border: 0.5px solid #1976D233; border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; }
    .current-day { width: 44px; height: 44px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), var(--blue-dark)); display: flex; align-items: center; justify-content: center; color: white; font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 500; flex-shrink: 0; }
    .current-label { font-size: 11px; font-weight: 600; color: var(--blue); text-transform: uppercase; letter-spacing: .3px; }
    .current-info { font-size: 13.5px; color: #111; margin-top: .15rem; }

    .form-card { background: white; border-radius: 18px; border: 0.5px solid #e5e7eb; padding: 2rem; }
    .step-label { display: flex; align-items: center; gap: .5rem; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; margin-bottom: .6rem; }
    .form-field { margin-bottom: 1.4rem; }
    .form-input { width: 100%; padding: .75rem 1rem .75rem 2.6rem; background: #f9fafb; border: 0.5px solid #e5e7eb; border-radius: 10px; font-size: 13.5px; color: #111; outline: none; transition: border .18s, box-shadow .18s; font-family: 'DM Sans', sans-serif; }
    .form-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px var(--blue-light); }
    .inp-wrap { position: relative; display: flex; align-items: center; }
    .inp-ico { position: absolute; left: 12px; width: 16px; height: 16px; opacity: .4; pointer-events: none; }

    .slots-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .45rem; }
    .slot-btn { padding: .6rem .25rem; border-radius: 9px; font-size: 12.5px; font-weight: 500; border: 0.5px solid #e5e7eb; background: #f9fafb; color: #374151; cursor: pointer; transition: all .18s; font-family: 'DM Sans', sans-serif; text-align: center; }
    .slot-btn:hover { border-color: var(--blue); color: var(--blue); background: #fff; }
    .slot-btn.selected { background: linear-gradient(135deg, var(--blue), var(--blue-dark)); color: white; border-color: var(--blue); box-shadow: 0 0 0 3px var(--blue-light); }

    .form-textarea { width: 100%; padding: .75rem 1rem; background: #f9fafb; border: 0.5px solid #e5e7eb; border-radius: 10px; font-size: 13.5px; color: #111; outline: none; resize: none; font-family: 'DM Sans', sans-serif; transition: border .18s, box-shadow .18s; }
    .form-textarea:focus { border-color: var(--blue); box-shadow: 0 0 0 3px var(--blue-light); }

    .alert-err { background: #fef2f2; border: 0.5px solid #fca5a5; border-radius: 10px; padding: .7rem 1rem; font-size: 13px; color: #dc2626; margin-bottom: 1.2rem; }
    .field-err { font-size: 12px; color: #dc2626; margin-top: .3rem; display: block; }

    .btn-primary { width: 100%; padding: .85rem; border-radius: 10px; border: none; background: linear-gradient(135deg, var(--blue), var(--blue-dark)); color: #fff; font-size: 14.5px; font-weight: 500; cursor: pointer; transition: transform .15s, box-shadow .15s; font-family: 'DM Sans', sans-serif; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px #1976D240; }
    .btn-secondary { display: block; width: 100%; padding: .8rem; border-radius: 10px; border: 0.5px solid #e5e7eb; background: transparent; color: #374151; font-size: 14px; font-weight: 500; text-align: center; text-decoration: none; transition: background .15s; font-family: 'DM Sans', sans-serif; margin-top: .75rem; }
    .btn-secondary:hover { background: #f9fafb; }

    /* Dark mode */
    .dark .rdv-page { background: #111827; }
    .dark .page-title { color: #f9fafb; }
    .dark .page-sub, .dark .page-back { color: #9ca3af; }
    .dark .current-rdv { background: #1976D210; border-color: #1976D230; }
    .dark .current-info { color: #f9fafb; }
    .dark .current-sub { color: #9ca3af; }
    .dark .form-card { background: #1f2937; border-color: #374151; }
    .dark .step-label { color: #9ca3af; }
    .dark .form-input, .dark .form-textarea { background: #111827; border-color: #374151; color: #f9fafb; }
    .dark .inp-ico { opacity: .45; filter: invert(1); }
    .dark .slot-btn { background: #111827; border-color: #374151; color: #d1d5db; }
    .dark .slot-btn:hover { border-color: var(--blue); color: #1E88E5; background: #1f2937; }
    .dark .slot-btn.selected { background: linear-gradient(135deg, var(--blue), var(--blue-dark)); color: white; }
    .dark .btn-secondary { border-color: #374151; color: #d1d5db; }
    .dark .btn-secondary:hover { background: #111827; }
    .dark .alert-err { background: rgba(220,38,38,.1); border-color: rgba(248,113,113,.3); color: #f87171; }
    .dark .field-err { color: #f87171; }
</style>

<div class="rdv-page">
<div class="rdv-wrap">

    <a href="{{ route('dashboard') }}" class="page-back">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Retour à mes rendez-vous
    </a>
    <h1 class="page-title">Modifier le rendez-vous</h1>
    <p class="page-sub">Changez le créneau ou le motif de votre consultation</p>

    @php $dt = \Carbon\Carbon::parse($appointment->appointment_date); @endphp

    <div class="current-rdv">
        <div class="current-day">{{ $dt->format('d') }}</div>
        <div>
            <div class="current-label">RDV actuel</div>
            <div class="current-info">Dr. {{ $appointment->doctor->name }} — {{ $dt->translatedFormat('d F Y') }} à {{ $dt->format('H:i') }}</div>
        </div>
    </div>

    <div class="form-card">

        @if($errors->any())
            <div class="alert-err">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('rdv.update', $appointment) }}">
            @csrf @method('PATCH')

            {{-- Nouvelle date --}}
            <div class="form-field">
                <div class="step-label">Nouvelle date</div>
                <div class="inp-wrap">
                    <svg class="inp-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <input type="date" name="date" required
                           value="{{ old('date', $date) }}"
                           min="{{ now()->format('Y-m-d') }}"
                           class="form-input">
                </div>
                @error('date')<span class="field-err">{{ $message }}</span>@enderror
            </div>

            {{-- Nouveau créneau --}}
            <div class="form-field">
                <div class="step-label">Nouveau créneau horaire</div>
                <input type="hidden" name="heure" id="heure-hidden" value="{{ old('heure', $dt->format('H:i')) }}">
                <div class="slots-grid" id="creneaux-grid">
                    @forelse($creneauxDisponibles as $c)
                        @php $selected = old('heure', $dt->format('H:i')) === $c; @endphp
                        <button type="button"
                                onclick="selectCreneau(this, '{{ $c }}')"
                                class="slot-btn {{ $selected ? 'selected' : '' }}">
                            {{ $c }}
                        </button>
                    @empty
                        <p style="grid-column:span 4; font-size:13px; color:var(--purple,#9ca3af); opacity:.7; font-style:italic;">Aucun créneau disponible.</p>
                    @endforelse
                </div>
                @error('heure')<span class="field-err">{{ $message }}</span>@enderror
            </div>

            {{-- Motif --}}
            <div class="form-field">
                <div class="step-label">Motif de consultation</div>
                <textarea name="reason" rows="3" required maxlength="500"
                          class="form-textarea"
                          placeholder="Motif de votre consultation...">{{ old('reason', $appointment->reason) }}</textarea>
                @error('reason')<span class="field-err">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Annuler — retour sans modifier</a>
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
</script>
</x-app-layout>
