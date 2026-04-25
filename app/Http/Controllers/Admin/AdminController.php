<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function users(Request $request) {
        $role = $request->query('role', 'all');
        $query = User::query();
        if ($role !== 'all') { $query->where('role', $role); }
        $users = $query->latest()->paginate(10);
        
        return view('admin.users.index', compact('users', 'role'));
    }

    public function creneaux() {
        return view('admin.creneaux.index');
    }
}
