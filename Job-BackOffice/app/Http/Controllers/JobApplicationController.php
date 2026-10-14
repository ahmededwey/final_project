<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesSoftDeletes;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    use HandlesSoftDeletes;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', JobApplication::class);
        $query = JobApplication::with(['resume', 'jobVacancy'])->latest();
        if ($request->user()->role === 'company-owner') {
            $query->whereHas('jobVacancy', function ($vacancyQuery) use ($request) {
                $vacancyQuery->withTrashed()->whereHas('company', fn ($companyQuery) => $companyQuery
                    ->withTrashed()
                    ->where('ownerId', $request->user()->id));
            });
        }
        if ($request->filled('jobVacancyId')) {
            $query->where('jobVacancyId', $request->query('jobVacancyId'));
        }
        $this->filterTrashedRecords($query, $request);
        $jobApplications = $query->paginate(5)->withQueryString();

        return view('jobApplication.index', compact('jobApplications'));
    }

    public function show(JobApplication $jobApplication): View
    {
        $this->authorize('view', $jobApplication);
        $jobApplication->load(['user', 'resume', 'jobVacancy.company', 'jobVacancy.category']);

        return view('jobApplication.show', compact('jobApplication'));
    }

    public function edit(JobApplication $jobApplication): View
    {
        $this->authorize('update', $jobApplication);

        return view('jobApplication.edit', compact('jobApplication'));
    }

    public function update(UpdateJobApplicationRequest $request, JobApplication $jobApplication): RedirectResponse
    {
        $this->authorize('update', $jobApplication);
        $jobApplication->update($request->validated());

        return redirect()->route('jobApplication.index')
            ->with('success', 'Job Application updated successfully.');
    }

    public function destroy(JobApplication $jobApplication): RedirectResponse
    {
        $this->authorize('delete', $jobApplication);
        $jobApplication->delete();

        return redirect()->route('jobApplication.index')
            ->with('success', 'Job Application moved to trash.');
    }

    public function restore(string $id): RedirectResponse
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $this->authorize('restore', $jobApplication);
        $jobApplication->restore();

        return back()->with('success', 'Job Application restored successfully.');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $jobApplication);
        $jobApplication->forceDelete();

        return back()
            ->with('success', 'Job Application permanently deleted.');
    }
}
