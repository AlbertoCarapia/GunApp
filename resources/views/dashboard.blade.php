<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white">
                    @livewire('create-delivery')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-magazine')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-officer')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-record')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-weapon')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-weapon-type')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('create-l-type')
                </div>
                <br>
                <br>
                <div class="rounded-lg bg-white">
                    @livewire('delivery-component')
                </div>
        </div>
    </div>
</x-app-layout>
