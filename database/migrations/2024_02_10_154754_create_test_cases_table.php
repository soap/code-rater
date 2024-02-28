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
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('course_assignment_id')->constrained()->cascadeOnDelete();
            $table->integer('ordering')->default(0);
            $table->integer('test_type_id')->comment('1: compilation test, 2: functionality test, 3: code quality test');
            $table->integer('passed_score')->default(1);
            $table->integer('failed_score')->default(0);
            $table->string('command')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->tinyInteger('match_type')->default(1)->comment('1: exact, 2: contains, 3: regex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
