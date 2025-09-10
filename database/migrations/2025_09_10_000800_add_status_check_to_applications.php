<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add CHECK constraint for status on PostgreSQL (pending, approved, rejected)
        DB::statement("ALTER TABLE applications ADD CONSTRAINT applications_status_check CHECK (status IN ('pending','approved','rejected'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE applications DROP CONSTRAINT IF EXISTS applications_status_check");
    }
};


