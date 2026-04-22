<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = [
        'nama_kategori',
        'slug',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama_kategori);
            }
        });
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
