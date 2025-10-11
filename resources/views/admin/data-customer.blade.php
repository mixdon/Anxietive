@extends('layouts.admin')

@section('title', 'Manage Customers | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage Customers</h1>
        <button id="btnAddNew"
            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 transition">
            <i class="fa-solid fa-plus mr-2"></i> Add New Customer
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg shadow-sm">
        <i class="fa-solid fa-circle-check mr-2 text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Form -->
    <div id="formContainer" class="hidden bg-white rounded-xl shadow-md p-6 mb-10 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Customer</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="customerForm" method="POST" action="{{ route('admin.data-customer.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="fullname" id="fullname" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status_aktif" id="status_aktif" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500" required>
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="inactive">Inactive</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="btnCancel2"
                    class="px-4 py-2 text-sm bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 shadow-sm">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div id="tableContainer" class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-800">Customer List</h3>
            <input type="text" id="tableSearch" placeholder="Search customers..."
                class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
        </div>

        <div class="overflow-x-auto">
            <table id="customerTable" class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
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
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $customer->email }}</td>
                        <td class="px-4 py-3">{{ $customer->fullname }}</td>
                        <td class="px-4 py-3">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-4 py-3 capitalize">{{ $customer->status_aktif }}</td>
                        <td class="px-4 py-3 text-center flex justify-center gap-2">
                            <button class="btnEdit w-8 h-8 flex items-center justify-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md"
                                data-id="{{ $customer->id }}"
                                data-email="{{ $customer->email }}"
                                data-fullname="{{ $customer->fullname }}"
                                data-phone="{{ $customer->phone }}"
                                data-status="{{ $customer->status_aktif }}">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </button>

                            <form action="{{ route('admin.data-customer.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Delete this customer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-md">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-6 text-gray-500">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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

    const inputs = {
        email: document.getElementById('email'),
        password: document.getElementById('password'),
        fullname: document.getElementById('fullname'),
        phone: document.getElementById('phone'),
        status_aktif: document.getElementById('status_aktif'),
    };

    function showForm(edit = false, data = {}) {
        formContainer.classList.remove('hidden');
        tableContainer.classList.add('hidden');
        if (edit) {
            formTitle.textContent = 'Edit Customer';
            customerForm.action = `/admin/data-customer/${data.id}`;
            formMethod.value = 'PUT';
            inputs.email.value = data.email;
            inputs.email.readOnly = true;
            inputs.password.value = '';
            inputs.fullname.value = data.fullname;
            inputs.phone.value = data.phone || '';
            inputs.status_aktif.value = data.status;
        } else {
            formTitle.textContent = 'Add New Customer';
            customerForm.action = "{{ route('admin.data-customer.store') }}";
            formMethod.value = 'POST';
            Object.values(inputs).forEach(i => i.value = '');
            inputs.email.readOnly = false;
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
        btn.addEventListener('click', () => showForm(true, {
            id: btn.dataset.id,
            email: btn.dataset.email,
            fullname: btn.dataset.fullname,
            phone: btn.dataset.phone,
            status: btn.dataset.status,
        }));
    });

    // search
    const searchInput = document.getElementById('tableSearch');
    const rows = document.querySelectorAll('#customerTable tbody tr');
    searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        rows.forEach(r => r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none');
    });
});
</script>
@endsection