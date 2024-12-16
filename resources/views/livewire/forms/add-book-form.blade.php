<div>
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label for="judul" class="block text-white mb-1">Judul Buku</label>
            <input type="text" id="judul" wire:model="judul" class="w-full bg-slate-800 border rounded px-3 py-2">
            @error('judul') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="tahun" class="block text-white mb-1">Tahun</label>
            <input type="number" id="tahun" wire:model="tahun" class="w-1/3 bg-slate-800 border rounded px-3 py-2">
            @error('tahun') <span class="text-red-500 block">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-white mb-1">Kategori</label>
            <select id="kategori" wire:model="kategori_id" class="w-full bg-slate-800 border rounded px-3 py-2">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
            @error('kategori_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="pengarang" class="block text-white mb-1">Pengarang</label>
            <select id="pengarang" wire:model="pengarang_id" class="w-full bg-slate-800 border rounded px-3 py-2">
                <option value="">Pilih Pengarang</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->nama }}</option>
                @endforeach
            </select>
            @error('pengarang_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end mt-10">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-full hover:bg-orange-800">Tambah Buku</button>
        </div>
    </form>
</div>
