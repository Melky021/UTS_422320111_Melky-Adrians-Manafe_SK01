<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokTanaman extends Model
{
    protected $table = 'kelompok_tanamans';

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function aksesis(): HasMany
    {
        return $this->hasMany(AksesiBenih::class, 'kelompok_tanaman_id');
    }
}
