<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('sumber', ['langsung', 'pesanan_user'])->default('langsung')->after('kode_transaksi');
            $table->foreignId('pesanan_id')->nullable()->after('user_id')->constrained('pesanan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
            $table->dropColumn(['sumber', 'pesanan_id']);
        });
    }
};
