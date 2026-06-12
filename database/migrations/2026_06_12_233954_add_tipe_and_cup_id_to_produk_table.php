<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->enum('tipe', ['jual', 'baku'])->default('jual')->after('nama_produk');
            $table->foreignId('cup_id')
                ->nullable()
                ->after('kategori_id')
                ->constrained('produk')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['cup_id']);
            $table->dropColumn(['tipe', 'cup_id']);
        });
    }
};
