<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure default role is 'jobseeker'
        Schema::table('users', function () {
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'jobseeker'");
        });

        // Backfill existing rows with invalid or NULL roles to 'jobseeker' to satisfy CHECK
        DB::table('users')
            ->whereNull('role')
            ->orWhereNotIn('role', ['jobseeker', 'employer', 'admin'])
            ->update(['role' => 'jobseeker']);

        // Add CHECK constraint for valid roles (PostgreSQL)
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('jobseeker','employer','admin'))");
    }

    public function down(): void
    {
        // Drop CHECK constraint if exists
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        // Optional: remove default or set back to 'user'
        Schema::table('users', function () {
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        });
    }
};


