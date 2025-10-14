@extends('layouts.admin')

@section('title', 'Manage Customers | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Customers</h1>
        <button id="btnAddNew"
            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 focus:ring-2 focus:ring-purple-400 focus:outline-none transition">
            <i class="fa-solid fa-plus mr-2 text-sm"></i> Add New Customer
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg shadow-sm">
        <i class="fa-solid fa-circle-check mr-2 text-green-500"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Section -->
    <div id="formContainer"
        class="hidden bg-white rounded-xl shadow-md p-6 mb-10 border border-gray-200 opacity-0 transform translate-y-3 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Customer</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="customerForm" method="POST" action="{{ route('admin.data-customer.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="fullname" id="fullname" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status_aktif" id="status_aktif" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
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
            <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">Customer List</h3>
            <div class="flex flex-wrap gap-3 items-center">
                <select id="rowsPerPage"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                    <option value="5">05 rows</option>
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                </select>
                <input type="text" id="tableSearch" placeholder="Search customers..."
                    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>
        </div>

        <div class="overflow-x-auto scroll-smooth pb-2">
            <table id="customerTable" class="min-w-[800px] w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Full Name</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $customer->email }}</td>
                        <td class="px-4 py-3">{{ $customer->fullname }}</td>
                        <td class="px-4 py-3">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-4 py-3 capitalize">{{ $customer->status_aktif }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                                    data-id="{{ $customer->id }}"
                                    data-email="{{ $customer->email }}"
                                    data-fullname="{{ $customer->fullname }}"
                                    data-phone="{{ $customer->phone }}"
                                    data-status="{{ $customer->status_aktif }}">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>

                                <form action="{{ route('admin.data-customer.destroy', $customer->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this customer?')">
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
                        <td colspan="6" class="text-center py-8 text-gray-500">No customers found.</td>
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
    const formContainer = document.getElementById('formContainer');
    const tableContainer = document.getElementById('tableContainer');
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const formTitle = document.getElementById('formTitle');
    const customerForm = document.getElementById('customerForm');
    const formMethod = document.getElementById('formMethod');

    const rows = [...document.querySelectorAll('#customerTable tbody tr')];
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const paginationContainer = document.getElementById('paginationButtons');
    const paginationInfo = document.getElementById('paginationInfo');
    const searchInput = document.getElementById('tableSearch');

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

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
                class="px-3 py-1 border rounded-md text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">
                &lt;
            </button>
            <span class="text-gray-700 font-medium">Page ${currentPage} of ${totalPages || 1}</span>
            <button id="nextPage"
                class="px-3 py-1 border rounded-md text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">
                &gt;
            </button>
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

        const showingStart = total === 0 ? 0 : start + 1;
        const showingEnd = Math.min(end, total);
        paginationInfo.textContent = `Showing ${showingStart}–${showingEnd} of ${total} entries`;
    }

    function toggleForm(show) {
        if (show) {
            tableContainer.classList.add('hidden');
            formContainer.classList.remove('hidden');
            setTimeout(() => formContainer.classList.remove('opacity-0', 'translate-y-3'), 10);
        } else {
            formContainer.classList.add('opacity-0', 'translate-y-3');
            setTimeout(() => {
                formContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
            }, 300);
        }
    }

    // ADD NEW
    btnAddNew.addEventListener('click', () => {
        customerForm.reset();
        customerForm.action = "{{ route('admin.data-customer.store') }}";
        formMethod.value = "POST";
        formTitle.textContent = "Add New Customer";
        toggleForm(true);
    });

    btnCancel.addEventListener('click', () => toggleForm(false));
    btnCancel2.addEventListener('click', () => toggleForm(false));

    // EDIT BUTTONS
    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById('email').value = btn.dataset.email;
            document.getElementById('fullname').value = btn.dataset.fullname;
            document.getElementById('phone').value = btn.dataset.phone;
            document.getElementById('status_aktif').value = btn.dataset.status;
            document.getElementById('password').value = '';

            customerForm.action = `/admin/data-customer/${id}`;
            formMethod.value = "PUT";
            formTitle.textContent = "Edit Customer";

            toggleForm(true);
        });
    });

    rowsPerPageSelect.addEventListener('change', () => {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        renderTable();
    });

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    renderTable();
});
</script>
@endsection