<?php

use App\Models\Company;
use App\Models\GoogleDriveCredential;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

function createJobVacancyForResumeUpload(User $owner): JobVacancy
{
    $company = Company::query()->create([
        'name' => 'Resume Upload Company',
        'address' => '1 Main Street',
        'industry' => 'Technology',
        'description' => 'Company description',
        'ownerId' => $owner->id,
    ]);
    $category = JobCategory::query()->create(['name' => 'Resume Upload Engineering']);

    return JobVacancy::query()->create([
        'title' => 'Software Engineer',
        'description' => 'Build software.',
        'location' => 'Remote',
        'type' => 'Remote',
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ]);
}

test('an administrator can start the Google Drive authorization flow', function () {
    config([
        'services.google_drive.client_id' => 'test-client-id',
        'services.google_drive.redirect_uri' => 'http://localhost/google-drive/callback',
    ]);
    Http::preventStrayRequests();
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('google-drive.connect'));

    $response->assertRedirect();
    parse_str((string) parse_url($response->headers->get('Location'), PHP_URL_QUERY), $query);
    expect($query)
        ->toMatchArray([
            'client_id' => 'test-client-id',
            'redirect_uri' => 'http://localhost/google-drive/callback',
            'scope' => 'https://www.googleapis.com/auth/drive.file',
            'access_type' => 'offline',
        ]);
});

test('non-administrators cannot start Google Drive authorization', function () {
    $jobSeeker = User::factory()->create(['role' => 'job-seeker']);

    $this->actingAs($jobSeeker)
        ->get(route('google-drive.connect'))
        ->assertForbidden();
});

test('the Google Drive callback rejects an invalid OAuth state', function () {
    Http::preventStrayRequests();
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->withSession(['google_drive.oauth_state' => 'expected-state'])
        ->get(route('google-drive.callback', ['state' => 'unexpected-state', 'code' => 'authorization-code']))
        ->assertForbidden();
});

test('the administrator callback stores encrypted Google Drive tokens', function () {
    config([
        'services.google_drive.client_id' => 'test-client-id',
        'services.google_drive.client_secret' => 'test-client-secret',
        'services.google_drive.redirect_uri' => 'http://localhost/google-drive/callback',
    ]);
    Http::preventStrayRequests();
    Http::fake([
        'https://oauth2.googleapis.com/token' => Http::response([
            'access_token' => 'access-token-value',
            'refresh_token' => 'refresh-token-value',
            'expires_in' => 3600,
        ]),
    ]);
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->withSession(['google_drive.oauth_state' => 'valid-state'])
        ->get(route('google-drive.callback', ['state' => 'valid-state', 'code' => 'authorization-code']));

    $response->assertRedirect(route('dashboard'))
        ->assertSessionHas('status', 'Google Drive connected successfully.');
    $credential = GoogleDriveCredential::query()->findOrFail('primary');
    expect($credential->accessToken)->toBe('access-token-value')
        ->and($credential->refreshToken)->toBe('refresh-token-value')
        ->and($credential->connectedByUserId)->toBe($admin->id)
        ->and($credential->getRawOriginal('accessToken'))->not->toBe('access-token-value')
        ->and($credential->getRawOriginal('refreshToken'))->not->toBe('refresh-token-value');
    Http::assertSent(fn (ClientRequest $request): bool => $request->url() === 'https://oauth2.googleapis.com/token'
        && $request['grant_type'] === 'authorization_code'
        && $request['code'] === 'authorization-code');
});

