<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas'; // Manual karena Laravel mungkin anggap jamak 'log_aktifitas'
    protected $fillable = ['user_id', 'aksi', 'entitas', 'keterangan_dan_detail'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
