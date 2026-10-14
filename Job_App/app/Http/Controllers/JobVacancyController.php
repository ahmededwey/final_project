<?php

namespace App\Http\Controllers;

use App\Models\GoogleDriveCredential;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\GoogleDriveException;
use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class JobVacancyController extends Controller
{
    public function show(string $id): View
    {
        $job = JobVacancy::with(['company', 'category'])->findOrFail($id);

        return view('job-vacancies.show', [
            'job' => $job,
            'googleDriveConnected' => GoogleDriveCredential::query()->whereKey('primary')->exists(),
        ]);
    }

    public function apply(string $id): View
    {
        $job = JobVacancy::with(['company', 'category'])->findOrFail($id);

        return view('job-vacancies.apply', [
            'job' => $job,
            'googleDriveConnected' => GoogleDriveCredential::query()->whereKey('primary')->exists(),
        ]);
    }

    public function processApplication(Request $request, string $id, GoogleDriveService $googleDrive): RedirectResponse
    {
        $job = JobVacancy::query()->findOrFail($id);

        if (! GoogleDriveCredential::query()->whereKey('primary')->exists()) {
            return back()->withErrors([
                'google_drive' => 'Resume uploads are temporarily unavailable. Please contact the site administrator.',
            ]);
        }

        if (JobApplication::query()
            ->where('userId', $request->user()->id)
            ->where('jobVacancyId', $job->id)
            ->exists()) {
            return back()->withErrors([
                'resume' => 'You have already applied for this job.',
            ]);
        }

        $validated = $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'extensions:pdf,doc,docx', 'max:5120'],
        ]);

        try {
            $uploadedFile = $googleDrive->uploadResume($validated['resume']);
        } catch (GoogleDriveException $exception) {
            Log::error('Resume upload to Google Drive failed.', [
                'user_id' => $request->user()->id,
                'job_vacancy_id' => $job->id,
                'exception' => $exception,
            ]);

            return back()->withInput()->withErrors([
                'resume' => 'Your resume could not be uploaded to Google Drive. Please try again.',
            ]);
        }

        $resume = Resume::query()->create([
            'fileName' => $uploadedFile['name'],
            'fileUrl' => $uploadedFile['webViewLink'] ?? 'https://drive.google.com/open?id='.$uploadedFile['id'],
            'driveFileId' => $uploadedFile['id'],
            'userId' => $request->user()->id,
        ]);

        JobApplication::query()->create([
            'status' => 'pending',
            'userId' => $request->user()->id,
            'resumeId' => $resume->id,
            'jobVacancyId' => $job->id,
        ]);

        return redirect()->route('job-vacancies.show', $job)
            ->with('status', 'Your application has been submitted successfully.');
    }
}
