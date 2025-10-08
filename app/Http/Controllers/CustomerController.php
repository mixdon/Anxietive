<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // Halaman profil
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    // Update profil
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->fullname = $request->fullname;
        $customer->phone = $request->phone;
        $customer->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    // Daftar booking
    public function bookings()
    {
        $customer = Auth::guard('customer')->user();
        $bookings = Booking::with('package.office')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('customer.bookings', compact('bookings'));
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil.');
    }
}