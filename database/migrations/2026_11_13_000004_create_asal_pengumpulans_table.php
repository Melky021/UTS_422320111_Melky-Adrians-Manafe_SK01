<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asal_pengumpulans', function (Blueprint $table) {
            $table->id();
            // unique() pada FK = menjamin relasi ONE-TO-ONE.
            $table->foreignId('aksesi_benih_id')
                ->unique()
                ->constrained('aksesi_benihs')
                ->cascadeOnDelete();
            $table->string('desa', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten', 100);
            $table->string('provinsi', 100);
            $table->date('tanggal_koleksi');
            $table->string('kolektor', 100);
            $table->unsignedSmallInteger('ketinggian_mdpl')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('provinsi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asal_pengumpulans');
    }
};
