<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_peminjaman_alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi_peminjaman')->constrained(
                table: 'transaksi_peminjaman_alat',
            );
            $table->foreignId('id_alat')->constrained(
                table: 'unit',
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman_alat');
    }
};
