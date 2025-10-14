@extends('layouts.admin')

@section('title', 'Manage Bookings | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Bookings</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-800">Booking List</h3>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <select id="lengthMenu"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    <option value="5">05 rows</option>
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                </select>

                <input type="text" id="tableSearch" placeholder="Search bookings..."
                    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table id="bookingTable" class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-6 py-3 font-medium">#</th>
                        <th class="px-6 py-3 font-medium">Customer</th>
                        <th class="px-6 py-3 font-medium">Package</th>
                        <th class="px-6 py-3 font-medium">Office</th>
                        <th class="px-6 py-3 font-medium">Date</th>
                        <th class="px-6 py-3 font-medium">Time</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">
                                <div class="font-medium">{{ $booking->customer->fullname ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->customer->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3">{{ $booking->package->judul_package ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $booking->package->office->office_name ?? '-' }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</td>

                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($booking->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($booking->status == 'completed') bg-green-100 text-green-700
                                    @elseif($booking->status == 'cancelled') bg-red-100 text-red-700
                                    @elseif($booking->status == 'refund') bg-blue-100 text-blue-700
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-center flex flex-col sm:flex-row gap-2 justify-center items-center">
                                <!-- Update Status -->
                                <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->id) }}" class="inline-flex items-center justify-center gap-2">
                                    @csrf
                                    <select name="status"
                                        class="border border-gray-300 rounded-lg text-sm px-2 py-1 focus:ring-2 focus:ring-purple-400 focus:border-purple-400">
                                        <option value="pending" {{ $booking->status=='pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $booking->status=='completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $booking->status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="refund" {{ $booking->status=='refund' ? 'selected' : '' }}>Refund</option>
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1 bg-purple-600 text-white rounded-lg text-xs hover:bg-purple-500 transition">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>

                                <!-- View Transfer Proof -->
                                <button onclick="openModal({{ $booking->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-500 transition">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div id="modal-{{ $booking->id }}"
                            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full relative">
                                <button onclick="closeModal({{ $booking->id }})"
                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>

                                <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">
                                    Booking Details
                                </h2>

                                <div class="text-sm text-gray-700 space-y-2 leading-relaxed">
                                    <div class="flex"><span class="font-semibold w-28">Customer</span><span>:</span><span class="ml-1">{{ $booking->customer->fullname ?? '-' }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Email</span><span>:</span><span class="ml-1">{{ $booking->customer->email ?? '-' }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Package</span><span>:</span><span class="ml-1">{{ $booking->package->judul_package ?? '-' }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Office</span><span>:</span><span class="ml-1">{{ $booking->package->office->office_name ?? '-' }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Date</span><span>:</span><span class="ml-1">{{ \Carbon\Carbon::parse($booking->date)->format('Y-m-d') }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Time</span><span>:</span><span class="ml-1">{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</span></div>
                                    <div class="flex"><span class="font-semibold w-28">Status</span><span>:</span><span class="ml-1">{{ ucfirst($booking->status) }}</span></div>
                                </div>

                                @if($booking->img_bukti_trf)
                                    <div class="mt-6 text-center">
                                        <p class="font-semibold mb-3">Bukti Transfer:</p>
                                        <img src="{{ asset('storage/' . $booking->img_bukti_trf) }}" 
                                            alt="Bukti Transfer"
                                            class="rounded-xl shadow-md max-h-64 mx-auto border border-gray-200">
                                    </div>
                                @else
                                    <p class="text-gray-500 mt-4 text-center italic">Tidak ada bukti transfer.</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="8" class="text-center py-6 text-gray-500">No bookings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="paginationContainer" class="flex flex-wrap justify-between items-center p-4 border-t border-gray-200 text-sm text-gray-600">
            <div id="showingInfo" class="mb-2 sm:mb-0"></div>
            <div class="flex items-center gap-2">
                <button id="prevPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 disabled:opacity-50"><</button>
                <span id="pageInfo"></span>
                <button id="nextPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 disabled:opacity-50">></button>
            </div>
        </div>
    </div>
</div>

<!-- Script Modal + Search + Pagination -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#bookingTable tbody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    const lengthMenu = document.getElementById('lengthMenu');
    const paginationInfo = document.getElementById('pageInfo');
    const showingInfo = document.getElementById('showingInfo');
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const searchInput = document.getElementById('tableSearch');

    let currentPage = 1;
    let rowsPerPage = parseInt(lengthMenu.value);
    let filteredRows = [...rows];

    function renderTable() {
        // Hitung total halaman berdasarkan hasil pencarian
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages || 1);

        // Sembunyikan semua baris, tampilkan hanya sesuai halaman aktif
        rows.forEach(row => row.style.display = 'none');
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => row.style.display = '');

        // Update informasi pagination
        paginationInfo.textContent = `Page ${currentPage} of ${totalPages || 1}`;
        showingInfo.textContent = filteredRows.length
            ? `Showing ${start + 1}–${Math.min(end, filteredRows.length)} of ${filteredRows.length} entries`
            : 'No entries found';
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }

    // Filter pencarian
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        filteredRows = rows.filter(row => row.innerText.toLowerCase().includes(query));
        currentPage = 1;
        renderTable();
    });

    // Navigasi halaman
    prevBtn.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderTable(); } });
    nextBtn.addEventListener('click', () => { currentPage++; renderTable(); });
    lengthMenu.addEventListener('change', e => { rowsPerPage = parseInt(e.target.value); currentPage = 1; renderTable(); });

    renderTable();
});

// Modal
function openModal(id) {
    document.getElementById(`modal-${id}`).classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(`modal-${id}`).classList.add('hidden');
}
</script>
@endsection