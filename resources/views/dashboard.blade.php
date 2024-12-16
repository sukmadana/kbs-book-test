<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:table.book-table />
                </div>
            </div>
        </div>
        <a href="{{ route('buku.create') }}" class="fixed bottom-8 right-8 shadow-lg w-auto bg-orange-500 hover:bg-orange-700 text-white font-bold p-4 rounded-full transition duration-300 ease-linear button-add">
            <x-icon.plus/> <span class="button-add-text absolute invisible opacity-0">Tambah Buku</span>
        </a>
    </div>
</x-app-layout>
