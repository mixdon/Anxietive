<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    /**
     * Menampilkan daftar booking sesuai role admin.
     */
    public function index()
    {
        // Ambil data admin dari session
        $user = session('admin_user');

        // Cek jika tidak ada user di session
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika superadmin, tampilkan semua booking
        if ($user->roles == 1) {
            $bookings = Booking::with(['package.office', 'customer'])
                ->latest()
                ->paginate(10);
        } else {
            // Admin kantor hanya bisa lihat booking dari officenya
            $bookings = Booking::whereHas('package', function ($query) use ($user) {
                    $query->where('id_office', $user->office);
                })
                ->with(['package.office', 'customer'])
                ->latest()
                ->paginate(10);
        }

        return view('admin.data-booking', compact('bookings'));
    }

    /**
     * Mengubah status booking.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,refund',
        ]);

        $user = session('admin_user');
        $booking = Booking::with('package.office')->findOrFail($id);

        // Batasi agar admin kantor hanya bisa ubah booking dari officenya
        if ($user->roles != 1 && $booking->package?->office?->id != $user->office) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah status booking ini.');
        }

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}