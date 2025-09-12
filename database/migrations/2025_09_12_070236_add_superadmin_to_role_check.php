<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update CHECK constraint to include superadmin (PostgreSQL)
        // First, update any existing superadmin users to ensure they're valid
        DB::statement("UPDATE users SET role = 'superadmin' WHERE role = 'superadmin'");
        
        // Drop existing constraint if present, then add the new one
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('jobseeker','employer','admin','superadmin'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous constraint without superadmin
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('jobseeker','employer','admin'))");
    }
};
