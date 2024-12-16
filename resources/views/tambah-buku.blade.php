<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-5 items-center">
            <a href="{{ route('home') }}" class="font-semibold text-gray-800 dark:text-gray-400 hover:dark:text-gray-600 leading-tight flex items-center gap-1">
                <x-icon.left/> Kembali</a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Buku') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:forms.add-book-form />
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
