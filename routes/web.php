<?php

use App\Http\Controllers\Auth\SupabaseOAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Supabase OAuth routes
Route::get('/login/google', [SupabaseOAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/callback', [SupabaseOAuthController::class, 'handleCallback'])->name('auth.callback');
Route::post('/logout/supabase', [SupabaseOAuthController::class, 'logout'])->name('logout.supabase');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified', 'role:jobseeker,admin,employer'])->name('home');

// Employer routes
Route::middleware(['auth', 'verified', 'role:employer'])->group(function () {
    Route::get('/employer/dashboard', function () {
        return view('employer.dashboard');
    })->name('employer.dashboard');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Jobs management
    Route::get('/admin/jobs', [App\Http\Controllers\AdminController::class, 'jobs'])->name('admin.jobs');
    Route::get('/admin/jobs/{job}', [App\Http\Controllers\AdminController::class, 'showJob'])->name('admin.jobs.show');
    Route::patch('/admin/jobs/{job}/status', [App\Http\Controllers\AdminController::class, 'updateJobStatus'])->name('admin.jobs.status');
    Route::delete('/admin/jobs/{job}', [App\Http\Controllers\AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
    
    // Scholarships management
    Route::get('/admin/scholarships', [App\Http\Controllers\AdminController::class, 'scholarships'])->name('admin.scholarships');
    Route::get('/admin/scholarships/{scholarship}', [App\Http\Controllers\AdminController::class, 'showScholarship'])->name('admin.scholarships.show');
    Route::patch('/admin/scholarships/{scholarship}/status', [App\Http\Controllers\AdminController::class, 'updateScholarshipStatus'])->name('admin.scholarships.status');
    Route::delete('/admin/scholarships/{scholarship}', [App\Http\Controllers\AdminController::class, 'deleteScholarship'])->name('admin.scholarships.delete');
    
    // Users management
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
    Route::patch('/admin/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::patch('/admin/users/{user}/status', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('admin.users.status');
    
    // Applications management
    Route::get('/admin/applications', [App\Http\Controllers\AdminController::class, 'applications'])->name('admin.applications');
    Route::get('/admin/applications/{application}', [App\Http\Controllers\AdminController::class, 'showApplication'])->name('admin.applications.show');
    Route::patch('/admin/applications/{application}/status', [App\Http\Controllers\AdminController::class, 'updateApplicationStatus'])->name('admin.applications.status');
});

// Super Admin routes
Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin/users', [App\Http\Controllers\SuperAdminController::class, 'userManagement'])->name('superadmin.users');
    Route::patch('/superadmin/users/{user}/role', [App\Http\Controllers\SuperAdminController::class, 'updateUserRole'])->name('superadmin.users.role');
    Route::get('/superadmin/logs', [App\Http\Controllers\SuperAdminController::class, 'systemLogs'])->name('superadmin.logs');
    Route::get('/superadmin/analytics', [App\Http\Controllers\SuperAdminController::class, 'analytics'])->name('superadmin.analytics');
    Route::post('/superadmin/reports', [App\Http\Controllers\SuperAdminController::class, 'generateReport'])->name('superadmin.reports.generate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
