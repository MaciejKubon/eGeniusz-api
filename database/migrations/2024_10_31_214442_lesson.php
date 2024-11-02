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
        Schema::create('lesson', function (Blueprint $table) {

        $table->id();
        $table->foreignID('teacher_id')->constrained('teacher');
        $table->foreignID('subject_id')->constrained('subject');
        $table->foreignID('subject_level_id')->constrained('subject_level');
        $table->float('price')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson');
    }
};
