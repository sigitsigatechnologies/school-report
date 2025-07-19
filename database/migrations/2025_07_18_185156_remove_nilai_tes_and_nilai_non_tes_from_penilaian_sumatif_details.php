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
        Schema::table('penilaian_sumatif_details', function (Blueprint $table) {
            $table->dropColumn(['nilai_tes', 'nilai_non_tes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_sumatif_details', function (Blueprint $table) {
            $table->integer('nilai_tes')->nullable();
            $table->integer('nilai_non_tes')->nullable();
        });
    }
};
