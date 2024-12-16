<?php

namespace App\Livewire\Table;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;

class BookTable extends Component
{
    use WithPagination;

    public $sortField = 'judul';
    public $sortDirection = 'asc';
    public $search = '';

    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public $selectedBook = null;
    public $judul, $kategori_id, $tahun, $pengarang_id;

    public $deleteBookId = null;
    public $categories = [];
    public $authors = [];

    protected $rules = [
        'judul' => 'required|string|max:255',
        'kategori_id' => 'required|integer|exists:kategoris,id',
        'tahun' => 'required|integer|min:1000|max:9999',
        'pengarang_id' => 'required|integer|exists:pengarangs,id',
    ];

    public function mount()
    {
        $this->categories = Kategori::all();
        $this->authors = Pengarang::all();
    }

    public function editBook($id)
    {
        $book = Buku::findOrFail($id);

        $this->selectedBook = $book->id;
        $this->judul = $book->judul;
        $this->kategori_id = $book->kategori_id;
        $this->tahun = $book->tahun;
        $this->pengarang_id = $book->pengarang_id;
    }

    public function updateBook()
    {
        $this->validate();

        Buku::where('id', $this->selectedBook)->update([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori_id,
            'tahun' => $this->tahun,
            'pengarang_id' => $this->pengarang_id,
        ]);

        $this->reset(['selectedBook', 'judul', 'kategori_id', 'tahun', 'pengarang_id']);
        session()->flash('message', 'Buku berhasil diperbarui!');
    }

    public function resetForm()
    {
        $this->reset(['selectedBook', 'judul', 'kategori_id', 'tahun', 'pengarang_id']);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteBookId = $id;
    }

    public function deleteBook()
    {
        Buku::findOrFail($this->deleteBookId)->delete();

        $this->deleteBookId = null;

        session()->flash('message', 'Buku berhasil dihapus!');
    }

    public function resetDelete()
    {
        $this->deleteBookId = null;
    }

    public function render()
    {
        $books = Buku::with(['kategori', 'pengarang'])
        ->search($this->search)
        ->sort($this->sortField, $this->sortDirection)
        ->paginate(10);

        return view('livewire.table.book-table', ['books' => $books]);
    }
}
