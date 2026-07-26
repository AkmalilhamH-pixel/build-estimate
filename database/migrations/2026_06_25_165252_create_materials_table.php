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
      Schema::create('materials', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang'); // Contoh: Semen Tiga Roda, Besi 10mm, Bata Merah
        $table->string('satuan');      // Contoh: Sak, Batang, Bijian, m3
        $table->bigInteger('harga_pasar'); // Harga acuan standar pasar
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
