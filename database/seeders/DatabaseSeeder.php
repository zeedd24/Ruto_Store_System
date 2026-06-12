<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed default users
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

        // 2. Clear old categories and products to prevent duplicates/dummy clutter
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Produk::truncate();
        Kategori::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Create raw material categories and products
        $catPerlengkapan = Kategori::create(['nama_kategori' => 'Perlengkapan']);
        $perlengkapanItems = [
            'Cup Ruto',
            'Cup Kosong',
            'Cup Kopi Panas',
            'Pipet',
            'Sendok Plastik',
            'Garpu Plastik',
            'Kertas Piring',
            'Tisu',
            'Kertas Print',
            'Kantong Sampah',
            'Tempat Saus',
        ];
        
        $cupRutoId = null;
        $cupKosongId = null;

        foreach ($perlengkapanItems as $name) {
            $prod = Produk::create([
                'kategori_id' => $catPerlengkapan->id,
                'nama_produk' => $name,
                'harga_modal' => 500, // default modal
                'harga_jual' => 0,
                'stok' => 200, // default initial stock
                'status' => 'aktif',
                'tipe' => 'baku',
            ]);

            if ($name === 'Cup Ruto') {
                $cupRutoId = $prod->id;
            } elseif ($name === 'Cup Kosong') {
                $cupKosongId = $prod->id;
            }
        }

        $catBahanBaku = Kategori::create(['nama_kategori' => 'Bahan Baku']);
        $bahanBakuItems = [
            'Susu UHT',
            'Susu Kental Manis',
            'Beans',
            'Bubuk Red Velvet',
            'Bubuk Milo',
            'Bubuk Matcha',
            'Bubuk Taro',
            'Bubuk Coklat',
            'Syrup Vanilla',
            'Syrup Butterscotch',
            'Syrup Almond',
            'Syrup Merah',
            'Syrup Oren',
            'Syrup Lychee',
            'Induk Syrup Fruitpunch',
            'Induk Syrup Citrus',
            'Sauce Salted Caramel',
            'Lemon Slice',
            'Buah Lychee Kaleng',
            'Yakult',
            'Sprite',
            'Coca Cola',
            'Es Batu',
            'Lemon',
            'Galon',
            'Mineral',
        ];

        foreach ($bahanBakuItems as $name) {
            Produk::create([
                'kategori_id' => $catBahanBaku->id,
                'nama_produk' => $name,
                'harga_modal' => 2000, // default modal
                'harga_jual' => 0,
                'stok' => 100, // default initial stock
                'status' => 'aktif',
                'tipe' => 'baku',
            ]);
        }

        $catBahanDapur = Kategori::create(['nama_kategori' => 'Bahan Baku Dapur']);
        $bahanDapurItems = [
            'Sosis',
            'Nugget',
            'Kentang',
            'Ayam Gunting',
            'Indomie Goreng',
            'Indomie Kuah',
            'Telur',
            'Minyak Goreng',
            'Saos Sambal',
            'Gula',
            'Teh',
            'Bumbu Kentang',
        ];

        foreach ($bahanDapurItems as $name) {
            Produk::create([
                'kategori_id' => $catBahanDapur->id,
                'nama_produk' => $name,
                'harga_modal' => 3000,
                'harga_jual' => 0,
                'stok' => 100,
                'status' => 'aktif',
                'tipe' => 'baku',
            ]);
        }

        $catToilet = Kategori::create(['nama_kategori' => 'Perlengkapan Kamar Mandi']);
        $toiletItems = [
            'Sunlight',
            'Wipol',
            'Pengharum Lantai',
        ];

        foreach ($toiletItems as $name) {
            Produk::create([
                'kategori_id' => $catToilet->id,
                'nama_produk' => $name,
                'harga_modal' => 5000,
                'harga_jual' => 0,
                'stok' => 50,
                'status' => 'aktif',
                'tipe' => 'baku',
            ]);
        }

        // 4. Define real menu structure
        $menuData = [
            'Signature' => [
                ['nama' => 'Ruto Coffee', 'harga' => 12000],
                ['nama' => 'Coke-ing Soda', 'harga' => 15000],
                ['nama' => 'Cream Noir', 'harga' => 17000],
            ],
            'Ice Coffee' => [
                ['nama' => 'Americano', 'harga' => 12000],
                ['nama' => 'Capuccino', 'harga' => 12000],
                ['nama' => 'Aren', 'harga' => 12000],
                ['nama' => 'Butterscotch', 'harga' => 15000],
                ['nama' => 'Almond', 'harga' => 15000],
                ['nama' => 'Vanilla Latte', 'harga' => 15000],
                ['nama' => 'Ice Latte', 'harga' => 15000],
                ['nama' => 'Ice Mocha', 'harga' => 18000],
                ['nama' => 'Caramel Machiato', 'harga' => 22000],
                ['nama' => 'Coffee Moktail', 'harga' => 22000],
            ],
            'Non Coffee' => [
                ['nama' => 'Air Mineral', 'harga' => 5000],
                ['nama' => 'Ice Tea', 'harga' => 9000],
                ['nama' => 'Matcha', 'harga' => 15000],
                ['nama' => 'Taro', 'harga' => 15000],
                ['nama' => 'Red Velvet', 'harga' => 15000],
                ['nama' => 'Chocolate', 'harga' => 15000],
                ['nama' => 'Pinky Monkey', 'harga' => 15000],
                ['nama' => 'Mango Monkey', 'harga' => 15000],
                ['nama' => 'Lemon Tea', 'harga' => 15000],
                ['nama' => 'Milo Monster', 'harga' => 17000],
                ['nama' => 'Lychee Tea', 'harga' => 17000],
                ['nama' => 'Lychee Yakult', 'harga' => 17000],
                ['nama' => 'Lychee Sky Soda', 'harga' => 17000],
                ['nama' => 'Zest Rose Spark', 'harga' => 17000],
                ['nama' => 'Zest Citrus Spark', 'harga' => 17000],
            ],
            'Snack' => [
                ['nama' => 'Kentang Goreng', 'harga' => 15000],
                ['nama' => 'Sosis Goreng', 'harga' => 15000],
                ['nama' => 'Nugget Goreng', 'harga' => 15000],
                ['nama' => 'Perkedel Tahu', 'harga' => 15000],
                ['nama' => 'Pisang Cok&Kej', 'harga' => 18000],
                ['nama' => 'Mix Platter', 'harga' => 20000],
                ['nama' => 'Chicken Pop', 'harga' => 20000],
                ['nama' => 'Crispy Bread Roll', 'harga' => 18000],
            ],
            'Food' => [
                ['nama' => 'Mie Goreng B', 'harga' => 15000],
                ['nama' => 'Mie Goreng Jumbo', 'harga' => 18000],
                ['nama' => 'Mie Rebus B', 'harga' => 15000],
                ['nama' => 'Mie Rebus Jumbo', 'harga' => 18000],
                ['nama' => 'Nasi Goreng B', 'harga' => 15000],
                ['nama' => 'Nasi Goreng Spesial', 'harga' => 23000],
                ['nama' => 'Tokyo Katsu Plate', 'harga' => 23000],
            ],
        ];

        // 5. Seed the menu categories and items
        foreach ($menuData as $kategoriNama => $items) {
            $kategori = Kategori::create(['nama_kategori' => $kategoriNama]);

            foreach ($items as $item) {
                // Estimate COGS (harga modal) as 60% of selling price
                $hargaModal = round($item['harga'] * 0.6);

                // Determine cup connection
                $cupId = null;
                if ($kategoriNama === 'Signature') {
                    $cupId = $cupRutoId;
                } elseif (in_array($kategoriNama, ['Ice Coffee', 'Non Coffee']) && $item['nama'] !== 'Air Mineral') {
                    $cupId = $cupKosongId;
                }
                
                Produk::create([
                    'kategori_id' => $kategori->id,
                    'nama_produk' => $item['nama'],
                    'harga_modal' => $hargaModal,
                    'harga_jual' => $item['harga'],
                    'stok' => 100, // default stock for testing
                    'status' => 'aktif',
                    'tipe' => 'jual',
                    'cup_id' => $cupId,
                ]);
            }
        }
    }
}
