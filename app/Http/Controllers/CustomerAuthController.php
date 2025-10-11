<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{

    public function showLoginForm(Request $request)
    {
        // Ambil URL tujuan redirect (kalau ada)
        $redirect = $request->query('redirect', route('home'));

        return view('auth.login', compact('redirect'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba autentikasi
        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Ambil redirect URL dari input atau gunakan home
            $redirectUrl = $request->input('redirect', route('home'));

            // Redirect ke halaman yang diinginkan
            return redirect()->intended($redirectUrl)->with('success', 'Login berhasil!');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(Request $request)
    {
        $redirect = $request->query('redirect', route('home'));
        return view('auth.register', compact('redirect'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'fullname' => $data['fullname'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::guard('customer')->login($customer);

        $redirectUrl = $request->input('redirect', route('home'));
        return redirect($redirectUrl)->with('success', 'Registrasi berhasil! Anda sudah login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil.');
    }
}