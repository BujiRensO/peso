<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobListing;
use App\Models\Scholarship;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function dashboard(): View
    {
        // Get statistics for admin dashboard
        $totalUsers = User::count();
        $totalJobs = JobListing::count();
        $totalScholarships = Scholarship::count();
        $totalApplications = Application::count();
        
        // Get pending items that need admin attention
        $pendingJobs = JobListing::where('status', 'pending')->count();
        $pendingScholarships = Scholarship::where('status', 'pending')->count();
        $pendingApplications = Application::where('status', 'pending')->count();
        
        // Get recent activity
        $recentUsers = User::latest()->take(5)->get();
        $recentJobs = JobListing::latest()->take(5)->get();
        $recentScholarships = Scholarship::latest()->take(5)->get();
        $recentApplications = Application::with(['user', 'jobListing', 'scholarship'])->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalJobs',
            'totalScholarships', 
            'totalApplications',
            'pendingJobs',
            'pendingScholarships',
            'pendingApplications',
            'recentUsers',
            'recentJobs',
            'recentScholarships',
            'recentApplications'
        ));
    }

    /**
     * Display job listings management
     */
    public function jobs(Request $request): View
    {
        $query = JobListing::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('employer', 'like', "%{$search}%");
            });
        }
        
        $jobs = $query->latest()->paginate(15);
        
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show specific job listing
     */
    public function showJob(JobListing $job): View
    {
        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Update job listing status
     */
    public function updateJobStatus(Request $request, JobListing $job): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,expired'
        ]);
        
        $job->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Job status updated successfully.');
    }

    /**
     * Delete job listing
     */
    public function deleteJob(JobListing $job): RedirectResponse
    {
        $job->delete();
        
        return redirect()->route('admin.jobs')->with('success', 'Job listing deleted successfully.');
    }

    /**
     * Display scholarships management
     */
    public function scholarships(Request $request): View
    {
        $query = Scholarship::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%");
            });
        }
        
        $scholarships = $query->latest()->paginate(15);
        
        return view('admin.scholarships.index', compact('scholarships'));
    }

    /**
     * Show specific scholarship
     */
    public function showScholarship(Scholarship $scholarship): View
    {
        return view('admin.scholarships.show', compact('scholarship'));
    }

    /**
     * Update scholarship status
     */
    public function updateScholarshipStatus(Request $request, Scholarship $scholarship): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,expired'
        ]);
        
        $scholarship->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Scholarship status updated successfully.');
    }

    /**
     * Delete scholarship
     */
    public function deleteScholarship(Scholarship $scholarship): RedirectResponse
    {
        $scholarship->delete();
        
        return redirect()->route('admin.scholarships')->with('success', 'Scholarship deleted successfully.');
    }

    /**
     * Display users management
     */
    public function users(Request $request): View
    {
        $query = User::query();
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show specific user
     */
    public function showUser(User $user): View
    {
        $user->load(['jobListings', 'scholarships', 'applications']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:jobseeker,employer,admin'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleUserStatus(User $user): RedirectResponse
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "User {$status} successfully.");
    }

    /**
     * Display applications management
     */
    public function applications(Request $request): View
    {
        $query = Application::with(['user', 'jobListing', 'scholarship']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by type (job or scholarship)
        if ($request->filled('type')) {
            if ($request->type === 'job') {
                $query->whereNotNull('job_id');
            } elseif ($request->type === 'scholarship') {
                $query->whereNotNull('scholarship_id');
            }
        }
        
        $applications = $query->latest()->paginate(15);
        
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Show specific application
     */
    public function showApplication(Application $application): View
    {
        $application->load(['user', 'jobListing', 'scholarship']);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, Application $application): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,withdrawn'
        ]);
        
        $application->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Get statistics for dashboard widgets
     */
    public function getStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_jobs' => JobListing::count(),
            'total_scholarships' => Scholarship::count(),
            'total_applications' => Application::count(),
            'pending_jobs' => JobListing::where('status', 'pending')->count(),
            'pending_scholarships' => Scholarship::where('status', 'pending')->count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
        ];
    }
}
