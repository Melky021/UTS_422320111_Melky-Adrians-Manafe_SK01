<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PerlakuanPenyimpanan extends Model
{
    protected $table = 'perlakuan_penyimpanans';

    protected $fillable = ['nama', 'deskripsi'];

    public function aksesis(): BelongsToMany
    {
        return $this->belongsToMany(
            AksesiBenih::class,
            'aksesi_perlakuan',
            'perlakuan_penyimpanan_id',
            'aksesi_benih_id'
        )->withTimestamps();
    }
}
