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
        Schema::create('berita_informasis', function (Blueprint $table) {
            $table->id('id_berita_informasi');
            $table->string('id_user');
            $table->string('judul');
            $table->string('gambar');
            $table->string('isi');
            $table->string('status_berita_informasi');
            $table->text('jenis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_informasis');
    }
};
