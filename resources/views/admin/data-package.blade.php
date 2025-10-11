@extends('layouts.admin')

@section('title', 'Manage Packages | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-3">
        <h1 class="text-3xl font-bold text-gray-800">Manage Packages</h1>
        <button id="btnAddNew"
            class="inline-flex items-center px-5 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 transition">
            <i class="fa-solid fa-plus mr-2"></i> Add New Package
        </button>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg shadow-sm flex items-center">
        <i class="fa-solid fa-circle-check mr-2 text-green-500"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Create / Edit -->
    <div id="formContainer" class="hidden bg-white rounded-xl shadow-md p-6 mb-10 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 id="formTitle" class="text-xl font-semibold text-gray-800">Add New Package</h2>
            <button id="btnCancel" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="packageForm" method="POST" action="{{ route('admin.data-package.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="package_id" id="packageId">

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
                    <input type="text" name="amount_display" id="amount" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    <input type="hidden" name="amount" id="amountHidden">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                    <img id="imagePreview"
                        class="mt-3 w-20 h-20 object-cover rounded-md hidden border border-gray-200 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail Duration (comma separated)</label>
                    <input type="text" name="detail_duration_input" id="detail_duration_input"
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
        <div class="p-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:flex-nowrap">
            <h3 class="text-lg font-semibold text-gray-800 whitespace-nowrap">Package List</h3>
            <input type="text" id="tableSearch" placeholder="Search packages..."
                class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
        </div>

        <div class="overflow-x-auto">
            <table id="packageTable" class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b">
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
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $package->judul_package }}</td>
                        <td class="px-4 py-3">{{ $package->id_office }}</td>
                        <td class="px-4 py-3">{{ $package->times }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($package->amount,0,',','.') }}</td>
                        <td class="px-4 py-3">
                            @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}"
                                class="w-10 h-10 object-cover rounded-md border">
                            @else
                            <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <button
                                    class="btnEdit flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                                    data-id="{{ $package->id }}" data-judul="{{ $package->judul_package }}"
                                    data-id_office="{{ $package->id_office }}" data-times="{{ $package->times }}"
                                    data-amount="{{ $package->amount }}" data-image="{{ $package->image }}"
                                    data-detail="{{ implode(',', $package->detail_duration ?? []) }}">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.data-package.destroy', $package->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this package?')"
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
    const packageForm = document.getElementById('packageForm');
    const formMethod = document.getElementById('formMethod');
    const formTitle = document.getElementById('formTitle');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const searchInput = document.getElementById('tableSearch');
    const rows = document.querySelectorAll('#packageTable tbody tr');

    const inputs = {
        judul_package: document.getElementById('judul_package'),
        id_office: document.getElementById('id_office'),
        times: document.getElementById('times'),
        amount: document.getElementById('amount'),
        amountHidden: document.getElementById('amountHidden'),
        detail_duration_input: document.getElementById('detail_duration_input')
    };

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    inputs.amount.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            this.value = "Rp " + formatRupiah(value);
            inputs.amountHidden.value = value;
        } else {
            this.value = '';
            inputs.amountHidden.value = '';
        }
    });

    // Image Preview
    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
        }
    });

    function showForm(editMode = false, data = null) {
        formContainer.classList.remove('hidden');
        tableContainer.classList.add('hidden');

        if (editMode && data) {
            formTitle.textContent = 'Edit Package';
            packageForm.action = `/admin/data-package/${data.id}`;
            formMethod.value = 'PUT';

            inputs.judul_package.value = data.judul;
            inputs.id_office.value = data.id_office;
            inputs.times.value = data.times;
            inputs.amount.value = data.amount ? "Rp " + formatRupiah(data.amount) : '';
            inputs.amountHidden.value = data.amount || '';
            inputs.detail_duration_input.value = data.detail;

            if (data.image) {
                imagePreview.src = `/storage/${data.image}`;
                imagePreview.classList.remove('hidden');
            } else {
                imagePreview.classList.add('hidden');
            }
        } else {
            formTitle.textContent = 'Add New Package';
            packageForm.action = "{{ route('admin.data-package.store') }}";
            formMethod.value = 'POST';
            Object.values(inputs).forEach(i => i.value = '');
            imageInput.value = '';
            imagePreview.classList.add('hidden');
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
                judul: btn.dataset.judul,
                id_office: btn.dataset.id_office,
                times: btn.dataset.times,
                amount: btn.dataset.amount,
                image: btn.dataset.image,
                detail: btn.dataset.detail
            });
        });
    });

    // Search / filter table
    searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // Submit: handle detail_duration JSON & amount
    packageForm.addEventListener('submit', function () {
        const arr = inputs.detail_duration_input.value.split(',')
            .map(i => i.trim())
            .filter(i => i !== '');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'detail_duration';
        hiddenInput.value = JSON.stringify(arr);
        packageForm.appendChild(hiddenInput);

        let value = inputs.amount.value.replace(/\D/g, '');
        inputs.amountHidden.value = value;
    });
});
</script>
@endsection