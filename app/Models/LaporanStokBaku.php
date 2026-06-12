<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanStokBaku extends Model
{
    protected $table = 'laporan_stok_baku';

    protected $fillable = [
        'user_id',
        'tanggal',
        'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailLaporanStokBaku::class, 'laporan_stok_baku_id');
    }
}
