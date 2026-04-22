<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->date('tanggal_kembali_asli');
            $table->string('bukti_pengembalian')->nullable();
            $table->enum('kondisi', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->text('catatan')->nullable()->comment('Catatan untuk admin jika kondisi buku rusak atau hilang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
