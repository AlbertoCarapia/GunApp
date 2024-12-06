<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
                 <div class="rounded-lg bg-white">
                     @livewire('record-controller')
                </div>
                <br>
                <div class="p-6 mr-24 ml-24 rounded-lg bg-white">
                    @livewire('record-management')
                </div>
    </div>
</x-app-layout>
