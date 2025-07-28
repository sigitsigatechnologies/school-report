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
        Schema::table('nilai_materi_rapors', function (Blueprint $table) {
            $table->dropColumn('naik_kelas');
        });

        Schema::table('nilai_materi_rapors', function (Blueprint $table) {
            $table->string('naik_kelas')->nullable()->after('student_classroom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_materi_rapors', function (Blueprint $table) {
            $table->dropColumn('naik_kelas');
        });

        Schema::table('nilai_materi_rapors', function (Blueprint $table) {
            $table->boolean('naik_kelas')->default(false)->after('student_classroom_id');
        });
    }
};
