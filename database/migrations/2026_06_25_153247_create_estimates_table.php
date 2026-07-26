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
    Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->string('nama_klien'); // KOLOM BARU
            $table->text('deskripsi')->nullable();
            $table->integer('luas_bangunan'); // KOLOM BARU
            $table->string('status_proyek')->default('Draft'); // KOLOM BARU
            $table->bigInteger('estimasi_biaya');
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
