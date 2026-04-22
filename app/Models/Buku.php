<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'kategori_id',
        'judul_buku',
        'penulis',
        'penerbit',
        'foto_buku',
        'deskripsi',
        'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
