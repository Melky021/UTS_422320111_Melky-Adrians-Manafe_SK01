<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsalPengumpulan extends Model
{
    protected $table = 'asal_pengumpulans';

    protected $fillable = [
        'aksesi_benih_id',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'tanggal_koleksi',
        'kolektor',
        'ketinggian_mdpl',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_koleksi' => 'date',
        ];
    }

    public function aksesiBenih(): BelongsTo
    {
        return $this->belongsTo(AksesiBenih::class, 'aksesi_benih_id');
    }

    public function getLokasiLengkapAttribute(): string
    {
        return "{$this->desa}, {$this->kecamatan}, {$this->kabupaten}, {$this->provinsi}";
    }
}
