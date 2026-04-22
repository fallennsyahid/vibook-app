<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali_asli',
        'bukti_pengembalian',
        'kondisi',
        'catatan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
