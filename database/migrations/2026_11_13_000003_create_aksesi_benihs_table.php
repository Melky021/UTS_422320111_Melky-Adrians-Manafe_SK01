<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aksesi_benihs', function (Blueprint $table) {
            $table->id();
            // Kelompok tanaman tidak boleh dihapus selama masih dipakai aksesi.
            $table->foreignId('kelompok_tanaman_id')
                ->constrained('kelompok_tanamans')
                ->restrictOnDelete();
            $table->string('kode_aksesi', 20)->unique();
            $table->string('nama_aksesi', 120);
            $table->string('nama_ilmiah', 150)->nullable();
            $table->decimal('stok_gram', 8, 2)->default(0);
            $table->enum('status', ['tersimpan', 'perlu_regenerasi', 'habis'])
                ->default('tersimpan');
            $table->timestamps();

            // Pola query: pencarian nama & filter kelompok + status.
            $table->index('nama_aksesi');
            $table->index(['kelompok_tanaman_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aksesi_benihs');
    }
};
