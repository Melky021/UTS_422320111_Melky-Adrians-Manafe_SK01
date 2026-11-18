<?php

namespace App\Services;

use App\Models\AksesiBenih;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Service untuk operasi multi-tabel (aksesi + asal pengumpulan + perlakuan).
 * Semua write dibungkus DB::transaction agar atomik: jika salah satu gagal,
 * seluruh perubahan di-rollback dan tidak ada data setengah jadi.
 */
class AksesiBenihService
{
    private const FIELD_UTAMA = [
        'kelompok_tanaman_id',
        'kode_aksesi',
        'nama_aksesi',
        'nama_ilmiah',
        'stok_gram',
        'status',
    ];

    public function buat(array $data): AksesiBenih
    {
        return DB::transaction(function () use ($data) {
            $aksesi = AksesiBenih::create(Arr::only($data, self::FIELD_UTAMA));

            $aksesi->asalPengumpulan()->create($data['asal']);
            $aksesi->perlakuans()->sync($data['perlakuan_ids'] ?? []);

            return $aksesi;
        });
    }

    public function ubah(AksesiBenih $aksesi, array $data): AksesiBenih
    {
        return DB::transaction(function () use ($aksesi, $data) {
            $aksesi->update(Arr::only($data, self::FIELD_UTAMA));

            $aksesi->asalPengumpulan()->updateOrCreate(
                ['aksesi_benih_id' => $aksesi->id],
                $data['asal']
            );

            $aksesi->perlakuans()->sync($data['perlakuan_ids'] ?? []);

            return $aksesi;
        });
    }

    public function hapus(AksesiBenih $aksesi): void
    {
        // asal_pengumpulans & aksesi_perlakuan ikut terhapus (cascadeOnDelete di migration)
        DB::transaction(fn () => $aksesi->delete());
    }
}
