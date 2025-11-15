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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->time('sunday_start_at')->nullable();
            $table->time('sunday_end_at')->nullable();
            $table->time('monday_start_at')->nullable();
            $table->time('monday_end_at')->nullable();
            $table->time('tuesday_start_at')->nullable();
            $table->time('tuesday_end_at')->nullable();
            $table->time('wednesday_start_at')->nullable();
            $table->time('wednesday_end_at')->nullable();
            $table->time('thursday_start_at')->nullable();
            $table->time('thursday_end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
