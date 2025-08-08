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
        Schema::table('master_materis', function (Blueprint $table) {
            $table->foreignId('kategori_materi_id')
                ->nullable()
                ->after('classroom_id')
                ->constrained('kategori_materis')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_materis', function (Blueprint $table) {
            $table->dropForeign(['kategori_materi_id']);
            $table->dropColumn('kategori_materi_id');
        });
    }
};
