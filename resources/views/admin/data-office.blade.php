@extends('layouts.admin')

@section('title', 'Manage Offices | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Offices</h1>

        <button id="btnAddNew"
            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 focus:ring-2 focus:ring-purple-400 focus:outline-none transition">
            <i class="fa-solid fa-plus mr-2 text-sm"></i> Add New Office
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
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Office</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="officeForm" method="POST" action="{{ route('admin.data-office.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Office Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Office Name</label>
                    <input type="text" name="office_name" id="office_name" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- Email Kantor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Kantor</label>
                    <input type="text" name="email_kantor" id="email_kantor"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- No WA Kantor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WA Kantor</label>
                    <input type="text" name="no_wa_kantor" id="no_wa_kantor"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- Latitude -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" name="latitude" id="latitude"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- Longitude -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" name="longitude" id="longitude"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <!-- Kode Office -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Office</label>
                    <input type="text" name="kode_office" id="kode_office"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
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
            <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">Office List</h3>

            <div class="flex flex-wrap gap-3 items-center">
                <select id="rowsPerPage"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                    <option value="5">05 rows</option>
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                </select>

                <input type="text" id="tableSearch" placeholder="Search offices..."
                    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>
        </div>

        <div class="overflow-x-auto scroll-smooth pb-2">
            <table id="officeTable" class="min-w-[900px] w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">WA</th>
                        <th class="px-4 py-3">Latitude</th>
                        <th class="px-4 py-3">Longitude</th>
                        <th class="px-4 py-3">Kode Office</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">

                    @forelse($offices as $office)
                    <tr class="hover:bg-purple-50 transition-colors">

                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $office->office_name }}</td>
                        <td class="px-4 py-3">{{ $office->address ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $office->email_kantor ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $office->no_wa_kantor ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $office->latitude ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $office->longitude ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $office->kode_office ?? '-' }}</td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">

                                <!-- EDIT -->
                                <button
                                    class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                                    data-id="{{ $office->id }}"
                                    data-office_name="{{ $office->office_name }}"
                                    data-address="{{ $office->address }}"
                                    data-email_kantor="{{ $office->email_kantor }}"
                                    data-no_wa_kantor="{{ $office->no_wa_kantor }}"
                                    data-latitude="{{ $office->latitude }}"
                                    data-longitude="{{ $office->longitude }}"
                                    data-kode_office="{{ $office->kode_office }}">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('admin.data-office.destroy', $office->id) }}"
                                    method="POST" onsubmit="return confirm('Delete this office?')">
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
                        <td colspan="9" class="text-center py-8 text-gray-500">No offices found.</td>
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

    const rows = [...document.querySelectorAll('#officeTable tbody tr')];
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const paginationContainer = document.getElementById('paginationButtons');
    const paginationInfo = document.getElementById('paginationInfo');
    const searchInput = document.getElementById('tableSearch');
    const tableContainer = document.getElementById('tableContainer');

    const formContainer = document.getElementById('formContainer');
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const formTitle = document.getElementById('formTitle');
    const officeForm = document.getElementById('officeForm');
    const formMethod = document.getElementById('formMethod');

    const officeNameInput = document.getElementById('office_name');
    const addressInput = document.getElementById('address');
    const emailInput = document.getElementById('email_kantor');
    const waInput = document.getElementById('no_wa_kantor');
    const latInput = document.getElementById('latitude');
    const longInput = document.getElementById('longitude');
    const kodeInput = document.getElementById('kode_office');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);


    // PAGINATION + SEARCH
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
            <button id="prevPage"
                class="px-3 py-1 border rounded-md text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">&lt;</button>
            <span class="text-gray-700 font-medium">Page ${currentPage} of ${totalPages || 1}</span>
            <button id="nextPage"
                class="px-3 py-1 border rounded-md text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">&gt;</button>
        `;

        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        paginationInfo.textContent =
            `Showing ${total === 0 ? 0 : start + 1}–${Math.min(end, total)} of ${total} entries`;
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


    // FORM TOGGLE
    function toggleForm(show) {
        btnAddNew.classList.toggle('hidden', show);

        if (show) {
            formContainer.classList.remove('hidden');
            tableContainer.classList.add('hidden');
            setTimeout(() => formContainer.classList.remove('opacity-0', 'translate-y-3'), 10);
        } else {
            formContainer.classList.add('opacity-0', 'translate-y-3');
            setTimeout(() => {
                formContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
            }, 300);
        }
    }

    btnAddNew.addEventListener('click', () => {
        formTitle.textContent = 'Add New Office';
        officeForm.action = "{{ route('admin.data-office.store') }}";
        formMethod.value = 'POST';

        officeNameInput.value = '';
        addressInput.value = '';
        emailInput.value = '';
        waInput.value = '';
        latInput.value = '';
        longInput.value = '';
        kodeInput.value = '';

        toggleForm(true);
    });

    btnCancel.addEventListener('click', () => toggleForm(false));
    btnCancel2.addEventListener('click', () => toggleForm(false));

    // EDIT BUTTON
    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', () => {

            formTitle.textContent = 'Edit Office';

            const id = btn.dataset.id;

            officeForm.action = `/admin/data-office/${id}`;
            formMethod.value = 'PUT';

            officeNameInput.value = btn.dataset.office_name;
            addressInput.value = btn.dataset.address;
            emailInput.value = btn.dataset.email_kantor;
            waInput.value = btn.dataset.no_wa_kantor;
            latInput.value = btn.dataset.latitude;
            longInput.value = btn.dataset.longitude;
            kodeInput.value = btn.dataset.kode_office;

            toggleForm(true);
        });
    });

    renderTable();
});
</script>
@endsection