<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua admin dan relasinya ke role
        $admins = User::with('role')->orderBy('created_at', 'desc')->get();
        $roles = Role::all();

        return view('admin.data-admin', compact('admins', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:200|unique:tb_user,username',
            'password' => 'required|string|min:6',
            'fullname' => 'nullable|string|max:200',
            'roles' => 'required|exists:tb_roles,id',
        ]);

        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'fullname' => $validated['fullname'] ?? null,
            'roles' => $validated['roles'],
        ]);

        return redirect()->route('admin.data-admin')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.data-admin')->with('success', 'Admin berhasil dihapus!');
    }
}