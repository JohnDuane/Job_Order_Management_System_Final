<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-supervisor-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <h1 class="text-2xl font-medium">Approval history</h1>
                <p class="text-sm text-gray-500 mt-1 mb-6">A record of supervisor approval and revision decisions.</p>
                <div class="overflow-x-auto rounded-xl border">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50 text-left text-gray-500">
                                <th class="p-4">JO</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Decision</th>
                                <th class="p-4">Supervisor</th>
                                <th class="p-4">Date</th>
                                <th class="p-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($approvals as $a)
                                <tr class="border-b last:border-0">
                                    <td class="p-4 font-medium">{{ $a->jobOrder->code }}</td>
                                    <td class="p-4">{{ $a->jobOrder->customer->first_name }}
                                        {{ $a->jobOrder->customer->last_name }}</td>
                                    <td class="p-4">{{ str_replace('_', ' ', ucwords($a->status)) }}</td>
                                    <td class="p-4">{{ $a->approvedBy->name }}</td>
                                    <td class="p-4">{{ $a->action_date->format('M d, Y') }}</td>
                                    <td class="p-4 text-gray-600">{{ $a->remarks ?: '—' }}</td>
                            </tr>@empty<tr>
                                    <td colspan="6" class="p-10 text-center text-gray-500">No approval history yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $approvals->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
