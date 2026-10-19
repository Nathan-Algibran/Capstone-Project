<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom habitat/konflik dan cluster ke detections
        Schema::table('detections', function (Blueprint $table) {
            $table->unsignedSmallInteger('land_class_id')->nullable()->after('lokasi_nama');
            $table->string('land_class_label')->nullable()->after('land_class_id');
            $table->enum('tipe', ['habitat', 'konflik', 'unknown'])->nullable()->after('land_class_label');
            $table->integer('cluster_id')->default(-1)->after('tipe');
        });

        // Tambah kolom ke conflict_incidents juga
        Schema::table('conflict_incidents', function (Blueprint $table) {
            $table->unsignedSmallInteger('land_class_id')->nullable()->after('deskripsi');
            $table->string('land_class_label')->nullable()->after('land_class_id');
            $table->integer('cluster_id')->default(-1)->after('land_class_label');
        });
    }

    public function down(): void
    {
        Schema::table('detections', function (Blueprint $table) {
            $table->dropColumn(['land_class_id', 'land_class_label', 'tipe', 'cluster_id']);
        });

        Schema::table('conflict_incidents', function (Blueprint $table) {
            $table->dropColumn(['land_class_id', 'land_class_label', 'cluster_id']);
        });
    }
};
