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
        Schema::create('nilai_materi_rapor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nilai_materi_rapor_id')->constrained()->onDelete('cascade');
            $table->foreignId('master_materi_id')->constrained()->onDelete('cascade');
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_materi_rapor_details');
    }
};
