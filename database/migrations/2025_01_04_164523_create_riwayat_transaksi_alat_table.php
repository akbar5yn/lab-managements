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
        Schema::create('riwayat_transaksi_alat', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')
                ->unique() // Memastikan relasi One-to-One
                ->index();
            $table->foreign('no_transaksi')
                ->references('no_transaksi')
                ->on('transaksi_peminjaman_alat')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('kondisi_alat', ['normal', 'rusak'])->default('normal');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksi_alat');
    }
};
