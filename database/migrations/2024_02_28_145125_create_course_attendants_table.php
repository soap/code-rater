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
        Schema::create('course_attendants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_active')->default(true)->comment('Is the user currently enrolled in the course?');
            $table->boolean('is_completed')->default(false)->comment('Has the user completed the course?');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('started_at')->nullable()->comment('When did the user start the course?');
            $table->timestamp('expired_at')->nullable()->comment('When does the course expire?');
            $table->timestamp('enrolled_at')->nullable()->comment('When did the user enroll in the course?');
            $table->timestamp('unenrolled_at')->nullable()->comment('When did the user unenroll from the course?');
            $table->timestamp('last_accessed_at')->nullable()->comment('When was the last time the user accessed the course?');
            $table->text('notes')->nullable()->comment('Any notes about the user in the course?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_attendants');
    }
};
