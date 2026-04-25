<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Les codes d'accès secrets par rôle.
     */
    private function getAccessCodes(): array
    {
        return [
            'medecin'    => env('ACCESS_CODE_MEDECIN', 'MEDECIN2026'),
            'secretaire' => env('ACCESS_CODE_SECRETAIRE', 'SECRETAIRE2026'),
            'admin'      => env('ACCESS_CODE_ADMIN', 'ADMIN2026'),
        ];
    }

    /**
     * Afficher la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traiter la demande d'inscription.

     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Normaliser l'email avant la validation
        $request->merge(['email' => strtolower($request->email)]);

        // ── 1. Validation ────────────────────────────────────────────────────
        $isPatient = $request->input('role', 'patient') === 'patient';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'in:patient,staff'],
            'access_code' => ['nullable', 'string', 'max:100'],
            'indicatif' => ['nullable', 'string', 'max:5'],
            'telephone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9\s\-\.]+$/',
            ],
        ], [
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'telephone.regex' => 'Le numéro de téléphone ne doit contenir que des chiffres.',
            'telephone.max' => 'Le numéro de téléphone est trop long.',
        ]);

        // ── 2. Détermination du rôle ─────────────────────────────────────────
        $role = 'patient';

        $submittedRole = $request->input('role', 'patient');
        $submittedCode = trim($request->input('access_code', ''));

        if ($submittedRole === 'staff' && filled($submittedCode)) {
            $matched = false;
            $codes = $this->getAccessCodes();

            foreach ($codes as $roleName => $validCode) {
                if (strtoupper($submittedCode) === strtoupper($validCode)) {
                    $role = $roleName;
                    $matched = true;
                    break;
                }
            }


            if (!$matched) {

                return back()
                    ->withInput($request->except('password', 'password_confirmation', 'access_code'))
                    ->withErrors(['access_code' => 'Le code d\'accès est incorrect. Veuillez contacter l\'administrateur.']);
            }
        }

        // ── 3. Construction du numéro de téléphone complet ───────────────────
        $telephone = null;
        if ($request->filled('telephone')) {
            $indicatif = $request->input('indicatif', '+212');
            $numero = preg_replace('/\s+/', '', $request->input('telephone'));
            $telephone = $indicatif . $numero;
        }

        // ── 4. Création de l'utilisateur ─────────────────────────────────────
        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'telephone' => $telephone,
        ]);


        // ── AJOUTE CECI ICI ───────────────────────────────
        if ($role === 'secretaire') {
            \App\Models\Secretaire::create([
                'user_id' => $user->id,
                'numero_bureau' => 'Non défini', // Valeur par défaut
            ]);
        }
        // ─────────────────────────────────────────────────────────────────────────────
        try {
            event(new Registered($user));
        } catch (\Exception $e) {
            // On ignore l'erreur d'envoi d'email pour ne pas bloquer l'inscription
            \Log::error("Erreur d'envoi d'email de vérification : " . $e->getMessage());
        }

        Auth::login($user);

        // ── 6. Redirection avec vérification d'email ─────────────────────────
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return match ($role) {
            'medecin'    => redirect()->route('complete-profile.show'), 
            'secretaire' => redirect()->route('secretaire.dashboard'), 
            default      => redirect()->route('dashboard'),
        };
    }
}

