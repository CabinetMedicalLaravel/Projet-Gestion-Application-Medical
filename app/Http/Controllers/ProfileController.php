<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**

     * Afficher le formulaire de profil de l'utilisateur.

     * Display the user's profile form.

     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**

     * Mettre à jour les informations du profil.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Validation de tous les champs (y compris téléphone et spécialité)
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'telephone'     => ['nullable', 'string', 'max:20'],
            'specialite'    => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2Mo
        ]);

        // 2. Gestion de l'upload de la photo de profil
        if ($request->hasFile('profile_photo')) {
            // Supprimer l'ancienne photo si elle existe pour libérer de l'espace
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Stocker la nouvelle photo dans le dossier 'avatars' (disque public)
            $path = $request->file('profile_photo')->store('avatars', 'public');
            $user->profile_photo = $path;
        }

        // 3. Mise à jour des autres champs
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;

        // On ne met à jour la spécialité que si l'utilisateur est un médecin
        if ($user->role === 'medecin') {
            $user->specialite = $request->specialite;
        }

        // 4. Si l'email a changé, on réinitialise la vérification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 5. Sauvegarde finale
        $user->save();


        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**

     * Supprimer le compte de l'utilisateur.

     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();


        // Supprimer la photo de profil du stockage avant de supprimer le compte
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }


        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
