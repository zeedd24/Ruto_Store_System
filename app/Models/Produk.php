<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'harga_modal',
        'harga_jual',
        'stok',
        'status',
        'gambar',
    ];

    protected $appends = [
        'gambar_url',
    ];

    protected function casts(): array
    {
        return [
            'harga_modal' => 'decimal:2',
            'harga_jual' => 'decimal:2',
        ];
    }

    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }

        // Return a relative URL so it works regardless of APP_URL/port during local dev.
        return '/storage/'.$this->gambar;
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function stokMasuk(): HasMany
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
