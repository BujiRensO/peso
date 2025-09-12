<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobListing;
use App\Models\Scholarship;
use App\Models\Application;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // Get system statistics
        $totalUsers = User::count();
        $totalJobs = JobListing::count();
        $totalScholarships = Scholarship::count();
        $totalApplications = Application::count();
        
        // Get user role distribution
        $userRoles = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
        
        // Get recent activity
        $recentUsers = User::latest()->take(5)->get();
        $recentJobs = JobListing::latest()->take(5)->get();
        $recentScholarships = Scholarship::latest()->take(5)->get();
        
        // Get application statistics
        $applicationStats = Application::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalJobs', 
            'totalScholarships',
            'totalApplications',
            'userRoles',
            'recentUsers',
            'recentJobs',
            'recentScholarships',
            'applicationStats'
        ));
    }
    
    public function userManagement()
    {
        $users = User::with(['jobListings', 'scholarships', 'applications'])
            ->paginate(20);
            
        return view('superadmin.users', compact('users'));
    }
    
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:jobseeker,employer,admin,superadmin'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', 'User role updated successfully.');
    }
    
    public function systemLogs()
    {
        // This would typically read from log files or a logging system
        $logs = [
            'system' => 'System logs would be displayed here',
            'security' => 'Security logs would be displayed here',
            'application' => 'Application logs would be displayed here'
        ];
        
        return view('superadmin.logs', compact('logs'));
    }
    
    public function analytics()
    {
        // Monthly user registrations
        $monthlyUsers = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Monthly job postings
        $monthlyJobs = JobListing::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Monthly scholarship postings
        $monthlyScholarships = Scholarship::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        return view('superadmin.analytics', compact(
            'monthlyUsers',
            'monthlyJobs',
            'monthlyScholarships'
        ));
    }
    
    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:users,jobs,scholarships,applications,comprehensive',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);
        
        // Generate report based on type
        $reportData = $this->generateReportData($request->report_type, $request->date_from, $request->date_to);
        
        return view('superadmin.reports.show', compact('reportData'));
    }
    
    private function generateReportData($type, $dateFrom = null, $dateTo = null)
    {
        $query = null;
        
        switch ($type) {
            case 'users':
                $query = User::query();
                break;
            case 'jobs':
                $query = JobListing::with('employer');
                break;
            case 'scholarships':
                $query = Scholarship::with('provider');
                break;
            case 'applications':
                $query = Application::with(['user', 'jobListing', 'scholarship']);
                break;
            case 'comprehensive':
                return [
                    'users' => User::count(),
                    'jobs' => JobListing::count(),
                    'scholarships' => Scholarship::count(),
                    'applications' => Application::count(),
                    'active_employers' => User::where('role', 'employer')->count(),
                    'active_admins' => User::where('role', 'admin')->count(),
                ];
        }
        
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
        
        return $query->get();
    }
}
