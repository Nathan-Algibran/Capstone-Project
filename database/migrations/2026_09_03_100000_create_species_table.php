<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ilmiah');
            $table->string('nama_umum');
            $table->string('slug')->unique();
            $table->string('status_konservasi');
            $table->text('deskripsi')->nullable();
            $table->string('habitat')->nullable();
            $table->text('ancaman_utama')->nullable();
            $table->string('foto_url')->nullable();
            $table->unsignedInteger('jumlah_terdeteksi')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
