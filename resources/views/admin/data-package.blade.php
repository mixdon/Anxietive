@extends('layouts.admin')

@section('title', 'Manage Packages | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Packages</h1>
        <button id="btnAddNew"
            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 focus:ring-2 focus:ring-purple-400 focus:outline-none transition">
            <i class="fa-solid fa-plus mr-2 text-sm"></i> Add New Package
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg shadow-sm">
        <i class="fa-solid fa-circle-check mr-2 text-green-500"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Create/Edit -->
    <div id="formContainer"
        class="hidden bg-white rounded-xl shadow-md p-6 mb-10 border border-gray-200 opacity-0 transform translate-y-3 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Package</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="packageForm" method="POST" action="{{ route('admin.data-package.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" id="package_id" name="package_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="judul_package" id="judul_package" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Office ID</label>
                    <input type="number" name="id_office" id="id_office"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Times (minutes)</label>
                    <input type="number" name="times" id="times" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                    <input type="text" name="amount" id="amount" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail Duration</label>
                    <input type="text" name="detail_duration_input" id="detail_duration_input"
                        placeholder="Example: 30,45,60"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="btnCancel2"
                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 shadow-sm transition">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableContainer" class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div
            class="p-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:flex-nowrap bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">Package List</h3>
            <div class="flex flex-wrap gap-3 items-center">
                <select id="rowsPerPage"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                    <option value="5">05 rows</option>
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                </select>
                <input type="text" id="tableSearch" placeholder="Search packages..."
                    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>
        </div>

        <div class="overflow-x-auto scroll-smooth pb-2">


            <table id="packageTable" class="min-w-[800px] w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Office ID</th>
                        <th class="px-4 py-3">Times</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($packages as $package)
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $package->judul_package }}</td>
                        <td class="px-4 py-3">{{ $package->id_office }}</td>
                        <td class="px-4 py-3">{{ $package->times }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($package->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">

                            <img src="<?= $package->image ?>" alt="" class="w-10 h-10 object-cover rounded-md border">

                            <!-- @if($package->image)
                            <img src="<?= asset('storage/' . $package->image) ?? "https://storage.anxietive.com/assets/resource-web/ .$package->image" ?>" class="w-10 h-10 object-cover rounded-md border">
                            @else
                            <span class="text-gray-400">No Image</span>
                            @endif -->
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <button type="button"
                                    class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                                    data-id="{{ $package->id }}"
                                    data-judul="{{ $package->judul_package }}"
                                    data-id_office="{{ $package->id_office }}"
                                    data-times="{{ $package->times }}"
                                    data-amount="{{ $package->amount }}"
                                    data-detail="{{ implode(',', $package->detail_duration ?? []) }}">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.data-package.destroy', $package->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this package?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-md transition">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">No packages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="paginationContainer"
            class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t bg-gray-50 text-sm text-gray-700 text-center sm:text-left">
            <p id="paginationInfo"></p>
            <div class="flex items-center gap-2" id="paginationButtons"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = [...document.querySelectorAll('#packageTable tbody tr')];
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const paginationContainer = document.getElementById('paginationButtons');
    const paginationInfo = document.getElementById('paginationInfo');
    const searchInput = document.getElementById('tableSearch');

    const tableContainer = document.getElementById('tableContainer');
    const formContainer = document.getElementById('formContainer');
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const form = document.getElementById('packageForm');
    const formTitle = document.getElementById('formTitle');
    const formMethod = document.getElementById('formMethod');
    const packageId = document.getElementById('package_id');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    // --- PAGINATION + SEARCH ---
    function renderTable() {
        const filteredRows = rows.filter(row =>
            row.innerText.toLowerCase().includes(searchInput.value.toLowerCase())
        );

        const total = filteredRows.length;
        const totalPages = Math.ceil(total / rowsPerPage);

        rows.forEach(row => row.classList.add('hidden'));
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => row.classList.remove('hidden'));

        paginationContainer.innerHTML = `
            <button id="prevPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 ${currentPage === 1 ? 'opacity-40 cursor-not-allowed' : ''}">&lt;</button>
            <span>Page ${currentPage} of ${totalPages || 1}</span>
            <button id="nextPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 ${currentPage === totalPages || totalPages === 0 ? 'opacity-40 cursor-not-allowed' : ''}">&gt;</button>
        `;

        document.getElementById('paginationInfo').textContent =
            `Showing ${total ? start + 1 : 0}–${Math.min(end, total)} of ${total} entries`;

        document.getElementById('prevPage').onclick = () => {
            if (currentPage > 1) { currentPage--; renderTable(); }
        };
        document.getElementById('nextPage').onclick = () => {
            if (currentPage < totalPages) { currentPage++; renderTable(); }
        };
    }

    rowsPerPageSelect.addEventListener('change', () => {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        renderTable();
    });

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    // --- TOGGLE FORM ---
    function toggleForm(show, editMode = false) {
        if (show) {
            tableContainer.classList.add('hidden');
            formContainer.classList.remove('hidden');
            setTimeout(() => formContainer.classList.remove('opacity-0', 'translate-y-3'), 10);
            if (!editMode) form.reset();
        } else {
            formContainer.classList.add('opacity-0', 'translate-y-3');
            setTimeout(() => {
                formContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
            }, 300);
        }
    }

    btnAddNew.addEventListener('click', () => {
        form.reset();
        form.action = "{{ route('admin.data-package.store') }}";
        formMethod.value = 'POST';
        formTitle.textContent = 'Add New Package';
        packageId.value = '';
        toggleForm(true);
    });

    btnCancel.addEventListener('click', () => toggleForm(false));
    btnCancel2.addEventListener('click', () => toggleForm(false));

    // --- EDIT BUTTONS ---
    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', () => {
            toggleForm(true, true);
            formTitle.textContent = 'Edit Package';
            form.action = `/admin/data-package/${btn.dataset.id}`;
            formMethod.value = 'PUT';
            packageId.value = btn.dataset.id;
            document.getElementById('judul_package').value = btn.dataset.judul;
            document.getElementById('id_office').value = btn.dataset.id_office;
            document.getElementById('times').value = btn.dataset.times;
            document.getElementById('amount').value = btn.dataset.amount;
            document.getElementById('detail_duration_input').value = btn.dataset.detail || '';
        });
    });

    renderTable();
});
</script>
@endsection