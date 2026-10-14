<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesSoftDeletes;
use App\Http\Requests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateJobCategoryRequest;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobCategoryController extends Controller
{
    use HandlesSoftDeletes;

    public function index(Request $request): View
    {
        $query = JobCategory::withCount('jobVacancies')->latest();
        $this->filterTrashedRecords($query, $request);

        $categories = $query->paginate(5)->withQueryString();

        return view('jobCategory.index', compact('categories'));
    }

    public function create(): View
    {
        $jobCategory = new JobCategory;

        return view('jobCategory.create', compact('jobCategory'));
    }

    public function store(StoreJobCategoryRequest $request): RedirectResponse
    {
        JobCategory::create($request->validated());

        return redirect()->route('jobCategory.index')
            ->with('success', 'Job category created successfully.');
    }

    public function show(JobCategory $jobCategory): View
    {
        $jobCategory->load('jobVacancies');

        return view('jobCategory.show', compact('jobCategory'));
    }

    public function edit(JobCategory $jobCategory): View
    {
        return view('jobCategory.edit', compact('jobCategory'));
    }

    public function update(UpdateJobCategoryRequest $request, JobCategory $jobCategory): RedirectResponse
    {
        $jobCategory->update($request->validated());

        return redirect()->route('jobCategory.index')
            ->with('success', 'Job category updated successfully.');
    }

    // Soft delete (Move to Trash)
    public function destroy(JobCategory $jobCategory): RedirectResponse
    {
        $jobCategory->delete();

        return redirect()->route('jobCategory.index')
            ->with('success', 'Job category moved to trash.');
    }

    // Restore soft-deleted record
    public function restore(string $id): RedirectResponse
    {
        $this->restoreTrashedRecord(JobCategory::class, $id);

        return redirect()->back()
            ->with('success', 'Job category restored successfully.');
    }

    // Permanently remove from database
    public function forceDelete(string $id): RedirectResponse
    {
        $this->permanentlyDeleteTrashedRecord(JobCategory::class, $id);

        return redirect()->back()
            ->with('success', 'Job category permanently deleted.');
    }
}
