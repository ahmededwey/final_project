<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyOwnerDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $companyIds = $user->companies()->select('companies.id');
        $vacancyIds = JobVacancy::withTrashed()
            ->whereIn('companyId', $companyIds)
            ->select('id');

        $companies = $user->companies()
            ->with('owner')
            ->withCount([
                'jobVacancies as active_job_vacancies_count' => fn (Builder $query) => $query->whereNull('deleted_at'),
            ])
            ->latest()
            ->get();

        $totalVacancies = JobVacancy::withTrashed()->whereIn('companyId', $companyIds)->count();
        $activeVacancies = JobVacancy::whereIn('companyId', $companyIds)->count();
        $closedVacancies = JobVacancy::onlyTrashed()->whereIn('companyId', $companyIds)->count();
        $totalApplications = JobApplication::whereIn('jobVacancyId', $vacancyIds)->count();

        $jobVacancies = JobVacancy::withTrashed()
            ->with(['company', 'category'])
            ->withCount('jobApplications')
            ->whereIn('companyId', $companyIds)
            ->latest()
            ->paginate(8);

        return view('company-owner.dashboard', compact(
            'companies',
            'totalVacancies',
            'activeVacancies',
            'closedVacancies',
            'totalApplications',
            'jobVacancies',
        ));
    }
}
