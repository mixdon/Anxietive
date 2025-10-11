<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Tampilkan form login khusus admin
        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Cek user admin berdasarkan username
        $admin = DB::table('tb_user')->where('username', $username)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            // Simpan admin ke session
            Session::put('admin_user', $admin);

            return redirect()->route('admin.dashboard')
                             ->with('success', 'Login Admin berhasil!');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        // Hapus session admin
        Session::forget('admin_user');

        // Reset session Laravel
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil.');
    }
}
