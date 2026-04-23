<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CabinetMédical — Votre santé, notre priorité</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #FFFFFF; color: #0D47A1; }

        /* NAVBAR */
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #E3F2FD;
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-logo { font-size: 22px; font-weight: 800; text-decoration: none; letter-spacing: -0.5px; }
        .navbar-logo .blue-dark { color: #0D47A1; } 
        .navbar-logo .blue-light { color: #1E88E5; } 
        
        .navbar-links { display: flex; gap: 14px; align-items: center; }
        .btn-login {
            padding: 9px 22px; border: 1px solid #BBDEFB; border-radius: 12px;
            text-decoration: none; font-size: 14px; font-weight: 600;
            color: #1565C0; background: white; transition: all 0.2s;
        }
        .btn-login:hover { background: #F1F8FE; border-color: #1E88E5; }
        
        .btn-register {
            padding: 10px 22px; border-radius: 12px; text-decoration: none;
            font-size: 14px; font-weight: 600; color: white;
            background: linear-gradient(135deg, #0D47A1, #1976D2); 
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(13, 71, 161, 0.2);
        }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 6px 15px rgba(13, 71, 161, 0.3); }

        /* HERO SECTION */
        .hero { max-width: 1000px; margin: 100px auto 80px; text-align: center; padding: 0 2rem; }
        .hero-badge {
            display: inline-block; background: #E3F2FD; color: #0D47A1;
            font-size: 13px; font-weight: 700; padding: 7px 18px;
            border-radius: 25px; margin-bottom: 24px; border: 1px solid #90CAF9;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .hero h1 { font-size: 56px; font-weight: 800; color: #0D47A1; line-height: 1.1; margin-bottom: 24px; letter-spacing: -1.5px; }
        .hero h1 span { 
            background: linear-gradient(to right, #1565C0, #2196F3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p { font-size: 19px; color: #475569; line-height: 1.6; max-width: 650px; margin: 0 auto 40px; }
        
        .hero-btns { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
        .btn-primary {
            padding: 16px 36px; background: #1976D2; color: white;
            border-radius: 14px; text-decoration: none; font-size: 16px;
            font-weight: 700; transition: all 0.3s;
            box-shadow: 0 10px 20px -5px rgba(25, 118, 210, 0.4);
        }
        .btn-primary:hover { background: #0D47A1; transform: scale(1.02); }
        
        .btn-secondary {
            padding: 16px 36px; background: white; color: #1565C0;
            border: 2px solid #E3F2FD; border-radius: 14px; text-decoration: none;
            font-size: 16px; font-weight: 700; transition: all 0.2s;
        }
        .btn-secondary:hover { background: #F8FAFC; border-color: #90CAF9; }

        /* STATS */
        .stats {
            display: flex; justify-content: space-around; gap: 20px; max-width: 850px;
            margin: 0 auto 100px; padding: 40px 2rem; background: #fff;
            border-radius: 30px; border: 1px solid #E3F2FD;
            box-shadow: 0 20px 50px rgba(13, 71, 161, 0.05);
        }
        .stat-number { font-size: 38px; font-weight: 800; color: #2196F3; }
        .stat-label { font-size: 14px; color: #64748B; font-weight: 600; text-transform: uppercase; margin-top: 5px; }

        /* FEATURES */
        .features { max-width: 1200px; margin: 0 auto 100px; padding: 0 2rem; }
        .features-title { text-align: center; font-size: 36px; font-weight: 800; color: #0D47A1; margin-bottom: 12px; }
        .features-sub { text-align: center; font-size: 16px; color: #64748B; margin-bottom: 50px; }
        
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; }
        .feature-card { 
            background: white; border: 1px solid #F1F5F9; border-radius: 24px; padding: 35px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .feature-card:hover { transform: translateY(-5px); border-color: #90CAF9; box-shadow: 0 15px 30px rgba(21, 101, 192, 0.05); }
        
        .feature-icon { 
            width: 56px; height: 56px; border-radius: 16px; 
            display: flex; align-items: center; justify-content: center; 
            margin-bottom: 20px; font-size: 26px;
        }

        /* ROLES SECTION */
        .roles { background: #F0F7FF; padding: 80px 2rem; margin-bottom: 80px; border-radius: 50px; margin-left: 20px; margin-right: 20px;}
        .roles-inner { max-width: 1000px; margin: 0 auto; }
        .roles-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .role-card { 
            background: white; border-radius: 24px; padding: 30px 20px; text-align: center; 
            border: 2px solid transparent; transition: all 0.3s;
        }
        .role-card:hover { border-color: #1E88E5; transform: scale(1.03); }
        .role-icon { font-size: 35px; margin-bottom: 15px; }
        .role-card h4 { font-size: 17px; font-weight: 700; margin-bottom: 8px; color: #0D47A1; }
        .role-card p { font-size: 13px; color: #64748B; line-height: 1.5; }

        /* DOCTORS COMPACT SECTION */
        .doctors-section { max-width: 1000px; margin: 60px auto 100px; padding: 0 2rem; }
        .doctor-card {
            background: white; border: 1px solid #E3F2FD; padding: 12px; 
            border-radius: 20px; display: flex; align-items: center; gap: 12px; 
            transition: 0.3s; box-shadow: 0 4px 15px rgba(13, 71, 161, 0.03);
        }
        .doctor-card:hover { border-color: #1E88E5; transform: translateX(5px); }
        .doctor-img { width: 50px; height: 50px; border-radius: 15px; object-fit: cover; border: 2px solid #90CAF9; }
        .doctor-placeholder { width: 50px; height: 50px; border-radius: 15px; background: #E3F2FD; color: #1565C0; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 800; border: 2px solid #90CAF9; }
        .doctor-info h4 { font-size: 15px; font-weight: 700; color: #0D47A1; margin: 0; }
        .doctor-info p { font-size: 12px; color: #1976D2; font-weight: 600; margin: 2px 0 0; }

        /* CTA */
        .cta { max-width: 800px; margin: 0 auto 100px; text-align: center; padding: 60px 2rem; background: linear-gradient(135deg, #0D47A1, #1976D2); border-radius: 40px; color: white; }
        .cta h2 { font-size: 36px; font-weight: 800; margin-bottom: 15px; }
        .cta p { font-size: 18px; margin-bottom: 35px; opacity: 0.9; }
        .cta .btn-white { padding: 16px 40px; background: white; color: #0D47A1; border-radius: 15px; text-decoration: none; font-weight: 700; transition: 0.2s; }
        .cta .btn-white:hover { background: #E3F2FD; transform: scale(1.05); }

        .footer { padding: 40px 2rem; text-align: center; color: #94A3B8; font-size: 14px; border-top: 1px solid #F1F5F9; }
        .footer span { color: #1565C0; font-weight: 700; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="/" class="navbar-logo">
            <span class="blue-dark">Cabinet</span><span class="blue-light">Médical</span>
        </a>
        <div class="navbar-links">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">Mon Espace</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-register" style="border:none;cursor:pointer;">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-register">Rejoignez-nous</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-badge">✨ Excellence & Technologie Médicale</div>
        <h1>Votre santé mérite<br><span>le meilleur suivi</span></h1>
        <p>Une plateforme moderne pour simplifier vos rendez-vous, centraliser votre historique médical et faciliter la communication avec vos praticiens.</p>

        <div class="hero-btns">
            @guest
                <a href="{{ route('register') }}" class="btn-primary">Créer mon compte patient</a>
                <a href="#features" class="btn-secondary">Découvrir les services</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-primary">Accéder à mon tableau de bord</a>
            @endguest
        </div>
    </section>

    <!-- STATS -->
    <div class="stats">
        <div class="stat">
            <div class="stat-number">2k+</div>
            <div class="stat-label">Patients</div>
        </div>
        <div class="stat">
            <div class="stat-number">15+</div>
            <div class="stat-label">Spécialistes</div>
        </div>
        <div class="stat">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Disponibilité</div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features" id="features">
        <h2 class="features-title">L'innovation au service du patient</h2>
        <p class="features-sub">Des outils conçus pour une gestion fluide et sécurisée</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background:#E3F2FD; color:#1565C0;">📅</div>
                <h3>Gestion des RDV</h3>
                <p>Planifiez vos consultations en temps réel avec une confirmation instantanée par email.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:#E1F5FE; color:#0288D1;">🧬</div>
                <h3>Suivi Médical</h3>
                <p>Un historique complet de vos diagnostics, vaccins et constantes vitales à portée de main.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background:#F0F7FF; color:#1976D2;">📜</div>
                <h3>Ordonnances Digitales</h3>
                <p>Récupérez et téléchargez vos prescriptions médicales directement en format PDF sécurisé.</p>
            </div>
        </div>
    </section>

    <!-- DOCTORS (VERSION COMPACTE) -->
    <section class="doctors-section">
        <h2 class="features-title" style="font-size: 24px; margin-bottom: 30px;">Nos Spécialistes</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;">
            @forelse($medecins as $medecin)
                <div class="doctor-card">
                    @if($medecin->profile_photo)
                        <img src="{{ asset('storage/' . $medecin->profile_photo) }}" class="doctor-img">
                    @else
                        <div class="doctor-placeholder">{{ strtoupper(substr($medecin->name, 0, 1)) }}</div>
                    @endif
                    <div class="doctor-info">
                        <h4>Dr. {{ $medecin->name }}</h4>
                        <p>{{ $medecin->specialite ?? 'Généraliste' }}</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #94A3B8; font-size: 14px; grid-column: 1/-1;">L'équipe médicale sera bientôt disponible.</p>
            @endforelse
        </div>
    </section>

    <!-- ROLES -->
    <section class="roles">
        <div class="roles-inner">
            <h2 class="features-title">Un espace pour chaque acteur</h2>
            <div class="roles-grid">
                <div class="role-card">
                    <div class="role-icon">🩺</div>
                    <h4>Médecins</h4>
                    <p>Tableau de bord clinique et gestion des ordonnances</p>
                </div>
                <div class="role-card">
                    <div class="role-icon">📑</div>
                    <h4>Secrétariat</h4>
                    <p>Optimisation du planning et accueil administratif</p>
                </div>
                <div class="role-card">
                    <div class="role-icon">👤</div>
                    <h4>Patients</h4>
                    <p>Réservation simple et accès au dossier santé</p>
                </div>
            </div>
        </div>
    </section>

    @guest
    <section class="cta">
        <h2>Prêt à franchir le pas ?</h2>
        <p>Rejoignez la communauté de notre clinique et bénéficiez d'un suivi personnalisé dès aujourd'hui.</p>
        <a href="{{ route('register') }}" class="btn-white">Ouvrir un compte</a>
    </section>
    @endguest

    <footer class="footer">
        <p>&copy; {{ date('Y') }} — <span>CabinetMédical</span>. Tous droits réservés.</p>
    </footer>

</body>
</html>