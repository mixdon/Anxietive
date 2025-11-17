@extends('layouts.admin')

@section('title', 'Configuration | Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- PAGE HEADER -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">System Configuration</h1>

    <!-- TABS -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex flex-wrap gap-6" id="configTabs">
            <button data-tab="general"
                class="tabButton active text-purple-600 font-semibold py-2 border-b-2 border-purple-600">
                General Settings
            </button>

            <button data-tab="roles"
                class="tabButton text-gray-600 hover:text-gray-800 py-2">
                User Roles
            </button>

            <button data-tab="logs"
                class="tabButton text-gray-600 hover:text-gray-800 py-2">
                System Logs
            </button>
        </nav>
    </div>

    <!-- TAB 1 — GENERAL SETTINGS -->
    <div id="tab_general" class="tabContent">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">General Settings</h2>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm shadow-sm hover:bg-purple-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> Add Setting
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">Setting</th>
                        <th class="px-4 py-3 text-center">Value</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-left font-medium text-gray-800">Website Title</td>
                        <td class="px-4 py-3 text-left text-gray-700">My Application</td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 mx-2">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-left font-medium text-gray-800">Timezone</td>
                        <td class="px-4 py-3 text-left text-gray-700">Asia/Jakarta</td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 mx-2">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

    <!-- TAB 2 — USER ROLES -->
    <div id="tab_roles" class="tabContent hidden">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">User Roles</h2>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm shadow-sm hover:bg-purple-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> Add Role
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center">Role Name</th>
                        <th class="px-4 py-3 text-center">Users</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-left font-medium text-gray-800">Admin</td>
                        <td class="px-4 py-3 text-left text-gray-700">5 Users</td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 mx-2">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-left font-medium text-gray-800">Editor</td>
                        <td class="px-4 py-3 text-left text-gray-700">12 Users</td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-blue-600 hover:text-blue-800 mx-2">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

    <!-- TAB 3 — SYSTEM LOGS -->
    <div id="tab_logs" class="tabContent hidden">

        <h2 class="text-xl font-semibold mb-4 text-gray-800">System Logs</h2>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <ul class="space-y-3 text-sm text-gray-700">
                <li>• User <strong>Admin</strong> updated settings – 10:21 AM</li>
                <li>• New user created – 09:12 AM</li>
                <li>• Role updated by <strong>Editor</strong> – Yesterday</li>
                <li>• Server restarted – Yesterday</li>
            </ul>
        </div>
    </div>

</div>

<!-- TAB SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const tabButtons = document.querySelectorAll(".tabButton");
    const tabContents = document.querySelectorAll(".tabContent");

    tabButtons.forEach(btn => {
        btn.addEventListener("click", () => {

            tabButtons.forEach(b =>
                b.classList.remove("active", "text-purple-600", "border-purple-600", "border-b-2"));

            tabContents.forEach(c => c.classList.add("hidden"));

            btn.classList.add("active", "text-purple-600", "border-b-2", "border-purple-600");
            document.getElementById("tab_" + btn.dataset.tab).classList.remove("hidden");
        });
    });
});
</script>
@endsection