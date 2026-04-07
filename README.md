# 🏥 MediFlow - Système de Gestion Médicale

**MediFlow** est une application web développée avec Laravel pour digitaliser la gestion d'un cabinet médical. Elle permet la prise de rendez-vous, la gestion des dossiers patients et la coordination entre médecins et secrétaires.

##  Rôles et Accès
L'application gère trois types d'utilisateurs avec des accès spécifiques :
- **Médecin :** Accès au tableau de bord médical, statistiques et consultations.
- **Secrétaire :** Gestion du planning, accueil des patients et rendez-vous.
- **Patient :** Consultation de l'historique et prise de rendez-vous.

---

##  Installation (Pour l'équipe)

Suivez ces étapes pour installer le projet sur votre machine locale :

1. **Cloner le projet :**
   ```bash
   ****git clone https://github.com/CabinetMedicalLaravel/Projet-Gestion-Application-Medical.git
   cd Projet-Gestion-Application-Medical***

   
Installer les dépendances :
composer install
npm install && npm run build

Configurer l'environnement :
Copiez le fichier .env.example vers .env :

cp .env.example .env
Générez la clé d'application :
php artisan key:generate
Configurez votre base de données dans le fichier .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
Lancer les migrations :
(Important pour avoir les colonnes Rôle et Téléphone)

php artisan migrate
📧 Vérification d'Email & Tests
Pour faciliter le développement, l'envoi d'emails est configuré en mode LOG.
Inscription : Lors de l'inscription, Laravel vous demandera de vérifier votre email.
Récupérer le lien : Ne cherchez pas dans votre vraie boîte mail. Ouvrez le fichier suivant :
👉 storage/logs/laravel.log
Valider : Copiez le lien de vérification à la fin du fichier et collez-le dans votre navigateur.
🛠 Technologies utilisées
Framework : Laravel 11
Base de données : MySQL
Frontend : Tailwind CSS / Blade
Gestion de projet : Jira & GitHub Integration
📝 Règles de Contribution (Git & Jira)
Pour que votre travail soit lié automatiquement à Jira, commencez vos messages de commit par la clé du ticket :
Exemple : git commit -m "SCRUM-10: Ajout de la validation du téléphone"
Ne travaillez jamais directement sur main. Créez une branche :
git checkout -b feature/votre-nom-sujet

---

### Pourquoi c'est mieux de faire ça
1.  **Pour Jira :** Ton projet aura une allure de vrai projet de développement logiciel.


