<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a default superadmin if not exists
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('supersecurepassword'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // Seed a default admin if not exists
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('adminpassword'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Get the admin user to use as employer
        $adminUser = User::where('email', 'admin@example.com')->first();

        // Seed some sample job listings
        \App\Models\JobListing::firstOrCreate(
            ['title' => 'Software Developer'],
            [
                'description' => 'We are looking for a skilled software developer to join our team.',
                'employer' => 'Tech Company Inc.',
                'employer_id' => $adminUser->id,
                'status' => 'approved',
                'posted_at' => now(),
            ]
        );

        \App\Models\JobListing::firstOrCreate(
            ['title' => 'Marketing Manager'],
            [
                'description' => 'Join our marketing team and help us grow our business.',
                'employer' => 'Marketing Solutions Ltd.',
                'employer_id' => $adminUser->id,
                'status' => 'pending',
                'posted_at' => now(),
            ]
        );

        // Seed some sample scholarships
        \App\Models\Scholarship::firstOrCreate(
            ['title' => 'Computer Science Scholarship'],
            [
                'description' => 'Full scholarship for computer science students.',
                'provider_id' => $adminUser->id,
                'deadline' => now()->addMonths(3),
                'status' => 'approved',
            ]
        );

        \App\Models\Scholarship::firstOrCreate(
            ['title' => 'Business Administration Grant'],
            [
                'description' => 'Financial support for business administration students.',
                'provider_id' => $adminUser->id,
                'deadline' => now()->addMonths(2),
                'status' => 'pending',
            ]
        );
    }
}
