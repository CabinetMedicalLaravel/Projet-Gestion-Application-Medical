<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f4ff 0%, #b3e5fc 50%, #e0f4ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .card-form {
            background: #fff;
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 60px rgba(3, 169, 244, 0.15);
            border: 1px solid #e0f4ff;
        }
        .logo-circle {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #03a9f4, #0288d1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo-circle i { color: #fff; font-size: 24px; }
        h2 { font-size: 22px; font-weight: 800; color: #0277bd; margin-bottom: 4px; }
        .subtitle { font-size: 12px; color: #90a4ae; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 32px; }
        .form-label {
            font-size: 11px;
            font-weight: 700;
            color: #0277bd;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        .form-control, .form-select {
            border: 2px solid #e0f4ff;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            background: #f8fdff;
            color: #1a2632;
            transition: all .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #03a9f4;
            box-shadow: 0 0 0 4px rgba(3,169,244,0.1);
            background: #fff;
        }
        .form-control::placeholder { color: #b0bec5; }
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #03a9f4, #0288d1);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            margin-top: 8px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #0288d1, #01579b);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(3,169,244,0.3);
        }
        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 14px;
            font-size: 13px;
            color: #90a4ae;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-cancel:hover { color: #0277bd; }
        .divider { height: 1px; background: #e0f4ff; margin: 24px 0; }
    </style>
</head>
<body>

<div class="card-form">

    <div class="logo-circle">
        <i class="bi bi-person-plus"></i>
    </div>

    <h2>Ajouter un membre</h2>
    <p class="subtitle">Nouveau compte utilisateur</p>

    @if($errors->any())
        <div style="background:#fef2f2;color:#e74c3c;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;font-size:13px;margin-bottom:20px;">
            <i class="bi bi-exclamation-circle"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom complet</label>
            <input type="text" name="name" class="form-control" placeholder="Ex: Dr. Ahmed Benali" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse Email</label>
            <input type="email" name="email" class="form-control" placeholder="exemple@email.com" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rôle</label>
            <select name="role" class="form-select">
                <option value="medecin">🩺 Médecin</option>
                <option value="secretaire">👩‍💼 Secrétaire</option>
                <option value="patient">🧑‍⚕️ Patient</option>
                <option value="admin">🔐 Administrateur</option>
            </select>
        </div>

        <div class="divider"></div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-check-circle"></i> Enregistrer le compte
        </button>

        <a href="{{ route('admin.users') }}" class="btn-cancel">
            ← Annuler et retourner à la liste
        </a>

    </form>

</div>

</body>
</html>