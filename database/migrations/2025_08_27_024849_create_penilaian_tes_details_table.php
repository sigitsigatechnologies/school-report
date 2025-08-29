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
        Schema::create('penilaian_tes_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_sumatif_detail_id')->constrained()->onDelete('cascade');
            $table->integer('nilai_tes')->nullable();
            $table->integer('nilai_non_tes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_tes_details');
    }
};
