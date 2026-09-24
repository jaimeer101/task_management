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
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('date_started')->after('description')->default(date('Y-m-d'));
            $table->date('date_completed')->after('date_started')->nullable();
            $table->date('date_deadline')->after('date_completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('date_started');
            $table->dropColumn('date_completed');
            $table->dropColumn('date_deadline');
        });
    }
};
