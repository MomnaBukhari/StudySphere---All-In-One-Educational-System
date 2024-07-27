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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('file_path');
            $table->enum('content_type', ['document', 'video', 'audio']); // Add other content types as needed
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');            //
            // $table->foreign('teacher_id')->references('id')->on('users');
            $table->foreign('teacher_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
