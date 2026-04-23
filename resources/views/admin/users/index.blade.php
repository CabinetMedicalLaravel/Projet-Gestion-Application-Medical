@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-size:22px;font-weight:700;color:#1a2632;">Gestion des utilisateurs</h2>
    <a href="{{ route('admin.users.create') }}" class="btn-primary-cm">
        <i class="bi bi-person-plus"></i> Nouvel utilisateur
    </a>
</div>

{{-- Filtres --}}
<div class="mb-3 d-flex gap-2">
    <a href="{{ route('admin.users') }}" class="btn-{{ $role == 'all' ? 'primary' : 'secondary' }}-cm">Tous</a>
    <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="btn-{{ $role == 'admin' ? 'primary' : 'secondary' }}-cm">Admin</a>
    <a href="{{ route('admin.users', ['role' => 'medecin']) }}" class="btn-{{ $role == 'medecin' ? 'primary' : 'secondary' }}-cm">Médecin</a>
    <a href="{{ route('admin.users', ['role' => 'patient']) }}" class="btn-{{ $role == 'patient' ? 'primary' : 'secondary' }}-cm">Patient</a>
    <a href="{{ route('admin.users', ['role' => 'secretaire']) }}" class="btn-{{ $role == 'secretaire' ? 'primary' : 'secondary' }}-cm">Secrétaire</a>
</div>

{{-- Tableau --}}
<div class="card-section">
    <table class="cm-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="color:#b0bec5;font-size:12px;">{{ $user->id }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div class="patient-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <span style="font-weight:600;">{{ $user->name }}</span>
                    </div>
                </td>
                <td style="color:#5f6b7a;">{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span style="background:#fef2f2;color:#e74c3c;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Admin</span>
                    @elseif($user->role == 'medecin')
                        <span style="background:#eff6ff;color:#3b82f6;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Médecin</span>
                    @elseif($user->role == 'patient')
                        <span class="badge-patient">Patient</span>
                    @elseif($user->role == 'secretaire')
                        <span style="background:#fef9c3;color:#ca8a04;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">Secrétaire</span>
                    @else
                        <span style="background:#f4f6f9;color:#7f8c8d;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">—</span>
                    @endif
                </td>
                <td style="color:#7f8c8d;font-size:13px;">{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;color:#b0bec5;padding:40px;">Aucun utilisateur trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div style="margin-top:20px;">
        {{ $users->links() }}
    </div>
</div>

@endsection