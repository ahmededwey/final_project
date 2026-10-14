<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobVacancy;

class DashboardController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->count();

        $totalJobs = JobVacancy::count();
        $totalCompanies = Company::count();
        $totalApplications = JobApplication::count();
        $applicationStatuses = JobApplication::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $pendingApplications = (int) $applicationStatuses->get('pending', 0);
        $acceptedApplications = (int) $applicationStatuses->get('accepted', 0);
        $rejectedApplications = (int) $applicationStatuses->get('rejected', 0);

        $trendStart = now()->startOfDay()->subDays(6);
        $applicationsByDay = JobApplication::query()
            ->where('created_at', '>=', $trendStart)
            ->get(['created_at'])
            ->groupBy(fn (JobApplication $application) => $application->created_at->toDateString());

        $applicationTrend = collect(range(6, 0))
            ->map(function (int $daysAgo) use ($applicationsByDay, $trendStart) {
                $date = $trendStart->copy()->addDays(6 - $daysAgo);

                return [
                    'label' => $date->format('D'),
                    'date' => $date->format('M j'),
                    'count' => $applicationsByDay->get($date->toDateString(), collect())->count(),
                ];
            });

        $applicationTrendMax = max(1, (int) $applicationTrend->max('count'));
        $applicationsLast7Days = (int) $applicationTrend->sum('count');

        $recentApplications = JobApplication::with(['user', 'jobVacancy.company'])
            ->latest()
            ->take(6)
            ->get();

        $topVacancies = JobVacancy::with('company')
            ->withCount('jobApplications')
            ->orderByDesc('job_applications_count')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'activeUsers',
            'totalJobs',
            'totalCompanies',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications',
            'applicationTrend',
            'applicationTrendMax',
            'applicationsLast7Days',
            'recentApplications',
            'topVacancies',
        ));
    }
}