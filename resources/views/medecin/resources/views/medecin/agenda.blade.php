<x-app-layout>
    <div class="py-8 bg-white min-h-screen font-sans text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 mt-4 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">Mon agenda</h1>
                    <p class="text-gray-500 mt-1">Tous vos rendez-vous classés par date</p>
                </div>
                <a href="{{ route('rdv.planning') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    Vue planning
                </a>
            </div>

            {{-- Filtres --}}
            <div class="border border-gray-200 rounded-2xl p-5 mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label
                            class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Statut</label>
                        <select name="statut" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            <option value="">Tous</option>
                            <option value="en_attente" @selected(request('statut') === 'en_attente')>En attente</option>
                            <option value="confirme" @selected(request('statut') === 'confirme')>Confirmé</option>
                            <option value="termine" @selected(request('statut') === 'termine')>Terminé</option>
                            <option value="annule" @selected(request('statut') === 'annule')>Annulé</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Date</label>
                        <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    @if(request('statut') || request('date'))
                        <a href="{{ route('medecin.agenda') }}"
                            class="text-sm text-gray-400 hover:text-gray-600 underline self-end pb-2">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>

            {{-- Stats rapides --}}
            @php
                $filtres = $rdvs;
                if (request('statut'))
                    $filtres = $filtres->where('status', request('statut'));
                if (request('date'))
                    $filtres = $filtres->filter(fn($r) => \Carbon\Carbon::parse($r->appointment_date)->toDateString() === request('date'));
                $total = $filtres->count();
                $attente = $rdvs->where('status', 'en_attente')->count();
                $confirme = $rdvs->where('status', 'confirme')->count();
                $termine = $rdvs->where('status', 'termine')->count();
            @endphp

            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-[#F8F7F4] rounded-2xl p-5 text-center">
                    <p class="text-2xl font-semibold text-gray-900">{{ $rdvs->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total</p>
                </div>
                <div class="bg-yellow-50 rounded-2xl p-5 text-center">
                    <p class="text-2xl font-semibold text-yellow-700">{{ $attente }}</p>
                    <p class="text-xs text-yellow-600 mt-1">En attente</p>
                </div>
                <div class="bg-[#E6F6ED] rounded-2xl p-5 text-center">
                    <p class="text-2xl font-semibold text-green-700">{{ $confirme }}</p>
                    <p class="text-xs text-green-600 mt-1">Confirmés</p>
                </div>
                <div class="bg-blue-50 rounded-2xl p-5 text-center">
                    <p class="text-2xl font-semibold text-blue-700">{{ $termine }}</p>
                    <p class="text-xs text-blue-600 mt-1">Terminés</p>
                </div>
            </div>

            {{-- Liste --}}
            @if(session('success'))
                <div class="bg-[#E6F6ED] border border-green-200 text-green-700 rounded-xl p-4 mb-5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#F8F7F4] border-b border-gray-200">
                            <th
                                class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Date & heure</th>
                            <th
                                class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Patient</th>
                            <th
                                class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Motif</th>
                            <th
                                class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Statut</th>
                            <th
                                class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($filtres as $rdv)
                            @php
                                $dt = \Carbon\Carbon::parse($rdv->appointment_date);
                                $isToday = $dt->isToday();
                                $badges = [
                                    'en_attente' => 'bg-yellow-50 text-yellow-700',
                                    'confirme' => 'bg-[#E6F6ED] text-[#0A7B45]',
                                    'termine' => 'bg-blue-50 text-blue-700',
                                    'annule' => 'bg-gray-100 text-gray-500',
                                ];
                                $labels = ['en_attente' => 'En attente', 'confirme' => 'Confirmé', 'termine' => 'Terminé', 'annule' => 'Annulé'];
                            @endphp
                            <tr class="hover:bg-gray-50 transition {{ $isToday ? 'bg-blue-50/40' : '' }}">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-gray-900">
                                        {{ $dt->format('H:i') }}
                                        @if($isToday)
                                            <span
                                                class="ml-1 text-xs bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded-full font-medium">Aujourd'hui</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $dt->translatedFormat('d F Y') }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($rdv->patient->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $rdv->patient->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-gray-500 max-w-xs">
                                    {{ Str::limit($rdv->reason ?? '—', 50) }}
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex text-xs font-semibold px-2.5 py-1 rounded-full {{ $badges[$rdv->status] ?? 'bg-gray-100 text-gray-500' }}">
                                        {{ $labels[$rdv->status] ?? $rdv->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($rdv->status === 'en_attente')
                                            <form method="POST" action="{{ route('rdv.statut', $rdv) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="confirme">
                                                <button type="submit"
                                                    class="text-xs bg-[#E6F6ED] text-[#0A7B45] px-3 py-1.5 rounded-lg font-medium hover:bg-green-200 transition">
                                                    Confirmer
                                                </button>
                                            </form>
                                        @elseif($rdv->status === 'confirme')
                                            <form method="POST" action="{{ route('rdv.statut', $rdv) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="termine">
                                                <button type="submit"
                                                    class="text-xs bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg font-medium hover:bg-blue-100 transition">
                                                    Terminer
                                                </button>
                                            </form>
                                        @endif
                                        @if(in_array($rdv->status, ['en_attente', 'confirme']))
                                            <form method="POST" action="{{ route('rdv.statut', $rdv) }}"
                                                onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="annule">
                                                <button type="submit"
                                                    class="text-xs text-red-500 border border-red-200 px-3 py-1.5 rounded-lg font-medium hover:bg-red-50 transition">
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-16 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <path d="M16 2v4M8 2v4M3 10h18" />
                                    </svg>
                                    <p class="text-gray-400 font-medium">Aucun rendez-vous trouvé</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>