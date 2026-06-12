<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailLaporanStokBaku extends Model
{
    protected $table = 'detail_laporan_stok_baku';

    protected $fillable = [
        'laporan_stok_baku_id',
        'produk_id',
        'status',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(LaporanStokBaku::class, 'laporan_stok_baku_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
