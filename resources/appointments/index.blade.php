<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Rendez-vous') }}
            </h2>
            @if(Auth::user()->role === 'patient')
                <a href="{{ route('appointments.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    + Nouveau Rendez-vous
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date & Heure</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Médecin / Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Motif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($appointments as $app)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $app->appointment_date->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ Auth::user()->role === 'patient' ? $app->doctor->name : $app->patient->name }}
                                </td>
                                <td class="px-6 py-4">{{ $app->reason }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $app->status === 'confirme' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $app->status === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $app->status === 'annule' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($app->status === 'en_attente' || $app->status === 'confirme')
                                        <form action="{{ route('appointments.update-status', $app) }}" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr ?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="annule">
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 font-medium">Annuler</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">Aucun rendez-vous trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>