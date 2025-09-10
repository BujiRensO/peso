<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Post &amp; Manage Listings</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">Post Job</h3>
                            <p class="text-sm text-gray-600 mt-2">Create a new job listing.</p>
                        </a>
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">Post Scholarship</h3>
                            <p class="text-sm text-gray-600 mt-2">Create a new scholarship listing.</p>
                        </a>
                        <a href="#" class="block p-6 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-gray-900">Manage Applications</h3>
                            <p class="text-sm text-gray-600 mt-2">View incoming applications.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


