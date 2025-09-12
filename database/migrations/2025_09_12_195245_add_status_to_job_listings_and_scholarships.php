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
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('employer');
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('provider');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};