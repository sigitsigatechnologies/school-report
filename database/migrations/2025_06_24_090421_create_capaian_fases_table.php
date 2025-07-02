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
        Schema::create('capaian_fases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_element_id')->constrained()->cascadeOnDelete();
            $table->string('fase'); // Contoh: A, B, C, D, E
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capaian_fases');
    }
};
