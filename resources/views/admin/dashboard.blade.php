@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 space-y-8">

    <h1 class="text-3xl font-bold">Dashboard</h1>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $kpiCards = [
                ['title'=>'Total Bookings','value'=>$totalBookings,'icon'=>'shopping-bag','color'=>'from-indigo-500 to-purple-500','growth'=>$bookingGrowth],
                ['title'=>'Pending Bookings','value'=>$pendingBookings,'icon'=>'clock','color'=>'from-yellow-400 to-orange-400','growth'=>0],
                ['title'=>'Active Customers','value'=>$totalCustomers,'icon'=>'users','color'=>'from-green-400 to-teal-500','growth'=>$customerGrowth],
                ['title'=>'Revenue','value'=>$totalRevenue,'icon'=>'credit-card','color'=>'from-pink-500 to-red-500','growth'=>$revenueGrowth,'currency'=>'Rp '],
            ];
        @endphp

        @foreach($kpiCards as $card)
        <div class="relative rounded-2xl shadow-lg p-6 text-white bg-gradient-to-r {{ $card['color'] }} hover:scale-105 transition-transform duration-300">
            @if(isset($card['growth']))
            <div class="absolute top-4 right-4 text-sm font-semibold {{ $card['growth'] >= 0 ? 'text-green-200' : 'text-red-200' }}">
                {{ $card['growth'] >=0 ? '+' : '' }}{{ $card['growth'] }}%
            </div>
            @endif
            <div class="flex items-center space-x-4">
                <div class="p-5 bg-white/20 rounded-full flex-shrink-0">
                    <i class="fas fa-{{ $card['icon'] }} text-3xl"></i>
                </div>
                <div class="flex flex-col justify-center">
                    <h3 class="text-sm font-medium">{{ $card['title'] }}</h3>
                    <p class="text-3xl font-bold mt-1">
                        {{ $card['currency'] ?? '' }}{{ number_format($card['value'],0,',','.') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Booking Trend (1 Tahun) -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Booking Trend ({{ \Carbon\Carbon::now()->year }})</h2>
            <canvas id="bookingTrendChart" height="200"></canvas>
        </div>

        <!-- Revenue per Package -->
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Revenue per Package</h2>
            <canvas id="revenuePackageChart" height="200"></canvas>
        </div>

        <!-- Status Distribution -->
        <div class="bg-white rounded-2xl shadow p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold mb-4">Booking Status Distribution</h2>
            <div class="flex justify-center">
                <canvas id="statusChart" width="250" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Packages & Offices -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Top Packages</h2>
            @php $maxPackageRevenue = max($topPackages->pluck('revenue')->toArray() ?? [1]); @endphp
            <ul class="space-y-3">
                @foreach($topPackages as $p)
                <li>
                    <div class="flex justify-between mb-1">
                        <span>{{ $p['name'] }}</span>
                        <span>Rp {{ number_format($p['revenue'],0,',','.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 h-3 rounded-full">
                        <div class="h-3 rounded-full bg-indigo-500" style="width: {{ ($p['revenue']/$maxPackageRevenue)*100 }}%"></div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Top Offices</h2>
            @php $maxOfficeRevenue = max($topOffices->pluck('revenue')->toArray() ?? [1]); @endphp
            <ul class="space-y-3">
                @foreach($topOffices as $o)
                <li>
                    <div class="flex justify-between mb-1">
                        <span>{{ $o['office_name'] }}</span>
                        <span>Rp {{ number_format($o['revenue'],0,',','.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 h-3 rounded-full">
                        <div class="h-3 rounded-full bg-green-500" style="width: {{ ($o['revenue']/$maxOfficeRevenue)*100 }}%"></div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Booking Trend 1 Tahun
    new Chart(document.getElementById('bookingTrendChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Bookings',
                data: @json($bookingCounts),
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99,102,241,0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: @json($pointColors)
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' bookings';
                        }
                    }
                }
            }
        }
    });

    // Revenue per Package
    new Chart(document.getElementById('revenuePackageChart'), {
        type: 'bar',
        data: {
            labels: @json($packageNames),
            datasets: [{
                label: 'Revenue',
                data: @json($packageRevenue),
                backgroundColor: '#10B981'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Status Doughnut
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusCounts),
                backgroundColor: ['#F59E0B','#3B82F6','#EF4444','#10B981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 20, padding: 15 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
</script>
@endsection