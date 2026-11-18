<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot many-to-many: aksesi_benihs <-> perlakuan_penyimpanans
        Schema::create('aksesi_perlakuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aksesi_benih_id')
                ->constrained('aksesi_benihs')
                ->cascadeOnDelete();
            $table->foreignId('perlakuan_penyimpanan_id')
                ->constrained('perlakuan_penyimpanans')
                ->restrictOnDelete();
            $table->timestamps();

            // Satu perlakuan tidak boleh dipasang dua kali pada aksesi yang sama.
            $table->unique(['aksesi_benih_id', 'perlakuan_penyimpanan_id'], 'aksesi_perlakuan_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aksesi_perlakuan');
    }
};
