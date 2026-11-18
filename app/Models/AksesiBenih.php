<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AksesiBenih extends Model
{
    protected $table = 'aksesi_benihs';

    public const STATUS = [
        'tersimpan'        => 'Tersimpan',
        'perlu_regenerasi' => 'Perlu Regenerasi',
        'habis'            => 'Habis',
    ];

    protected $fillable = [
        'kelompok_tanaman_id',
        'kode_aksesi',
        'nama_aksesi',
        'nama_ilmiah',
        'stok_gram',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'stok_gram' => 'decimal:2',
        ];
    }

    /* ---------------- Relasi ---------------- */

    // Many-to-one: banyak aksesi milik satu kelompok tanaman
    public function kelompokTanaman(): BelongsTo
    {
        return $this->belongsTo(KelompokTanaman::class, 'kelompok_tanaman_id');
    }

    // One-to-one: satu aksesi punya satu detail asal pengumpulan
    public function asalPengumpulan(): HasOne
    {
        return $this->hasOne(AsalPengumpulan::class, 'aksesi_benih_id');
    }

    // Many-to-many: satu aksesi dapat memperoleh beberapa perlakuan
    public function perlakuans(): BelongsToMany
    {
        return $this->belongsToMany(
            PerlakuanPenyimpanan::class,
            'aksesi_perlakuan',
            'aksesi_benih_id',
            'perlakuan_penyimpanan_id'
        )->withTimestamps();
    }

    /* ---------------- Accessor & Mutator ---------------- */

    protected function kodeAksesi(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper(trim($value)),
        );
    }

    protected function namaAksesi(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower(trim($value))),
        );
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::STATUS[$this->status] ?? $this->status,
        );
    }

    protected function statusTone(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'tersimpan'        => 'ok',
                'perlu_regenerasi' => 'warn',
                default            => 'danger',
            },
        );
    }

    protected function identitas(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->kode_aksesi} - {$this->nama_aksesi}",
        );
    }

    /* ---------------- Local Scope ---------------- */

    public function scopeSearch(Builder $query, ?string $keyword): void
    {
        $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('kode_aksesi', 'like', "%{$keyword}%")
                    ->orWhere('nama_aksesi', 'like', "%{$keyword}%")
                    ->orWhere('nama_ilmiah', 'like', "%{$keyword}%")
                    ->orWhereHas('asalPengumpulan', function ($q) use ($keyword) {
                        $q->where('kabupaten', 'like', "%{$keyword}%")
                            ->orWhere('provinsi', 'like', "%{$keyword}%");
                    });
            });
        });
    }

    public function scopeKelompokId(Builder $query, ?int $id): void
    {
        $query->when($id, fn ($q, $id) => $q->where('kelompok_tanaman_id', $id));
    }

    public function scopePerlakuanId(Builder $query, ?int $id): void
    {
        $query->when($id, function ($q, $id) {
            $q->whereHas('perlakuans', fn ($p) => $p->where('perlakuan_penyimpanans.id', $id));
        });
    }

    public function scopeStatus(Builder $query, ?string $status): void
    {
        $query->when(
            $status && array_key_exists($status, self::STATUS),
            fn ($q) => $q->where('status', $status)
        );
    }
}
