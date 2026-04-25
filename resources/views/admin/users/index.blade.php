<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion des Utilisateurs') }}
        </h2>
    </x-slot>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h2 style="font-size:22px; font-weight:700; color:#1a2632;" class="dark:text-blue-400">Liste des Utilisateurs</h2>
            <p style="font-size:13px; color:#7f8c8d;" class="dark:text-slate-400">Contrôle d'accès et gestion des rôles</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-6 py-2.5 bg-[#1976D2] text-white rounded-2xl font-bold text-sm hover:bg-[#0D47A1] transition-all shadow-md">
            <i class="bi bi-person-plus mr-1"></i> Nouvel utilisateur
        </a>
    </div>

    {{-- Filtres --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.users') }}" class="px-4 py-2 {{ $role == 'all' ? 'bg-[#1976D2] text-white' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700' }} rounded-xl font-bold text-xs transition-all shadow-sm">Tous</a>
        <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="px-4 py-2 {{ $role == 'admin' ? 'bg-[#1976D2] text-white' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700' }} rounded-xl font-bold text-xs transition-all shadow-sm">Administrateurs</a>
        <a href="{{ route('admin.users', ['role' => 'medecin']) }}" class="px-4 py-2 {{ $role == 'medecin' ? 'bg-[#1976D2] text-white' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700' }} rounded-xl font-bold text-xs transition-all shadow-sm">Médecins</a>
        <a href="{{ route('admin.users', ['role' => 'patient']) }}" class="px-4 py-2 {{ $role == 'patient' ? 'bg-[#1976D2] text-white' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700' }} rounded-xl font-bold text-xs transition-all shadow-sm">Patients</a>
        <a href="{{ route('admin.users', ['role' => 'secretaire']) }}" class="px-4 py-2 {{ $role == 'secretaire' ? 'bg-[#1976D2] text-white' : 'bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700' }} rounded-xl font-bold text-xs transition-all shadow-sm">Secrétaires</a>
    </div>

    {{-- Tableau --}}
    <div class="bg-white dark:bg-[#1e293b] rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-slate-700">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#0f172a]">
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">ID</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Identité</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Rôle</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date Création</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-slate-800">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/30 transition-colors">
                    <td class="px-6 py-4 text-xs font-bold text-gray-400">#{{ $user->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-300 flex items-center justify-center font-black text-xs shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-black text-gray-900 dark:text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-500 dark:text-slate-400">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->role == 'admin')
                            <span class="px-3 py-1 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest">Admin</span>
                        @elseif($user->role == 'medecin')
                            <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black uppercase tracking-widest">Médecin</span>
                        @elseif($user->role == 'patient')
                            <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-widest">Patient</span>
                        @elseif($user->role == 'secretaire')
                            <span class="px-3 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-full text-[10px] font-black uppercase tracking-widest">Secrétaire</span>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-tighter">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-gray-200">
                                <i class="bi bi-people text-3xl"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-400">Aucun utilisateur trouvé pour ce filtre.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $users->links() }}
    </div>
</x-app-layout>