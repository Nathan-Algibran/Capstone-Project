<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conflict_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('species_id')->nullable()->constrained('species')->nullOnDelete();
            $table->decimal('lokasi_lat', 10, 7);
            $table->decimal('lokasi_lng', 10, 7);
            $table->string('lokasi_nama')->nullable();
            $table->date('tanggal');
            $table->string('sumber')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conflict_incidents');
    }
};
