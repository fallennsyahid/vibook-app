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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan'])->default('pending');
            $table->text('alasan_meminjamn');
            $table->string('bukti_pengambilan')->nullable();
            $table->text('note')->nullable()->comment('Catatan untuk admin jika pengajuan ditolak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
