<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    protected $fillable = ['peminjaman_id', 'buku_id', 'jumlah'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
