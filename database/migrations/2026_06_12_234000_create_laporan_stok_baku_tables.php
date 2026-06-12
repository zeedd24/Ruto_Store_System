<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_stok_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_laporan_stok_baku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_stok_baku_id')
                ->constrained('laporan_stok_baku')
                ->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->enum('status', ['menipis', 'habis']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_laporan_stok_baku');
        Schema::dropIfExists('laporan_stok_baku');
    }
};
