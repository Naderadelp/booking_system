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
            if (!Schema::hasColumn('schedules', 'saturday_start_at')) {
                $table->time('saturday_start_at')->nullable()->after('friday_end_at');
            }
            if (!Schema::hasColumn('schedules', 'saturday_end_at')) {
                $table->time('saturday_end_at')->nullable()->after('saturday_start_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['saturday_start_at', 'saturday_end_at']);
        });
    }
};
