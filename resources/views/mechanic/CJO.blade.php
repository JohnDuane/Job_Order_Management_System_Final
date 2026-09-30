<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen">
            <x-mechanic-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-medium">{{ isset($jobOrder) ? 'Revise job order' : 'Create job order' }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ isset($jobOrder) ? 'Update the requested details and resubmit for approval.' : 'Create a new job order for a customer vehicle.' }}
                    </p>
                </div>
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><b>Please
                            correct the following:</b>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST"
                    action="{{ isset($jobOrder) ? route('mechanic.job-orders.update', $jobOrder) : route('mechanic.job-orders.store') }}"
                    class="max-w-4xl flex flex-col gap-5" x-data="{ customer: '{{ old('cust_id', $jobOrder->cust_id ?? '') }}' }">
                    @csrf
                    @if (isset($jobOrder))
                        @method('PUT')
                    @endif
                    <div class="bg-white border border-gray-200 rounded-xl p-5">
                        <p class="font-medium">Customer and vehicle</p>
                        <p class="text-xs text-gray-500 mt-1 mb-5">Select the customer and vehicle for this job order.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium mb-1.5">Customer</label><select name="cust_id"
                                    x-model="customer" required
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg">
                                    <option value="">Select customer</option>
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->cust_id }}">{{ $c->first_name }} {{ $c->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div><label class="block text-sm font-medium mb-1.5">Vehicle</label><select
                                    name="vehicle_id" required
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg">
                                    <option value="">Select vehicle</option>
                                    @foreach ($customers as $c)
                                        @foreach ($c->vehicles as $v)
                                            <option value="{{ $v->vehicle_id }}"
                                                x-show="customer == '{{ $c->cust_id }}'">{{ $v->make }} ·
                                                {{ $v->plate_number }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-xl p-5">
                        <p class="font-medium">Service details</p>
                        <p class="text-xs text-gray-500 mt-1 mb-5">Select one or more services and describe the problem.
                        </p>
                        <div class="mb-4"><label class="block text-sm font-medium mb-1.5">Services</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach ($services as $service)
                                    <label
                                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:bg-gray-50"><input
                                            type="checkbox" name="service_ids[]" value="{{ $service->service_id }}"
                                            @checked(in_array(
                                                    $service->service_id,
                                                    old('service_ids', isset($jobOrder) ? $jobOrder->services->pluck('service_id')->all() : [])))><span
                                            class="flex-1 text-sm">{{ $service->service_name }}</span><span
                                            class="text-xs text-gray-500">₱{{ number_format($service->price, 2) }}</span></label>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4"><label class="block text-sm font-medium mb-1.5">Problem description</label>
                            <textarea name="problem_description" rows="4" required
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg resize-none"
                                placeholder="Describe the customer's reported vehicle problem...">{{ old('problem_description', $jobOrder->problem_description ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium mb-1.5">Expected completion</label><input
                                    type="date" name="expected_empl_date"
                                    value="{{ old('expected_empl_date', isset($jobOrder) && $jobOrder->expected_empl_date ? $jobOrder->expected_empl_date->format('Y-m-d') : '') }}"
                                    min="{{ now()->toDateString() }}"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg"></div>
                            <div><label class="block text-sm font-medium mb-1.5">Remarks</label><input name="remarks"
                                    value="{{ old('remarks', $jobOrder->remarks ?? '') }}"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg"
                                    placeholder="Optional remarks"></div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2"><a href="{{ route('mechanic.MJO') }}"
                            class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm">Cancel</a><button
                            type="submit"
                            class="rounded-lg bg-gray-900 text-white px-4 py-2.5 text-sm hover:bg-gray-800"
                            onclick="return confirm('{{ isset($jobOrder) ? 'Resubmit this revised job order for supervisor approval?' : 'Submit this job order for supervisor approval?' }}')">{{ isset($jobOrder) ? 'Resubmit for approval' : 'Submit for approval' }}</button>
                    </div>
                </form>
            </main>
        </div>
    </div>
</x-app-layout>
