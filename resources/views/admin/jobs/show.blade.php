<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Listing Details') }}
            </h2>
            <a href="{{ route('admin.jobs') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">← Back to Jobs</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-lg text-gray-600 mt-1">{{ $job->employer }}</p>
                            <p class="text-sm text-gray-500 mt-2">Posted: {{ $job->posted_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($job->status === 'approved') bg-green-100 text-green-800
                                @elseif($job->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($job->status === 'rejected') bg-red-100 text-red-800
                                @elseif($job->status === 'expired') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($job->status ?? 'pending') }}
                            </span>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Job Description</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $job->description }}</div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Actions</h3>
                        <div class="flex items-center space-x-4">
                            @if($job->status === 'pending')
                            <form method="POST" action="{{ route('admin.jobs.status', $job) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:ring-2 focus:ring-green-500">
                                    Approve Job
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.jobs.status', $job) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500">
                                    Reject Job
                                </button>
                            </form>
                            @elseif($job->status === 'approved')
                            <form method="POST" action="{{ route('admin.jobs.status', $job) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="expired">
                                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:ring-2 focus:ring-gray-500">
                                    Mark as Expired
                                </button>
                            </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.jobs.delete', $job) }}" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this job listing? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500">
                                    Delete Job
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
