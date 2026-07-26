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
        Schema::create('estimate_items', function (Blueprint $table) {
            $table->id();
            // Menghubungkan item ke proyek di tabel estimates. Jika proyek dihapus, item ikut terhapus (cascade)
            $table->foreignId('estimate_id')->constrained('estimates')->onDelete('cascade');
            $table->string('nama_item'); // Contoh: Semen Padang, Pasir Pasang, Upah Tukang Gali
            $table->integer('kuantitas'); // Contoh: 50, 10, 5
            $table->string('satuan'); // Contoh: Sak, m3, Orang/Hari
            $table->bigInteger('harga_satuan'); // Contoh: 65000, 220000
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_items');
    }
};
