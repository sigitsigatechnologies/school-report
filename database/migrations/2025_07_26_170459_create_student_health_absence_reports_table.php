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
        Schema::create('student_health_absence_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_classroom_id')->constrained()->cascadeOnDelete(); // menghubungkan siswa per kelas & tahun ajaran
            $table->string('semester'); // atau bisa enum('Ganjil', 'Genap')
            $table->integer('sakit')->default(0);
            $table->integer('ijin')->default(0);
            $table->integer('tanpa_keterangan')->default(0);
            $table->string('tinggi_badan')->nullable(); // bisa pakai string biar cm-nya ikut
            $table->string('berat_badan')->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_health_absence_reports');
    }
};
