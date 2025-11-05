<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('study_goal_id');
            $table->integer('duration_minutes');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('study_goal_id')->references('id')->on('study_goals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
