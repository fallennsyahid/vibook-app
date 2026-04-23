<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status',
        'alasan_meminjamn',
        'bukti_pengambilan',
        'note',
    ];

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
