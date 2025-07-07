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
        Schema::table('students', function (Blueprint $table) {
            // Jangan buat ulang kolom wali_id, hanya foreign key
            $table->foreign('wali_id')
                ->references('id')
                ->on('guru')
                ->onDelete('set null');
        });
              
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['wali_id']);
        });
    }
};
