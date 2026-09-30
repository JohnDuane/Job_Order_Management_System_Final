<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-mechanic-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <h1 class="text-2xl font-medium">Mechanic dashboard</h1>
                <p class="text-sm text-gray-500 mt-1 mb-6">Welcome back, {{ auth()->user()->name }}</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500">Assigned</p>
                        <p class="text-2xl font-medium">{{ $recentJobs->where('status', 'assigned')->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500">In progress</p>
                        <p class="text-2xl font-medium">{{ $recentJobs->where('status', 'in_progress')->count() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500">Completed this year</p>
                        <p class="text-2xl font-medium">{{ $jobCountYear }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-xs text-gray-500">Needs revision</p>
                        <p class="text-2xl font-medium">
                            {{ \App\Models\JobOrder::where('created_by', auth()->id())->where('status', 'needs_revision')->count() }}
                        </p>
                    </div>
                </div><a href="{{ route('mechanic.CJO') }}"
                    class="inline-flex rounded-lg bg-gray-900 text-white px-4 py-2.5 text-sm">Create job order</a>
            </main>
        </div>
    </div>
</x-app-layout>
