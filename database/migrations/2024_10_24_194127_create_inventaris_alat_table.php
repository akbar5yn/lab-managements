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
        Schema::create('inventaris_alat', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nama_alat');
            $table->string('lokasi');
            $table->integer('tahun_pengadaan')->nullable();
            $table->string('fungsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_alat');
    }
};
