@if (session('success') || session('error') || $errors->any())
    <div x-data="{ open: true }" x-show="open" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 p-4"
        @keydown.escape.window="open=false">
        <div @click.outside="open=false"
            class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl border border-gray-100">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ session('success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    <i class="ti {{ session('success') ? 'ti-check' : 'ti-alert-circle' }} text-xl"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-gray-900">{{ session('success') ? 'Success' : 'Action failed' }}</h3>
                    @if (session('success'))
                        <p class="mt-1 text-sm text-gray-600">{{ session('success') }}</p>
                    @elseif(session('error'))
                        <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                    @else
                        <ul class="mt-1 space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <button @click="open=false" class="text-gray-400 hover:text-gray-900"><i class="ti ti-x"></i></button>
            </div>
            <div class="mt-5 flex justify-end">
                <button @click="open=false"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">OK</button>
            </div>
        </div>
    </div>
@endif
