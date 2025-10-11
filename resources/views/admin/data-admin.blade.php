@extends('layouts.admin')

@section('title', 'Manage Admins | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Admins</h1>
        <button id="btnAddNew"
            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 focus:ring-2 focus:ring-purple-400 focus:outline-none transition">
            <i class="fa-solid fa-plus mr-2 text-sm"></i> Add New Admin
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
    <div id="formContainer" class="hidden bg-white rounded-xl shadow-md p-6 mb-10 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Admin</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="adminForm" method="POST" action="{{ route('admin.data-admin.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    @error('username')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="fullname" id="fullname"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    @error('fullname')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="roles" id="roles" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->role) }}</option>
                        @endforeach
                    </select>
                    @error('roles')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
        <div class="p-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:flex-nowrap">
            <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">Admin List</h3>
            <input type="text" id="tableSearch" placeholder="Search admins..."
                class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
        </div>

        <div class="overflow-x-auto">
            <table id="adminTable" class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Full Name</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Created At</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $admin->username }}</td>
                        <td class="px-4 py-3">{{ $admin->fullname ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $admin->role->role ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $admin->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <button class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                                    data-id="{{ $admin->id }}"
                                    data-username="{{ $admin->username }}"
                                    data-fullname="{{ $admin->fullname }}"
                                    data-role="{{ $admin->roles }}">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.data-admin.destroy', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this admin?')"
                                        class="flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-md transition">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">No admins found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const formContainer = document.getElementById('formContainer');
    const tableContainer = document.getElementById('tableContainer');
    const adminForm = document.getElementById('adminForm');
    const formMethod = document.getElementById('formMethod');
    const formTitle = document.getElementById('formTitle');
    const inputs = {
        username: document.getElementById('username'),
        password: document.getElementById('password'),
        fullname: document.getElementById('fullname'),
        roles: document.getElementById('roles'),
    };

    function showForm(editMode = false, data = null) {
        formContainer.classList.remove('hidden');
        tableContainer.classList.add('hidden');
        if (editMode && data) {
            formTitle.textContent = 'Edit Admin';
            adminForm.action = `/admin/data-admin/${data.id}`;
            formMethod.value = 'PUT';
            inputs.username.value = data.username;
            inputs.password.value = ''; // kosongkan untuk keamanan
            inputs.fullname.value = data.fullname;
            inputs.roles.value = data.role;
        } else {
            formTitle.textContent = 'Add New Admin';
            adminForm.action = "{{ route('admin.data-admin.store') }}";
            formMethod.value = 'POST';
            Object.values(inputs).forEach(i => i.value = '');
        }
    }

    function hideForm() {
        formContainer.classList.add('hidden');
        tableContainer.classList.remove('hidden');
    }

    btnAddNew.addEventListener('click', () => showForm(false));
    btnCancel.addEventListener('click', hideForm);
    btnCancel2.addEventListener('click', hideForm);

    document.querySelectorAll('.btnEdit').forEach(btn => {
        btn.addEventListener('click', () => {
            showForm(true, {
                id: btn.dataset.id,
                username: btn.dataset.username,
                fullname: btn.dataset.fullname,
                role: btn.dataset.role,
            });
        });
    });

    // Simple search
    const searchInput = document.getElementById('tableSearch');
    const rows = document.querySelectorAll('#adminTable tbody tr');
    searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
        });
    });
});
</script>
@endsection