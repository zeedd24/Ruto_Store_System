<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'jenis_identitas',
        'nomor_identitas',
        'status',
        'total_harga',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'total_harga' => 'decimal:2',
        ];
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function transaksi(): HasOne
    {
        return $this->hasOne(Transaksi::class);
    }

    public function scopeMenungguBayar($query)
    {
        return $query->where('status', 'menunggu_bayar');
    }

    public function getLabelIdentitasAttribute(): string
    {
        return "Meja {$this->nomor_identitas}";
    }

    public static function generateKode(): string
    {
        return 'PES-'.now()->format('ymdHis').'-'.random_int(100, 999);
    }
}
