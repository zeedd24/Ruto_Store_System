<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';

    protected $fillable = [
        'produk_id',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
