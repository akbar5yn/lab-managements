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
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->string('no_unit')->unique();
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Rusak'])->default('Tersedia');
            $table->enum('kondisi', ['Normal', 'Rusak'])->default('Normal');
            $table->foreignId('id_alat')->constrained(
                table: 'inventaris_alat',
                indexName: 'id_alat'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit');
    }
};
