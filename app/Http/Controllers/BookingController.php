<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private function getStudios()
    {
        return [
            [
                'id' => 'basic-pekanbaru',
                'title' => 'BASIC STUDIO',
                'location' => 'Pekanbaru | Cempedak I',
                'address' => 'Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125, Indonesia',
                'duration' => '30 minutes',
                'detail_duration' => [
                    '5 minutes get ready',
                    '15 minutes Self Photo',
                    '10 minutes Photo Selection',
                ],
                'price' => 80000,
                'image' => 'images/booking/BasicStudio001.jpeg',
            ],
            [
                'id' => 'basic-lampung',
                'title' => 'BASIC STUDIO',
                'location' => 'Lampung | KS. Tubun',
                'address' => 'Jl. KS. Tubun No.10, Rw. Laut, Kec. Tanjungkarang Timur, Kota Bandar Lampung, Lampung 35213, Indonesia',
                'duration' => '30 minutes',
                'detail_duration' => [
                    '5 minutes get ready',
                    '15 minutes Self Photo',
                    '10 minutes Photo Selection',
                ],
                'price' => 80000,
                'image' => 'images/booking/BasicStudio002.jpeg',
            ],
            [
                'id' => 'basic-delima',
                'title' => 'BASIC STUDIO',
                'location' => 'Pekanbaru | Delima',
                'address' => 'Jl. Delima, Delima, Kec. Tampan, Kota Pekanbaru, Riau 28291, Indonesia',
                'duration' => '30 minutes',
                'detail_duration' => [
                    '5 minutes get ready',
                    '15 minutes Self Photo',
                    '10 minutes Photo Selection',
                ],
                'price' => 80000,
                'image' => 'images/booking/BasicStudio003.jpeg',
            ],
            [
                'id' => 'large-pekanbaru',
                'title' => 'LARGE STUDIO',
                'location' => 'Pekanbaru | Cempedak I',
                'address' => 'Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125, Indonesia',
                'duration' => '60 minutes',
                'detail_duration' => [
                    'Self Photo Studio Pekanbaru',
                ],
                'price' => 100000,
                'image' => 'images/booking/LargeStudio001.png',
            ],
            [
                'id' => 'red-theater-lampung',
                'title' => 'RED THEATER STUDIO',
                'location' => 'Lampung | KS. Tubun',
                'address' => 'Jl. KS. Tubun No.10, Rw. Laut, Kec. Tanjungkarang Timur, Kota Bandar Lampung, Lampung 35213, Indonesia',
                'duration' => '30 minutes',
                'detail_duration' => [
                    '5 minutes get ready',
                    '15 minutes Self Photo',
                    '10 minutes Photo Selection',
                ],
                'price' => 90000,
                'image' => 'images/booking/RedTheaterStudio001.jpeg',
            ],
            [
                'id' => 'red-pekanbaru',
                'title' => 'RED STUDIO',
                'location' => 'Pekanbaru | Cempedak I',
                'address' => 'Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125, Indonesia',
                'duration' => '15 minutes',
                'detail_duration' => [
                    'Self Photo Studio Pekanbaru',
                ],
                'price' => 60000,
                'image' => 'images/booking/RedStudio001.jpeg',
            ],
            [
                'id' => 'red-lampung',
                'title' => 'RED STUDIO',
                'location' => 'Lampung | KS. Tubun',
                'address' => 'Jl. KS. Tubun No.10, Rw. Laut, Kec. Tanjungkarang Timur, Kota Bandar Lampung, Lampung 35213, Indonesia',
                'duration' => '15 minutes',
                'detail_duration' => [
                    'Self Photo Studio Lampung',
                ],
                'price' => 60000,
                'image' => 'images/booking/RedStudio002.jpeg',
            ],
        ];
    }

    public function index()
    {
        $studios = $this->getStudios();
        return view('booking', compact('studios'));
    }

    public function schedule($studio, Request $request)
    {
        $studios = $this->getStudios();
        $selected = collect($studios)->firstWhere('id', $studio) ?? $studios[0];

        // Tentukan slot dari durasi studio (ambil angka menit saja)
        $slotMinutes = (int) filter_var($selected['duration'], FILTER_SANITIZE_NUMBER_INT);

        // Konfigurasi operasional
        $config = [
            'open' => '10:00',
            'close' => '21:30',
            'closed_days' => [1], // Senin tutup
            'slot_minutes' => $slotMinutes, 
        ];

        // Generate timeslot (opsional, untuk debugging saja)
        $open = strtotime($config['open']);
        $close = strtotime($config['close']);
        $times = [];
        for ($time = $open; $time < $close; $time += $slotMinutes * 60) {
            $times[] = date('H:i', $time);
        }

        return view('booking-schedule', compact('selected', 'config', 'times'));
    }

    public function form(Request $request)
    {
        $studioId = $request->query('studio');
        $date = $request->query('date');
        $time = $request->query('time');

        $studios = $this->getStudios();
        $selected = collect($studios)->firstWhere('id', $studioId) ?? $studios[0];

        $user = Auth::user();

        return view('booking-form', compact('selected', 'date', 'time', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'studio' => 'required|string',
            'date' => 'required|string',
            'time' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'nullable|string',
        ]);

        // TODO: simpan ke database
        return redirect()->route('booking')->with('success', 'Booking berhasil dikirim. Kami akan konfirmasi via email/SMS.');
    }
}
