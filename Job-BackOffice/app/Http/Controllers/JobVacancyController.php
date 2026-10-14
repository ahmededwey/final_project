<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesSoftDeletes;
use App\Http\Requests\StoreJobVacancyRequest;
use App\Http\Requests\UpdateJobVacancyRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobVacancyController extends Controller
{
    use HandlesSoftDeletes;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', JobVacancy::class);
        $query = JobVacancy::with(['company', 'category'])
            ->withCount('jobApplications')
            ->latest();
        if ($request->user()->role === 'company-owner') {
            $query->whereHas('company', fn ($companyQuery) => $companyQuery->where('ownerId', $request->user()->id));
        }
        $this->filterTrashedRecords($query, $request);
        $jobVacancies = $query->paginate(5)->withQueryString();

        return view('jobVacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', JobVacancy::class);
        $categories = JobCategory::orderBy('name')->get();
        $types = JobVacancy::TYPES;
        $companies = Company::query()
            ->when(auth()->user()->role === 'company-owner', fn ($query) => $query->where('ownerId', auth()->id()))
            ->orderBy('name')
            ->get();
        $jobVacancy = new JobVacancy;

        return view('jobVacancy.create', compact('companies', 'types', 'categories', 'jobVacancy'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobVacancyRequest $request): RedirectResponse
    {
        JobVacancy::create($request->validated());

        return redirect()->route('jobVacancy.index')
            ->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobVacancy $jobVacancy): View
    {
        $this->authorize('view', $jobVacancy);
        $jobVacancy->load(['company', 'category', 'jobApplications.user', 'jobApplications.resume']);

        return view('jobVacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy): View
    {
        $this->authorize('update', $jobVacancy);
        $companies = Company::query()
            ->when(auth()->user()->role === 'company-owner', fn ($query) => $query->where('ownerId', auth()->id()))
            ->orderBy('name')
            ->get();
        $categories = JobCategory::orderBy('name')->get();
        $types = JobVacancy::TYPES;

        return view('jobVacancy.edit', compact('jobVacancy', 'companies', 'categories', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobVacancyRequest $request, JobVacancy $jobVacancy): RedirectResponse
    {
        $jobVacancy->update($request->validated());

        return redirect()->route('jobVacancy.index')
            ->with('success', 'Job Vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobVacancy $jobVacancy): RedirectResponse
    {
        $this->authorize('delete', $jobVacancy);
        $jobVacancy->delete();

        return redirect()->route('jobVacancy.index')
            ->with('success', 'Job vacancy moved to trash.');
    }

    public function restore(string $id): RedirectResponse
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $this->authorize('restore', $jobVacancy);
        $jobVacancy->restore();

        return back()->with('success', 'Job Vacancy restored successfully.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $jobVacancy);
        $jobVacancy->forceDelete();

        return back()
            ->with('success', 'Job Vacancy permanently deleted.');
    }
}
