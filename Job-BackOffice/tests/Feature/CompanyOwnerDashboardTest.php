<?php

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;

function createCompanyForDashboard(User $owner, string $name): Company
{
    return Company::create([
        'name' => $name,
        'address' => 'Remote',
        'industry' => 'Technology',
        'description' => $name.' company profile',
        'ownerId' => $owner->id,
    ]);
}

function createVacancyForDashboard(Company $company, JobCategory $category, string $title): JobVacancy
{
    return JobVacancy::create([
        'title' => $title,
        'description' => $title.' role',
        'location' => 'Remote',
        'type' => 'Full-Time',
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ]);
}

test('company owners see their own company and vacancy metrics only', function () {
    $owner = User::factory()->create(['role' => 'company-owner']);
    $otherOwner = User::factory()->create(['role' => 'company-owner']);
    $company = createCompanyForDashboard($owner, 'Owner Company');
    $otherCompany = createCompanyForDashboard($otherOwner, 'Other Company');
    $category = JobCategory::create(['name' => 'Technology']);
    $activeVacancy = createVacancyForDashboard($company, $category, 'Owner Engineer');
    $closedVacancy = createVacancyForDashboard($company, $category, 'Closed Owner Role');
    $closedVacancy->delete();
    createVacancyForDashboard($otherCompany, $category, 'Private Other Role');

    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $resume = Resume::create([
        'fileName' => 'resume.pdf',
        'fileUrl' => 'resumes/resume.pdf',
        'userId' => $applicant->id,
    ]);
    JobApplication::create([
        'userId' => $applicant->id,
        'resumeId' => $resume->id,
        'jobVacancyId' => $activeVacancy->id,
    ]);

    $this->actingAs($owner)
        ->get(route('company-owner.dashboard'))
        ->assertOk()
        ->assertViewHas('totalVacancies', 2)
        ->assertViewHas('activeVacancies', 1)
        ->assertViewHas('closedVacancies', 1)
        ->assertViewHas('totalApplications', 1)
        ->assertSee('Owner Company')
        ->assertSee('Owner Engineer')
        ->assertSee('Closed Owner Role')
        ->assertSee('Total job vacancies')
        ->assertSee('Active vacancies')
        ->assertSee('Closed vacancies')
        ->assertSee('Total applications')
        ->assertSee('Closed')
        ->assertSee($owner->email)
        ->assertDontSee('Other Company')
        ->assertDontSee('Private Other Role')
        ->assertSee('Not set');
});

test('company owners cannot access or modify another company records', function () {
    $owner = User::factory()->create(['role' => 'company-owner']);
    $otherOwner = User::factory()->create(['role' => 'company-owner']);
    $company = createCompanyForDashboard($owner, 'Owner Company');
    $otherCompany = createCompanyForDashboard($otherOwner, 'Private Company');
    $category = JobCategory::create(['name' => 'Technology']);
    $vacancy = createVacancyForDashboard($otherCompany, $category, 'Private Vacancy');

    $applicant = User::factory()->create(['role' => 'job-seeker']);
    $resume = Resume::create([
        'fileName' => 'resume.pdf',
        'fileUrl' => 'resumes/resume.pdf',
        'userId' => $applicant->id,
    ]);
    $application = JobApplication::create([
        'userId' => $applicant->id,
        'resumeId' => $resume->id,
        'jobVacancyId' => $vacancy->id,
    ]);

    $this->actingAs($owner)
        ->get(route('dashboard'))
        ->assertForbidden();

    $this->get(route('company.show', $otherCompany))
        ->assertForbidden();

    $this->get(route('jobVacancy.show', $vacancy))
        ->assertForbidden();

    $this->get(route('jobApplication.show', $application))
        ->assertForbidden();

    $this->get(route('jobVacancy.index'))
        ->assertOk()
        ->assertDontSee('Private Vacancy');

    $this->get(route('jobApplication.index'))
        ->assertOk()
        ->assertDontSee('Private Vacancy');

    $this->get(route('company.index'))
        ->assertOk()
        ->assertSee('Owner Company')
        ->assertDontSee('Private Company');

    $this->assertDatabaseHas('companies', [
        'id' => $company->id,
        'ownerId' => $owner->id,
    ]);
});

test('company owners cannot move a vacancy to another company', function () {
    $owner = User::factory()->create(['role' => 'company-owner']);
    $otherOwner = User::factory()->create(['role' => 'company-owner']);
    $company = createCompanyForDashboard($owner, 'Owner Company');
    $otherCompany = createCompanyForDashboard($otherOwner, 'Other Company');
    $category = JobCategory::create(['name' => 'Technology']);
    $vacancy = createVacancyForDashboard($company, $category, 'Owner Vacancy');

    $this->actingAs($owner)
        ->put(route('jobVacancy.update', $vacancy), [
            'title' => $vacancy->title,
            'description' => $vacancy->description,
            'location' => $vacancy->location,
            'type' => $vacancy->type,
            'companyId' => $otherCompany->id,
            'categoryId' => $category->id,
        ])
        ->assertSessionHasErrors('companyId');

    $this->assertDatabaseHas('job_vacancies', [
        'id' => $vacancy->id,
        'companyId' => $company->id,
    ]);
});

test('company owners can create a company but cannot assign it to another account', function () {
    $owner = User::factory()->create(['role' => 'company-owner']);
    $otherOwner = User::factory()->create(['role' => 'company-owner']);

    $this->actingAs($owner)
        ->post(route('company.store'), [
            'name' => 'New Owner Company',
            'address' => 'Remote',
            'industry' => 'Technology',
            'ownerId' => $otherOwner->id,
        ])
        ->assertRedirect(route('company.index'));

    $this->assertDatabaseHas('companies', [
        'name' => 'New Owner Company',
        'ownerId' => $owner->id,
        'description' => '',
    ]);
});

test('company owners without a company see a create-company call to action', function () {
    $owner = User::factory()->create(['role' => 'company-owner']);

    $this->actingAs($owner)
        ->get(route('company-owner.dashboard'))
        ->assertOk()
        ->assertSee("You haven't created your company yet.", false)
        ->assertSee('Create Company');
});

test('administrators retain global access to company and vacancy listings', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $ownerA = User::factory()->create(['role' => 'company-owner']);
    $ownerB = User::factory()->create(['role' => 'company-owner']);
    $companyA = createCompanyForDashboard($ownerA, 'Company Alpha');
    $companyB = createCompanyForDashboard($ownerB, 'Company Beta');
    $category = JobCategory::create(['name' => 'Technology']);
    createVacancyForDashboard($companyA, $category, 'Alpha Vacancy');
    createVacancyForDashboard($companyB, $category, 'Beta Vacancy');

    $this->actingAs($admin)
        ->get(route('company.index'))
        ->assertOk()
        ->assertSee('Company Alpha')
        ->assertSee('Company Beta');

    $this->get(route('jobVacancy.index'))
        ->assertOk()
        ->assertSee('Alpha Vacancy')
        ->assertSee('Beta Vacancy');
});
