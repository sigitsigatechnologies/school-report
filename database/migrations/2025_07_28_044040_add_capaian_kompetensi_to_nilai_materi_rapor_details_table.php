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
        Schema::table('nilai_materi_rapor_details', function (Blueprint $table) {
            $table->text('capaian_kompetensi')->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_materi_rapor_details', function (Blueprint $table) {
            $table->dropColumn('capaian_kompetensi');
        });
    }
};
