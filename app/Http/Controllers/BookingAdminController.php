<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = session('admin_user');

        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query dasar
        $query = Booking::with(['package.office', 'customer']);

        // Role filtering
        if ($user->roles == 2) {
            $query->whereHas('package', function ($q) use ($user) {
                $q->where('id_office', $user->office);
            });
        }
        // SUPER_ADMIN (1) & OWNER (3) → tidak dibatasi

        // Filter date range
        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter office (khusus hanya superadmin & owner bisa memilih)
        if ($request->office_id) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('id_office', $request->office_id);
            });
        }

        $bookings = $query->latest()->paginate(10);

        // Office list (role-based)
        $offices = [];
        if ($user->roles == 1 || $user->roles == 3) {
            $offices = \App\Models\Office::orderBy('office_name')->get();
        } else {
            // Admin → hanya 1 kantor
            $offices = \App\Models\Office::where('id', $user->office)->get();
        }

        return view('admin.data-booking', compact('bookings', 'offices'));
    }

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