<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookingController extends Controller
{

    public function index()
    {
        $studios = Package::with('office')->get();
        return view('booking', compact('studios'));
    }

    public function schedule($id)
    {
        $selected = Package::with('office')->findOrFail($id);

        $slotMinutes = $selected->times ?? 30;

        $config = [
            'open'         => '10:00',
            'close'        => '21:30',
            'closed_days'  => [1], // 1 = Senin 
            'slot_minutes' => $slotMinutes,
        ];

        $open = strtotime($config['open']);
        $close = strtotime($config['close']);
        $times = [];
        for ($time = $open; $time < $close; $time += $slotMinutes * 60) {
            $times[] = date('H:i', $time);
        }

        return view('booking-schedule', compact('selected', 'config', 'times'));
    }

    public function checkAvailability($studio, $date)
    {
        $bookedTimes = Booking::where('package_id', $studio)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'completed'])
            ->pluck('time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        return response()->json($bookedTimes);
    }

    public function form(Request $request)
    {
        $studioId = $request->query('studio');
        $date     = $request->query('date');
        $time     = $request->query('time');

        if (!$studioId) {
            return redirect()->route('booking')->with('error', 'Studio tidak ditemukan.');
        }

        $selected = Package::with('office')->findOrFail($studioId);

        $customer = Auth::guard('customer')->user();

        return view('booking-form', compact('selected', 'date', 'time', 'customer'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login', [
                'redirect' => $request->fullUrl(),
            ])->with('warning', 'Silakan login terlebih dahulu untuk melakukan booking.');
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

        $existingBooking = Booking::where('package_id', $validated['studio'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->whereIn('status', ['pending', 'completed'])
            ->first();

        if ($existingBooking) {
            return back()->withInput()->with('error', 'Slot waktu tersebut sudah dibooking. Silakan pilih jam lain.');
        }

        $path = null;
        if ($request->hasFile('img_bukti_trf')) {
            $file = $request->file('img_bukti_trf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/bukti_trf', $filename, 'public');
        }

        $customerId = Auth::guard('customer')->id();

        Booking::create([
            'package_id'    => $validated['studio'],
            'customer_id'   => $customerId,
            'fullname'      => $validated['fullname'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'date'          => $validated['date'],
            'time'          => $validated['time'],
            'message'       => $validated['message'] ?? null,
            'img_bukti_trf' => $path,
            'status'        => 'pending',
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Booking berhasil dikirim!');
    }
}