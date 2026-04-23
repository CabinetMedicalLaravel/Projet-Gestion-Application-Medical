<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cabinet Médical — @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #ffffff; color: #1a2632; }

        /* TOPNAV */
        .topnav {
            background: linear-gradient(90deg, #0277bd 0%, #01579b 100%);
            display: flex; align-items: center;
            padding: 0 24px; height: 56px; gap: 8px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 12px rgba(2,119,189,0.2);
        }
        .topnav-logo {
            display: flex; align-items: center; gap: 10px;
            padding-right: 20px; border-right: 1px solid rgba(255,255,255,0.2);
            margin-right: 8px; flex-shrink: 0;
        }
        .topnav-logo .logo-icon {
            width: 32px; height: 32px; background: rgba(255,255,255,0.2);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }
        .topnav-logo .logo-icon i { color: #fff; font-size: 16px; }
        .topnav-logo span { font-size: 13px; font-weight: 700; color: #fff; }
        .topnav-logo small { display: block; font-size: 10px; color: rgba(255,255,255,0.6); }
        .topnav-links { display: flex; align-items: center; gap: 2px; flex: 1; }
        .topnav-links a {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 13px; border-radius: 8px;
            color: rgba(255,255,255,0.75); text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all .15s; white-space: nowrap;
        }
        .topnav-links a i { font-size: 14px; }
        .topnav-links a:hover { background: rgba(255,255,255,0.15); color: #fff; }
        .topnav-links a.active { background: rgba(255,255,255,0.2); color: #fff; font-weight: 700; }
        .topnav-user { display: flex; align-items: center; gap: 10px; margin-left: auto; flex-shrink: 0; }
        .topnav-user .avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.2); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px;
        }
        .topnav-user .user-info span { display: block; font-size: 12px; font-weight: 600; color: #fff; }
        .topnav-user .user-info small { font-size: 10px; color: rgba(255,255,255,0.6); }
        .logout-btn-top {
            background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px; padding: 5px 11px; font-size: 12px;
            color: rgba(255,255,255,0.85); cursor: pointer;
            display: flex; align-items: center; gap: 5px; transition: all .15s;
        }
        .logout-btn-top:hover { background: rgba(255,255,255,0.22); color: #fff; }

        /* SOUS-BARRE */
        .subbar {
            background: #fff; border-bottom: 1px solid #e8f4fd;
            padding: 10px 28px; display: flex; align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 4px rgba(3,169,244,0.05);
        }
        .topbar-breadcrumb { font-size: 13px; color: #90a4ae; }
        .topbar-breadcrumb span { color: #0277bd; font-weight: 700; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .topbar-btn {
            width: 36px; height: 36px; border-radius: 10px;
            border: 1px solid #e8f0fe; background: #f8f9ff;
            display: flex; align-items: center; justify-content: center;
            color: #0288d1; cursor: pointer; position: relative; transition: all .15s;
        }
        .topbar-btn:hover { background: #e8f4fd; }
        .notif-dot {
            width: 7px; height: 7px; background: #e74c3c;
            border-radius: 50%; position: absolute; top: 6px; right: 6px;
        }

        /* CONTENU */
        .page-content { padding: 28px; min-height: calc(100vh - 88px); background: #ffffff; }

        /* CARDS */
        .stat-card {
            background: #fff; border-radius: 16px; padding: 22px;
            border: 1px solid #e8f0fe; box-shadow: 0 2px 12px rgba(3,169,244,0.06);
        }
        .stat-number { font-size: 30px; font-weight: 800; color: #0277bd; margin-top: 4px; }
        .card-section {
            background: #fff; border-radius: 16px; padding: 24px;
            border: 1px solid #e8f0fe; box-shadow: 0 2px 12px rgba(3,169,244,0.06);
        }

        /* BUTTONS */
        .btn-primary-cm {
            background: linear-gradient(135deg, #03a9f4, #0288d1); color: #fff;
            border: none; border-radius: 10px; padding: 9px 18px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none; transition: all .2s;
            box-shadow: 0 4px 12px rgba(3,169,244,0.25);
        }
        .btn-primary-cm:hover { background: linear-gradient(135deg, #0288d1, #01579b); color: #fff; transform: translateY(-1px); }
        .btn-secondary-cm {
            background: #f0faff; color: #0288d1; border: 1px solid #b3e5fc;
            border-radius: 10px; padding: 9px 18px; font-size: 13px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none; transition: all .15s;
        }
        .btn-secondary-cm:hover { background: #e0f4ff; color: #0277bd; }
        .btn-danger-cm {
            background: #fef2f2; color: #e74c3c; border: 1px solid #fecaca;
            border-radius: 10px; padding: 6px 14px; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
        }
        .btn-danger-cm:hover { background: #fee2e2; }
        .btn-edit-cm {
            background: #f0faff; color: #0288d1; border: 1px solid #b3e5fc;
            border-radius: 10px; padding: 6px 14px; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
        }
        .btn-edit-cm:hover { background: #e0f4ff; }

        /* FORMS */
        .form-label-cm {
            font-size: 12px; font-weight: 700; color: #0277bd; margin-bottom: 6px;
            display: block; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-input-cm {
            width: 100%; padding: 10px 14px; border: 2px solid #e8f0fe;
            border-radius: 10px; font-size: 13.5px; color: #1a2632;
            background: #f8f9ff; outline: none; transition: border .15s;
        }
        .form-input-cm:focus { border-color: #03a9f4; box-shadow: 0 0 0 3px rgba(3,169,244,.12); background: #fff; }
        .form-input-cm::placeholder { color: #b0bec5; }

        /* TABLE */
        .cm-table { width: 100%; border-collapse: collapse; }
        .cm-table thead th {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.6px; color: #0288d1; padding: 12px 16px;
            border-bottom: 2px solid #e8f0fe; background: #f8f9ff;
        }
        .cm-table tbody tr { border-bottom: 1px solid #f0f4ff; transition: background .1s; }
        .cm-table tbody tr:hover { background: #f8f9ff; }
        .cm-table tbody td { padding: 14px 16px; font-size: 13.5px; color: #374151; vertical-align: middle; }

        /* BADGES */
        .badge-patient { background: #e0f4ff; color: #0288d1; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .patient-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #03a9f4, #0288d1); color: #fff;
            font-weight: 700; font-size: 13px;
            display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        /* ALERTS */
        .alert-cm { padding: 12px 16px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success-cm { background: #e0f4ff; color: #0277bd; border: 1px solid #b3e5fc; }
        .alert-error-cm { background: #fef2f2; color: #e74c3c; border: 1px solid #fecaca; }

        /* PAGINATION */
        .page-link { border-radius: 8px !important; margin: 0 2px; font-size: 13px; color: #0288d1; border-color: #b3e5fc; }
        .page-item.active .page-link { background: #0288d1; border-color: #0288d1; }
    </style>
    @yield('styles')
</head>
<body>

<!-- TOPNAV HORIZONTAL -->
<nav class="topnav">
    <div class="topnav-logo">
        <div class=""><i class=""></i></div>
        <div><span>Cabinet Médical</span><small>Gestion</small></div>
    </div>

    <div class="topnav-links">
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Tableau de bord
                </a>
            @elseif(Auth::user()->role === 'secretaire')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('secretaire.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Tableau de bord
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Tableau de bord
                </a>
            @endif
        @endauth

        <a href="{{ route('patients.index') }}"class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">
             <i class="bi bi-people"></i> Patients
        </a>

        <a href="{{ route('patients.create') }}"class="{{ request()->routeIs('patients.create') ? 'active' : '' }}">
            <i class="bi bi-person-plus"></i> Créer patient
        </a>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> Utilisateurs
                </a>
                <a href="{{ route('admin.creneaux') }}" class="{{ request()->routeIs('admin.creneaux*') ? 'active' : '' }}">
                    <i class="bi bi-calendar3"></i> Créneaux
                </a>
            @endif
        @endauth
    </div>

    <div class="topnav-user">
        @auth
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-info">
            <span>{{ Auth::user()->name }}</span>
            <small>{{ ucfirst(Auth::user()->role ?? 'Utilisateur') }}</small>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="logout-btn-top">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
        @endauth
    </div>
</nav>

<!-- SOUS-BARRE BREADCRUMB -->
<div class="subbar">
    <div class="topbar-breadcrumb">Cabinet Médical &rsaquo; <span>@yield('title')</span></div>
    <div class="topbar-right">
        <div class="topbar-btn">
            <i class="bi bi-bell" style="font-size:15px;"></i>
            <span class="notif-dot"></span>
        </div>
        <div class="topbar-btn">
            <i class="bi bi-gear" style="font-size:15px;"></i>
        </div>
    </div>
</div>

<!-- CONTENU -->
<div class="page-content">
    @if(session('success'))
        <div class="alert-cm alert-success-cm">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-cm alert-error-cm">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>