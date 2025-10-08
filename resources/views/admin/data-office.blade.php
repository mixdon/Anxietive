@extends('layouts.admin')

@section('title', 'Manage Offices | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Offices</h1>
        <button id="btnAddNew"
            class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-purple-500 transition">
            <i class="fa-solid fa-plus mr-2"></i> Add New Office
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Create / Edit -->
    <div id="formContainer" class="hidden bg-white rounded-xl shadow p-6 mb-8 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h2 id="formTitle" class="text-lg font-semibold text-gray-700">Add New Office</h2>
            <button id="btnCancel" class="text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="officeForm" method="POST" action="{{ route('admin.data-office.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Office Name</label>
                    <input type="text" name="office_name" id="office_name" required
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-400 focus:border-purple-400 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                    <input type="text" name="address" id="address"
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-400 focus:border-purple-400 outline-none">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" id="btnCancel2"
                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-500 transition">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div id="tableContainer" class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Office List</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
                    <tr>
                        <th class="px-6 py-3 font-medium">#</th>
                        <th class="px-6 py-3 font-medium">Office Name</th>
                        <th class="px-6 py-3 font-medium">Address</th>
                        <th class="px-6 py-3 font-medium text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($offices as $office)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 font-medium">{{ $office->office_name }}</td>
                        <td class="px-6 py-3">{{ $office->address }}</td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">

                                <!-- Edit with tooltip -->
                                <div class="relative group">
                                    <button class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 transition rounded-lg bg-gray-50 hover:bg-gray-100"
                                        data-id="{{ $office->id }}"
                                        data-office_name="{{ $office->office_name }}"
                                        data-address="{{ $office->address }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <span
                                        class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded">
                                        Edit Data
                                    </span>
                                </div>

                                <!-- Delete with tooltip -->
                                <div class="relative group">
                                    <form action="{{ route('admin.data-office.destroy', $office->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this office?')"
                                            class="flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 transition rounded-lg bg-gray-50 hover:bg-gray-100">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <span
                                        class="absolute bottom-full mb-2 hidden group-hover:block px-2 py-1 text-xs text-white bg-gray-800 rounded">
                                        Delete Data
                                    </span>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No offices found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    const btnAddNew = document.getElementById('btnAddNew');
    const btnCancel = document.getElementById('btnCancel');
    const btnCancel2 = document.getElementById('btnCancel2');
    const formContainer = document.getElementById('formContainer');
    const tableContainer = document.getElementById('tableContainer');
    const officeForm = document.getElementById('officeForm');
    const formMethod = document.getElementById('formMethod');
    const formTitle = document.getElementById('formTitle');

    const inputs = {
        office_name: document.getElementById('office_name'),
        address: document.getElementById('address'),
    };

    function showForm(editMode = false, data = null) {
        formContainer.classList.remove('hidden');
        tableContainer.classList.add('hidden');
        if (editMode && data) {
            formTitle.textContent = 'Edit Office';
            officeForm.action = `/admin/data-office/${data.id}`;
            formMethod.value = 'PUT';
            inputs.office_name.value = data.office_name;
            inputs.address.value = data.address;
        } else {
            formTitle.textContent = 'Add New Office';
            officeForm.action = "{{ route('admin.data-office.store') }}";
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
                office_name: btn.dataset.office_name,
                address: btn.dataset.address,
            });
        });
    });
</script>
@endsection