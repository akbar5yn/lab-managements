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
        Schema::create('transaksi_peminjaman_alat', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('id_unit')->constrained(
                table: 'unit',
                indexName: 'id_unit'
            );
            $table->foreignId('id_user',)->constrained(
                table: 'users',
                indexName: 'id_user'
            );
            $table->string('keperluan');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            // $table->enum('status', ['pending', 'dibatalkan', 'berlangsung', 'selesai'])->default('pending');
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat_dikemablikan', 'dibatalkan', 'expire'])->default('pending');
            $table->timestamp('waktu_kedaluwarsa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_peminjaman_alat');
    }
};
