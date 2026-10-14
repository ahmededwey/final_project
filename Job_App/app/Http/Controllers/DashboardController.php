<?php

namespace App\Http\Controllers;

use App\Models\GoogleDriveCredential;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'job_type' => ['sometimes', 'array'],
            'job_type.*' => ['string', Rule::in(JobVacancy::TYPES)],
        ]);

        $search = trim($filters['search'] ?? '');
        $selectedJobTypes = $filters['job_type'] ?? [];

        $jobs = JobVacancy::query()
            ->with('company')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('company', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($selectedJobTypes !== [], fn ($query) => $query->whereIn('type', $selectedJobTypes))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $googleDriveConnected = $request->user()->role === 'admin'
            && GoogleDriveCredential::query()->whereKey('primary')->exists();

        return view('dashboard', compact('jobs', 'search', 'selectedJobTypes', 'googleDriveConnected'));
    }
}
