<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $jobVacancies = JobVacancy::with(['company', 'category'])
            ->withCount('jobApplications')
            ->latest()
            ->take(6)
            ->get();

        return view('home.index', compact('jobVacancies'));
    }
}
