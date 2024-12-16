<div>
    @if (session()->has('message'))
    <div class="mb-10">
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    </div>
    @endif
    <div class="mb-4 flex justify-between">
        <!-- Search Input -->
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul buku..."
            class="border px-4 py-2 rounded bg-slate-800 text-white" />

        <!-- Sorting Info -->
        <div>
            <strong>Sorting:</strong> {{ $sortField }} ({{ strtoupper($sortDirection) }})
        </div>
    </div>

    <!-- Table -->
    <table class="table-auto w-full border-collapse  border-gray-200">
        <thead>
            <tr class="font-bold uppercase border border-slate-900">
                <th class=" px-4 py-2 cursor-pointer" wire:click="sortBy('judul')">
                    Judul
                    @if ($sortField === 'judul')
                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </th>
                <th class=" px-4 py-2">Kategori</th>
                <th class=" px-4 py-2">Pengarang</th>
                <th class=" px-4 py-2 cursor-pointer" wire:click="sortBy('tahun')">
                    Tahun
                    @if ($sortField === 'tahun')
                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr class="{{ $loop->even ? 'bg-slate-700/30' : '' }}">
                    <td class=" px-4 py-5">{{ $book->judul }}</td>
                    <td class=" px-4 py-5">{{ $book->kategori->nama ?? '-' }}</td>
                    <td class=" px-4 py-5">{{ $book->pengarang->nama ?? '-' }}</td>
                    <td class=" px-4 py-5">{{ $book->tahun }}</td>
                    <td class="px-4">
                        <div class="flex justify-end gap-2">
                            <button type="button" wire:click="editBook({{ $book->id }})"
                                class="bg-green-500/20 border inline-block p-1 rounded-full border-green-500 hover:bg-green-700 transition-colors duration-300 ease-linear">
                                <x-icon.edit />
                            </button>
                            <button type="button" wire:click="confirmDelete({{ $book->id }})"
                                class="bg-red-500/20 border inline-block p-1 rounded-full border-red-500 hover:bg-red-700 transition-colors duration-300 ease-linear">
                                <x-icon.trash />
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="bg-red-500/20">
                    <td colspan="5" class="border px-4 py-2 text-center">Tidak ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $books->links() }}
    </div>

    {{-- Edit Modal --}}
    @if ($selectedBook)
        <div
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 ease-out transition-all duration-300">
            <div class="bg-slate-800 p-6 rounded shadow-lg w-1/2">
                <h2 class="text-lg font-bold mb-4">Edit Buku</h2>
                <form wire:submit.prevent="updateBook">
                    <div class="mb-4">
                        <label for="judul" class="block font-medium">Judul</label>
                        <input type="text" id="judul" class="border bg-slate-700 rounded w-full px-3 py-2"
                            wire:model.defer="judul" />
                        @error('judul')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tahun" class="block font-medium">Tahun</label>
                        <input type="number" id="tahun" class="border bg-slate-700 rounded w-1/3 px-3 py-2"
                            wire:model.defer="tahun" />
                        @error('tahun')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kategori_id" class="block font-medium">Kategori</label>
                        <select id="kategori" wire:model.defer="kategori_id" class="w-full bg-slate-700 border rounded px-3 py-2">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="pengarang_id" class="block font-medium">Pengarang</label>
                        <select id="pengarang" wire:model.defer="pengarang_id" class="w-full bg-slate-700 border rounded px-3 py-2">
                            <option value="">Pilih Pengarang</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->nama }}</option>
                            @endforeach
                        </select>
                        @error('pengarang_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500  text-white px-3 py-1 rounded mr-2"
                            wire:click="resetForm">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($deleteBookId)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-slate-800 p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
                <p>Apakah Anda yakin ingin menghapus buku ini?</p>
                <div class="flex justify-end mt-4">
                    <button class="bg-gray-500 text-white px-3 py-1 rounded mr-2" wire:click="resetDelete">
                        Batal
                    </button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded" wire:click="deleteBook">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
