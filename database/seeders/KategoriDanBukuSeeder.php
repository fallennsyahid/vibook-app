<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriDanBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiksi = Kategori::create([
            'nama_kategori' => 'Fiksi',
            'slug' => Str::slug('Fiksi'),
            'status' => Status::ACTIVE->value,
        ]);

        Buku::create([
            'kategori_id' => $fiksi->id,
            'judul_buku' => 'Harry Potter dan Batu Bertuah',
            'penulis' => 'J.K. Rowling',
            'penerbit' => 'Gramedia',
            'foto_buku' => "https://placehold.co/1748x2480/png",
            'stok' => 10,
            'deskripsi' => 'Buku pertama dalam seri Harry Potter yang mengikuti petualangan seorang anak yatim piatu yang menemukan bahwa dia adalah seorang penyihir.',
        ]);
    }
}
