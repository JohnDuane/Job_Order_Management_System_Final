@props(['sidebar' => false])

@if ($sidebar)
    <flux:sidebar.brand
        :name="config('app.name', 'BSA Auto Repair Shop')"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="size-8 object-contain"
            />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand
        :name="config('app.name', 'BSA Auto Repair Shop')"
        {{ $attributes }}
    >
        <x-slot name="logo">
            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="size-8 object-contain"
            />
        </x-slot>
    </flux:brand>
@endif