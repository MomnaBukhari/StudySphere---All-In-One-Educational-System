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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            $table->foreign('assessment_id')
            ->references('id')
            ->on('assessments')
            ->onDelete('cascade');

$table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('answer_file')->nullable(); // Store the uploaded answer file path
            $table->timestamps();
        });

    /**
     * Reverse the migrations.
     */
    }
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
