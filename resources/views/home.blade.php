<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Jobs</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">Software Engineer</h4>
                        <p class="mt-2 text-sm text-gray-600">Build and ship features.</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">View</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">Product Manager</h4>
                        <p class="mt-2 text-sm text-gray-600">Own product roadmap.</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">View</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">UX Designer</h4>
                        <p class="mt-2 text-sm text-gray-600">Design delightful experiences.</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">View</button>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Scholarships</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">STEM Excellence</h4>
                        <p class="mt-2 text-sm text-gray-600">Deadline: 2025-12-31</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Details</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">Women in Tech</h4>
                        <p class="mt-2 text-sm text-gray-600">Deadline: 2025-10-15</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Details</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="font-medium text-gray-900">Community Leaders</h4>
                        <p class="mt-2 text-sm text-gray-600">Deadline: 2026-01-10</p>
                        <button class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


