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
        Schema::table('schedules', function (Blueprint $table) {
            $table->time('friday_start_at')->nullable()->after('thursday_end_at');
            $table->time('friday_end_at')->nullable()->after('friday_start_at');
            $table->time('saturday_start_at')->nullable()->after('friday_end_at');
            $table->time('saturday_end_at')->nullable()->after('saturday_start_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('friday_start_at');
            $table->dropColumn('friday_end_at');
            $table->dropColumn('saturday_start_at');
            $table->dropColumn('saturday_end_at');
        });
    }
};
