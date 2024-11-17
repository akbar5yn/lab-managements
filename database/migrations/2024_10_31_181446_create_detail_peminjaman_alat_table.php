<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
                indexName: 'id_transaksi_peminjaman'
            )->onDelete('cascade');
            $table->foreignId('id_unit')->constrained(
                table: 'unit',
                indexName: 'id_unit'
            );
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat_dikembalikan'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('detail_peminjaman_alat')) {
            Schema::table('detail_peminjaman_alat', function (Blueprint $table) {
                try {
                    // Hanya hapus foreign key jika ada
                    DB::statement("ALTER TABLE detail_peminjaman_alat DROP FOREIGN KEY IF EXISTS detail_peminjaman_alat_id_transaksi_peminjaman_foreign");
                } catch (\Exception $e) {
                    // Abaikan error jika foreign key tidak ditemukan
                }
            });
        }
        Schema::dropIfExists('detail_peminjaman_alat');
    }
};
