<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'kategori_id', 'pengarang_id', 'tahun'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'pengarang_id');
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where('judul', 'like', '%' . $term . '%');
        }
        return $query;
    }

    public function scopeSort($query, $field, $direction)
    {
        return $query->orderBy($field, $direction);
    }
}
