<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Manage Users &amp; Reports</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">Manage Users</h3>
                            <p class="text-sm text-gray-600 mt-2">Create, edit, and deactivate users.</p>
                        </a>
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">Reports</h3>
                            <p class="text-sm text-gray-600 mt-2">View system usage and outcomes.</p>
                        </a>
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">System Settings</h3>
                            <p class="text-sm text-gray-600 mt-2">Configure system preferences.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


