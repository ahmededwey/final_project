<?php

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;

test('dashboard displays vacancies and filters by search and job type', function () {
    $user = User::factory()->create();
    $company = Company::query()->create([
        'name' => 'Acme Robotics',
        'address' => '1 Main Street',
        'industry' => 'Technology',
        'description' => 'Robotics company',
        'ownerId' => $user->id,
    ]);
    $category = JobCategory::query()->create(['name' => 'Engineering']);

    JobVacancy::query()->create([
        'title' => 'Remote PHP Engineer',
        'description' => 'Build web applications',
        'location' => 'Remote',
        'type' => 'Remote',
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ]);
    JobVacancy::query()->create([
        'title' => 'Office Product Designer',
        'description' => 'Design products',
        'location' => 'New York',
        'type' => 'Full-Time',
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard', [
        'search' => 'PHP',
        'job_type' => ['Remote'],
    ]));

    $response->assertOk()
        ->assertSee('Remote PHP Engineer')
        ->assertSee('Acme Robotics')
        ->assertDontSee('Office Product Designer')
        ->assertSee('name="search"', false)
        ->assertSee('name="job_type[]"', false);
});
