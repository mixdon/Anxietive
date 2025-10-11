<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Office;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ========================
        // KPI Cards
        // ========================
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalCustomers = Customer::where('status_aktif', 1)->count();
        $totalRevenue = Booking::where('status', 'completed')
            ->with('package')
            ->get()
            ->sum(fn($b) => $b->package->amount ?? 0);

        // ========================
        // Growth %
        // ========================
        $lastMonthBookings = Booking::whereBetween('date', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();
        $bookingGrowth = $lastMonthBookings == 0 ? 100 : round((($totalBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 2);

        $lastMonthCustomers = Customer::where('status_aktif', 1)
            ->whereMonth('insert_at', Carbon::now()->subMonth()->month)
            ->whereYear('insert_at', Carbon::now()->subMonth()->year)
            ->count();
        $customerGrowth = $lastMonthCustomers == 0 ? 100 : round((($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100, 2);

        $lastMonthRevenue = Booking::where('status', 'completed')
            ->whereBetween('date', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->with('package')
            ->get()
            ->sum(fn($b) => $b->package->amount ?? 0);
        $revenueGrowth = $lastMonthRevenue == 0 ? 100 : round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2);

        // ========================
        // Booking Trend (1 Tahun) Januari - Desember tahun ini
        // ========================
        $year = Carbon::now()->year;
        $months = collect();
        $bookingCounts = collect();

        for ($m = 1; $m <= 12; $m++) {
            $monthName = Carbon::createFromDate($year, $m, 1)->format('M');
            $count = Booking::whereYear('date', $year)
                ->whereMonth('date', $m)
                ->count();
            $months->push($monthName);
            $bookingCounts->push($count);
        }

        // Highlight bulan sekarang
        $currentMonthIndex = Carbon::now()->month - 1;
        $pointColors = $months->map(function($m, $i) use ($currentMonthIndex) {
            return $i === $currentMonthIndex ? '#F59E0B' : '#6366F1';
        });

        // ========================
        // Revenue per Package
        // ========================
        $revenuePerPackage = Package::with(['bookings' => fn($q) => $q->where('status', 'completed')])->get()
            ->map(fn($p) => [
                'name' => $p->judul_package,
                'revenue' => $p->bookings->sum(fn($b) => $b->package->amount ?? 0)
            ]);
        $packageNames = $revenuePerPackage->pluck('name');
        $packageRevenue = $revenuePerPackage->pluck('revenue');

        // ========================
        // Booking Status Distribution
        // ========================
        $statusDistribution = Booking::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->get();
        $statusLabels = $statusDistribution->pluck('status');
        $statusCounts = $statusDistribution->pluck('total');

        // ========================
        // Top Packages
        // ========================
        $topPackages = $revenuePerPackage->sortByDesc('revenue')->take(5);

        // ========================
        // Top Offices
        // ========================
        $topOffices = Office::with(['packages.bookings' => fn($q) => $q->where('status', 'completed')])->get()
            ->map(fn($o) => [
                'office_name' => $o->office_name,
                'revenue' => $o->packages->sum(fn($p) => $p->bookings->sum(fn($b) => $b->package->amount ?? 0))
            ])
            ->sortByDesc('revenue')
            ->take(5);

        // ========================
        // Kirim ke Blade
        // ========================
        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'totalCustomers',
            'totalRevenue',
            'bookingGrowth',
            'customerGrowth',
            'revenueGrowth',
            'months',
            'bookingCounts',
            'pointColors',
            'packageNames',
            'packageRevenue',
            'statusLabels',
            'statusCounts',
            'topPackages',
            'topOffices'
        ));
    }
}