test('an applicant resume is uploaded privately to the configured folder and saved with the application', function () {
    config(['services.google_drive.folder_id' => 'configured-folder-id']);
    Http::preventStrayRequests();
    Http::fake([
        'https://www.googleapis.com/upload/drive/v3/files*' => Http::response([
            'id' => 'drive-file-id',
            'name' => 'resume.pdf',
            'webViewLink' => 'https://drive.google.com/file/d/drive-file-id/view',
        ]),
    ]);
    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $job = createJobVacancyForResumeUpload(User::factory()->create(['role' => 'company-owner']));
    GoogleDriveCredential::query()->create([
        'id' => 'primary',
        'connectedByUserId' => User::factory()->create(['role' => 'admin'])->id,
        'accessToken' => 'valid-access-token',
        'refreshToken' => 'valid-refresh-token',
        'expiresAt' => now()->addHour(),
    ]);

    $response = $this->actingAs($applicant)->post(
        route('job-vacancies.processApplication', $job->id),
        ['resume' => UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\nTest resume")],
    );

    $response->assertRedirect(route('job-vacancies.show', $job))
        ->assertSessionHas('status', 'Your application has been submitted successfully.');
    $resume = Resume::query()->firstOrFail();
    $application = JobApplication::query()->firstOrFail();
    expect($resume->fileName)->toBe('resume.pdf')
        ->and($resume->fileUrl)->toBe('https://drive.google.com/file/d/drive-file-id/view')
        ->and($resume->driveFileId)->toBe('drive-file-id')
        ->and($resume->userId)->toBe($applicant->id)
        ->and($application->userId)->toBe($applicant->id)
        ->and($application->resumeId)->toBe($resume->id)
        ->and($application->jobVacancyId)->toBe($job->id)
        ->and($application->status)->toBe('pending');
    Http::assertSent(fn (ClientRequest $request): bool => $request->url() === 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink'
        && $request->hasHeader('Authorization', 'Bearer valid-access-token')
        && str_contains($request->body(), '"parents":["configured-folder-id"]')
        && str_contains($request->body(), 'resume.pdf'));
});

test('invalid resume uploads do not call Google Drive or create an application', function () {
    Http::preventStrayRequests();
    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $job = createJobVacancyForResumeUpload(User::factory()->create(['role' => 'company-owner']));
    GoogleDriveCredential::query()->create([
        'id' => 'primary',
        'accessToken' => 'valid-access-token',
        'refreshToken' => 'valid-refresh-token',
        'expiresAt' => now()->addHour(),
    ]);

    $response = $this->actingAs($applicant)->post(
        route('job-vacancies.processApplication', $job->id),
        ['resume' => UploadedFile::fake()->create('malware.exe', 10)],
    );

    $response->assertSessionHasErrors('resume');
    $this->assertDatabaseCount('resumes', 0);
    $this->assertDatabaseCount('job_applications', 0);
});

test('applicants cannot upload a second resume for a job they already applied to', function () {
    Http::preventStrayRequests();
    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $job = createJobVacancyForResumeUpload(User::factory()->create(['role' => 'company-owner']));
    $resume = Resume::query()->create([
        'fileName' => 'existing-resume.pdf',
        'fileUrl' => 'https://drive.google.com/open?id=existing-drive-file',
        'driveFileId' => 'existing-drive-file',
        'userId' => $applicant->id,
    ]);
    JobApplication::query()->create([
        'status' => 'pending',
        'userId' => $applicant->id,
        'resumeId' => $resume->id,
        'jobVacancyId' => $job->id,
    ]);
    GoogleDriveCredential::query()->create([
        'id' => 'primary',
        'accessToken' => 'valid-access-token',
        'refreshToken' => 'valid-refresh-token',
        'expiresAt' => now()->addHour(),
    ]);

    $response = $this->actingAs($applicant)->post(
        route('job-vacancies.processApplication', $job->id),
        ['resume' => UploadedFile::fake()->createWithContent('another-resume.pdf', "%PDF-1.4\nTest resume")],
    );

    $response->assertSessionHasErrors('resume');
    $this->assertDatabaseCount('resumes', 1);
    $this->assertDatabaseCount('job_applications', 1);
});

test('a Google Drive upload failure leaves no resume or application record', function () {
    Http::preventStrayRequests();
    Http::fake([
        'https://www.googleapis.com/upload/drive/v3/files*' => Http::response(['error' => 'forbidden'], 403),
    ]);
    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $job = createJobVacancyForResumeUpload(User::factory()->create(['role' => 'company-owner']));
    GoogleDriveCredential::query()->create([
        'id' => 'primary',
        'accessToken' => 'valid-access-token',
        'refreshToken' => 'valid-refresh-token',
        'expiresAt' => now()->addHour(),
    ]);

    $response = $this->actingAs($applicant)->post(
        route('job-vacancies.processApplication', $job->id),
        ['resume' => UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\nTest resume")],
    );

    $response->assertSessionHasErrors('resume');
    $this->assertDatabaseCount('resumes', 0);
    $this->assertDatabaseCount('job_applications', 0);
});
test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
