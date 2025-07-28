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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title_project')->nullable();
            $table->unsignedBigInteger('project_description_detail_id');
            $table->foreign('project_description_detail_id')
                ->references('id')
                ->on('project_description_details')
                ->onDelete('cascade');
                // Relasi ke student_classroom
            $table->foreignId('student_classroom_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
