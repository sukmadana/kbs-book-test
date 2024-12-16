<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;

class AddBookForm extends Component
{
    public $judul;
    public $kategori_id;
    public $tahun;
    public $pengarang_id;

    public $categories = [];
    public $authors = [];

    protected $rules = [
        'judul' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'tahun' => 'required|integer|min:1000|max:9999',
        'pengarang_id' => 'required|exists:pengarangs,id',
    ];

    public function mount()
    {
        $this->categories = Kategori::all();
        $this->authors = Pengarang::all();
    }

    public function submit()
    {
        $this->validate();

        Buku::create([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori_id,
            'tahun' => $this->tahun,
            'pengarang_id' => $this->pengarang_id,
        ]);

        session()->flash('message', 'Buku berhasil ditambahkan!');

        $this->reset(['judul', 'kategori_id', 'tahun', 'pengarang_id']);
        return $this->redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.forms.add-book-form');
    }
}
