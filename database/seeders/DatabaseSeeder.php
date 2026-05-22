<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ruto.store'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@ruto.store'],
            [
                'name' => 'Kasir Utama',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );

        $kategoriMinuman = Kategori::firstOrCreate(['nama_kategori' => 'Minuman']);
        $kategoriMakanan = Kategori::firstOrCreate(['nama_kategori' => 'Makanan']);
        $kategoriSnack = Kategori::firstOrCreate(['nama_kategori' => 'Snack']);

        $produkData = [
            ['kategori_id' => $kategoriMinuman->id, 'nama_produk' => 'Air Mineral 600ml', 'harga_modal' => 2000, 'harga_jual' => 3500, 'stok' => 50],
            ['kategori_id' => $kategoriMinuman->id, 'nama_produk' => 'Teh Botol', 'harga_modal' => 3500, 'harga_jual' => 5000, 'stok' => 40],
            ['kategori_id' => $kategoriMakanan->id, 'nama_produk' => 'Indomie Goreng', 'harga_modal' => 2500, 'harga_jual' => 4000, 'stok' => 30],
            ['kategori_id' => $kategoriMakanan->id, 'nama_produk' => 'Roti Tawar', 'harga_modal' => 12000, 'harga_jual' => 15000, 'stok' => 15],
            ['kategori_id' => $kategoriSnack->id, 'nama_produk' => 'Chitato 68g', 'harga_modal' => 8000, 'harga_jual' => 10000, 'stok' => 25],
            ['kategori_id' => $kategoriSnack->id, 'nama_produk' => 'Oreo 133g', 'harga_modal' => 7000, 'harga_jual' => 9500, 'stok' => 20],
        ];

        foreach ($produkData as $data) {
            Produk::updateOrCreate(
                ['nama_produk' => $data['nama_produk']],
                array_merge($data, ['status' => 'aktif'])
            );
        }
    }
}
