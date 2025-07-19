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
        Schema::create('penilaian_sumatif_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_sumatif_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('master_unit_materi_id')->constrained()->cascadeOnDelete();
            $table->integer('nilai')->default(0);
            $table->integer('nilai_non_tes')->default(0);
            $table->integer('nilai_tes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_sumatif_details');
    }
};
