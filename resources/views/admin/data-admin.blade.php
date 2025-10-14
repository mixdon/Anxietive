@extends('layouts.admin')

@section('title', 'Manage Admins | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-3">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Admins</h1>
        <button id="btnAddNew"
            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-md hover:bg-purple-500 focus:ring-2 focus:ring-purple-400 focus:outline-none transition">
            <i class="fa-solid fa-plus mr-2 text-sm"></i> Add New Admin
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            <i class="fa-solid fa-circle-check mr-2 text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Create/Edit -->
    <div id="formContainer"
        class="hidden bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-10 opacity-0 transform translate-y-3 transition-all duration-300 ease-out">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-lg font-semibold text-gray-800">Add New Admin</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="adminForm" method="POST" action="{{ route('admin.data-admin.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="fullname" id="fullname"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="roles" id="roles" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->role) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="btnCancel2"
                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm bg-purple-600 text-white rounded-md hover:bg-purple-500 transition">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div id="tableContainer" class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Admin List</h3>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <select id="lengthMenu"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    <option value="5">05 rows</option>
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                </select>

                <input type="text" id="tableSearch" placeholder="Search admins..."
                    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <!-- Desktop Table -->
            <table id="adminTable" class="hidden sm:table min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-6 py-3 font-medium">#</th>
                        <th class="px-6 py-3 font-medium">Username</th>
                        <th class="px-6 py-3 font-medium">Full Name</th>
                        <th class="px-6 py-3 font-medium">Role</th>
                        <th class="px-6 py-3 font-medium">Created At</th>
                        <th class="px-6 py-3 font-medium text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 font-medium">{{ $admin->username }}</td>
                            <td class="px-6 py-3">{{ $admin->fullname ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $admin->role->role ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $admin->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-3 text-center flex flex-col sm:flex-row justify-center items-center gap-2">
                                <button class="btnEdit px-3 py-1 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-500 transition"
                                    data-id="{{ $admin->id }}"
                                    data-username="{{ $admin->username }}"
                                    data-fullname="{{ $admin->fullname }}"
                                    data-role="{{ $admin->roles }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <form action="{{ route('admin.data-admin.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this admin?')"
                                        class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-500 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-6 text-gray-500">No admins found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Mobile Card View -->
            <div class="sm:hidden space-y-4 transition-all duration-300 ease-in-out p-4">
                @forelse($admins as $admin)
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-white">
                        <div class="flex justify-between items-center mb-3">
                            <div class="font-semibold text-gray-800">{{ $admin->username }}</div>
                            <div class="text-xs text-gray-500">{{ $admin->created_at->format('Y-m-d') }}</div>
                        </div>
                        <div class="text-sm text-gray-700 mb-2">
                            <div><span class="font-medium">Full Name:</span> {{ $admin->fullname ?? '-' }}</div>
                            <div><span class="font-medium">Role:</span> {{ $admin->role->role ?? '-' }}</div>
                        </div>
                        <div class="flex justify-end gap-2 mt-3">
                            <button class="btnEdit px-3 py-1 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-500 transition"
                                data-id="{{ $admin->id }}"
                                data-username="{{ $admin->username }}"
                                data-fullname="{{ $admin->fullname }}"
                                data-role="{{ $admin->roles }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <form action="{{ route('admin.data-admin.destroy', $admin->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this admin?')"
                                    class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-500 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-6">No admins found.</div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div id="paginationContainer" class="flex flex-wrap justify-between items-center p-4 border-t border-gray-200 text-sm text-gray-600">
            <div id="showingInfo" class="mb-2 sm:mb-0">Showing 1–10 of {{ count($admins) }} entries</div>
            <div class="flex items-center gap-2">
                <button id="prevPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 disabled:opacity-50"><</button>
                <span id="pageInfo">Page 1</span>
                <button id="nextPage" class="px-3 py-1 border rounded-md hover:bg-gray-100 disabled:opacity-50">></button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const formContainer = document.getElementById('formContainer');
    const tableContainer = document.getElementById('tableContainer');
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const adminForm = document.getElementById('adminForm');
    const formTitle = document.getElementById('formTitle');
    const formMethod = document.getElementById('formMethod');

    const lengthMenu = document.getElementById('lengthMenu');
    const paginationInfo = document.getElementById('pageInfo');
    const showingInfo = document.getElementById('showingInfo');
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const searchInput = document.getElementById('tableSearch');

    let currentPage = 1;
    let rowsPerPage = parseInt(lengthMenu.value);

    function renderTable() {
        const query = searchInput.value.toLowerCase();
        const allRows = Array.from(document.querySelectorAll('#adminTable tbody tr'));
        const filteredRows = allRows.filter(row => row.innerText.toLowerCase().includes(query));
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        currentPage = Math.min(currentPage, totalPages || 1);

        allRows.forEach(row => row.style.display = 'none');
        filteredRows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? '' : 'none';
        });

        paginationInfo.textContent = `Page ${currentPage} of ${totalPages || 1}`;
        showingInfo.textContent = `Showing ${(currentPage - 1) * rowsPerPage + 1}–${Math.min(currentPage * rowsPerPage, filteredRows.length)} of ${filteredRows.length} entries`;
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    lengthMenu.addEventListener('change', e => {
        rowsPerPage = parseInt(e.target.value);
        currentPage = 1;
        renderTable();
    });

    prevBtn.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderTable(); } });
    nextBtn.addEventListener('click', () => { currentPage++; renderTable(); });
    searchInput.addEventListener('input', renderTable);

    renderTable();

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

    btnAddNew.addEventListener('click', () => {
        adminForm.reset();
        adminForm.action = "{{ route('admin.data-admin.store') }}";
        formMethod.value = "POST";
        formTitle.textContent = "Add New Admin";
        toggleForm(true);
    });

    btnCancel.addEventListener('click', () => toggleForm(false));
    btnCancel2.addEventListener('click', () => toggleForm(false));

    // Handle Edit
    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            document.getElementById('username').value = btn.dataset.username;
            document.getElementById('fullname').value = btn.dataset.fullname;
            document.getElementById('roles').value = btn.dataset.role;
            document.getElementById('password').value = '';

            adminForm.action = `/admin/data-admin/${id}`;
            formMethod.value = "PUT";
            formTitle.textContent = "Edit Admin";

            toggleForm(true);
        });
    });
});
</script>
@endsection