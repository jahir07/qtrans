<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Packages') }}
        </h2>
    </x-slot>

    <div class="bg-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg">
               <livewire:packages />
            </div>
        </div>
    </div>
</x-app-layout>
