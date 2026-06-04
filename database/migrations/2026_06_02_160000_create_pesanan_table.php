<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->enum('jenis_identitas', ['meja', 'antrian']);
            $table->string('nomor_identitas', 50);
            $table->enum('status', ['menunggu_bayar', 'dibayar', 'dibatalkan'])->default('menunggu_bayar');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
