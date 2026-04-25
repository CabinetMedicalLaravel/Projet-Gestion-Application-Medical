<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'all');
        $query = User::query();
        
        if ($role != 'all') {
            $query->where('role', $role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users', 'role'));
    }
    
    public function create()
    {
        return view('admin.users.form');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:medecin,secretaire,patient',
            'telephone' => 'nullable|string|max:20',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();
        
        User::create($validated);
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }
    
    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => 'required|in:medecin,secretaire,patient',
            'telephone' => 'nullable|string|max:20',
        ]);
        
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'telephone' => $validated['telephone'] ?? null,
        ];
        
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }
        
        $user->update($updateData);
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour.');
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé.');
    }
}
