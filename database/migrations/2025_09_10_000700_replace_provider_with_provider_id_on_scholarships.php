<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            if (Schema::hasColumn('scholarships', 'provider')) {
                $table->dropColumn('provider');
            }
            $table->foreignId('provider_id')->after('id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropConstrainedForeignId('provider_id');
            $table->string('provider')->after('description');
        });
    }
};


