<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required|string', // email atau username
            'password' => 'required|string',
        ]);

        $identity = $request->input('identity');
        $password = $request->input('password');

        if (str_contains($identity, '@')) {
            // LOGIN CUSTOMER
            $customer = Customer::where('email', $identity)->first();
            if ($customer && Hash::check($password, $customer->password)) {
                Auth::guard('customer')->login($customer);
                return redirect()->intended(route('booking'))
                                 ->with('success', 'Login Customer berhasil!');
            }

            return back()->withErrors(['identity' => 'Email atau password salah.']);
        } else {
            // LOGIN ADMIN
            $admin = DB::table('tb_user')->where('username', $identity)->first();
            if ($admin && Hash::check($password, $admin->password)) {
                // Simpan admin di session supaya bisa dipanggil di view
                Session::put('admin_user', $admin);

                return redirect()->route('admin.dashboard')
                                 ->with('success', 'Login Admin berhasil!');
            }

            return back()->withErrors(['identity' => 'Username atau password salah.']);
        }
    }

    public function logout(Request $request)
    {
        // Logout customer
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        }

        // Hapus session admin
        Session::forget('admin_user');

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman home
        return redirect()->route('home')->with('success', 'Logout berhasil.');
    }
}