<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Daftar semua studio (package).
     */
    public function index()
    {
        $studios = Package::with('office')->get(); 
        return view('booking', compact('studios'));
    }

    /**
     * Tampilkan jadwal booking berdasarkan package.
     */
    public function schedule($id)
    {
        $selected = Package::with('office')->findOrFail($id);

        // slot booking (default 30 menit jika tidak diisi)
        $slotMinutes = $selected->times ?? 30;

        $config = [
            'open'        => '10:00',
            'close'       => '21:30',
            'closed_days' => [1], // 1 = Senin (tutup)
            'slot_minutes'=> $slotMinutes,
        ];

        // Generate list waktu booking
        $open = strtotime($config['open']);
        $close = strtotime($config['close']);
        $times = [];
        for ($time = $open; $time < $close; $time += $slotMinutes * 60) {
            $times[] = date('H:i', $time);
        }

        return view('booking-schedule', compact('selected', 'config', 'times'));
    }

    /**
     * Form booking (pilih studio, tanggal, jam).
     */
    public function form(Request $request)
    {
        $studioId = $request->query('studio');
        $date     = $request->query('date');
        $time     = $request->query('time');

        $selected = Package::with('office')->findOrFail($studioId);

        // Ambil data customer jika login
        $customer = Auth::guard('customer')->user();

        return view('booking-form', compact('selected', 'date', 'time', 'customer'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request)
    {
        // pastikan customer sudah login
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                ->with('warning', 'Silakan login terlebih dahulu untuk melakukan booking.');
        }

        $validated = $request->validate([
            'studio'        => 'required|integer|exists:tb_package,id',
            'date'          => 'required|date',
            'time'          => 'required|string',
            'fullname'      => 'required|string|max:100',
            'email'         => 'required|email',
            'phone'         => 'required|string|max:20',
            'message'       => 'nullable|string',
            'img_bukti_trf' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan file bukti transfer jika ada
        $path = null;
        if ($request->hasFile('img_bukti_trf')) {
            $file = $request->file('img_bukti_trf');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/bukti_trf', $filename, 'public');
        }

        $customerId = Auth::guard('customer')->id();

        Booking::create([
            'package_id'   => $validated['studio'],
            'customer_id'  => $customerId,
            'fullname'     => $validated['fullname'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'date'         => $validated['date'],
            'time'         => $validated['time'],
            'message'      => $validated['message'] ?? null,
            'img_bukti_trf'=> $path,
            'status'       => 'pending',
        ]);

        return redirect()->route('booking')
            ->with('success', 'Booking berhasil dikirim. Kami akan konfirmasi via email/SMS.');
    }
}
