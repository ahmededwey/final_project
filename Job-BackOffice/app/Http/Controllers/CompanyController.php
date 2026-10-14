<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesSoftDeletes;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyController extends Controller
{
    use HandlesSoftDeletes;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Company::class);
        $query = Company::withCount('jobVacancies')->with('owner')->latest();
        if ($request->user()->role === 'company-owner') {
            $query->withTrashed()->where('ownerId', $request->user()->id);
        }
        $this->filterTrashedRecords($query, $request);

        $companies = $query->paginate(5)->withQueryString();

        return view('company.index', compact('companies'));
    }

    public function create(): View
    {
        $this->authorize('create', Company::class);
        $users =  Auth::user()->role === 'admin'
            ? User::orderBy('name', 'asc')->get()
            : User::whereKey(Auth::id())->get();
        $company = new Company;

        return view('company.create', compact('company', 'users'));
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        Company::create($request->validated());

        return redirect()->route('company.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company): View
    {
        $this->authorize('view', $company);
        $company->load(['owner', 'jobVacancies']);

        return view('company.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        $this->authorize('update', $company);
        $users = Auth::user()->role === 'admin'
            ? User::orderBy('name', 'asc')->get()
            : User::whereKey(Auth::id())->get();

        return view('company.edit', compact('company', 'users'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return redirect()->route('company.index')
            ->with('success', 'Company updated successfully.');
    }

    // Soft delete (Move to Trash)
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);
        $company->delete();

        return redirect()->route('company.index')
            ->with('success', 'Company moved to trash.');
    }

    // Restore soft-deleted record
    public function restore(string $id): RedirectResponse
    {
        $company = Company::withTrashed()->findOrFail($id);
        $this->authorize('restore', $company);
        $company->restore();

        return redirect()->back()
            ->with('success', 'Company restored successfully.');
    }

    // Permanently remove from database
    public function forceDelete(string $id): RedirectResponse
    {
        $company = Company::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $company);
        $company->forceDelete();

        return redirect()->back()
            ->with('success', 'Company permanently deleted.');
    }
}
