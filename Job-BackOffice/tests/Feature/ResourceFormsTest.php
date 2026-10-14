<?php

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;

test('company category and job vacancy forms share the same fields on create and edit', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $category = JobCategory::create([
        'name' => 'Engineering',
    ]);
    $company = Company::create([
        'name' => 'Example company',
        'address' => '1 Example Street',
        'industry' => 'Technology',
        'description' => 'Example company description',
        'ownerId' => $user->id,
    ]);
    $vacancy = JobVacancy::create([
        'title' => 'Software engineer',
        'description' => 'Build software.',
        'location' => 'Remote',
        'salary' => null,
        'type' => JobVacancy::TYPES[0],
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ]);

    $this->actingAs($user);

    $this->get(route('company.create'))
        ->assertSee('Company name')
        ->assertSee('name="ownerId"', false);
    $this->get(route('company.edit', $company))
        ->assertSee('Company name')
        ->assertSee('Example company');

    $this->get(route('jobCategory.create'))
        ->assertSee('Category name');
    $this->get(route('jobCategory.edit', $category))
        ->assertSee('Category name')
        ->assertSee('Engineering');

    $this->get(route('jobVacancy.create'))
        ->assertSee('Job title')
        ->assertSee('Employment type');
    $this->get(route('jobVacancy.edit', $vacancy))
        ->assertSee('Job title')
        ->assertSee('Software engineer')
        ->assertSee(JobVacancy::TYPES[0]);
});

test('resource routes do not expose controller actions that are not implemented', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get('/resume/create')
        ->assertNotFound();

    $this->post('/jobApplication')
        ->assertStatus(405);

    $this->post('/user')
        ->assertStatus(405);
});

test('resource indexes render the shared active and archive filter', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user);

    foreach ([
        'company.index',
        'jobCategory.index',
        'jobVacancy.index',
        'user.index',
    ] as $routeName) {
        $this->get(route($routeName))
            ->assertSee('Trash Bin')
            ->assertSee('Showing');
    }

    $this->get(route('jobApplication.index'))
        ->assertOk()
        ->assertSee('Job Applications')
        ->assertDontSee('Add Job Application');
});

test('shared company and job vacancy requests validate create and update operations', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $category = JobCategory::create([
        'name' => 'Engineering',
    ]);

    $this->actingAs($user);

    $this->post(route('company.store'), [
        'name' => 'Created company',
        'address' => '1 Example Street',
        'industry' => 'Technology',
        'description' => 'Company description',
        'ownerId' => $user->id,
    ])->assertRedirect(route('company.index'));

    $company = Company::where('name', 'Created company')->firstOrFail();

    $this->put(route('company.update', $company), [
        'name' => 'Updated company',
        'address' => '2 Example Street',
        'industry' => 'Technology',
        'description' => 'Updated description',
        'ownerId' => $user->id,
    ])->assertRedirect(route('company.index'));

    $this->assertDatabaseHas('companies', [
        'id' => $company->id,
        'name' => 'Updated company',
        'address' => '2 Example Street',
    ]);

    $this->post(route('jobVacancy.store'), [
        'title' => 'Created vacancy',
        'description' => 'Vacancy description',
        'location' => 'Remote',
        'salary' => '90000',
        'type' => JobVacancy::TYPES[0],
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ])->assertRedirect(route('jobVacancy.index'));

    $vacancy = JobVacancy::where('title', 'Created vacancy')->firstOrFail();

    $this->put(route('jobVacancy.update', $vacancy), [
        'title' => 'Updated vacancy',
        'description' => 'Updated vacancy description',
        'location' => 'Hybrid',
        'salary' => null,
        'type' => JobVacancy::TYPES[3],
        'companyId' => $company->id,
        'categoryId' => $category->id,
    ])->assertRedirect(route('jobVacancy.index'));

    $this->assertDatabaseHas('job_vacancies', [
        'id' => $vacancy->id,
        'title' => 'Updated vacancy',
        'location' => 'Hybrid',
        'type' => JobVacancy::TYPES[3],
    ]);
});

test('category update accepts its existing name but rejects a duplicate', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $category = JobCategory::create([
        'name' => 'Engineering',
    ]);
    JobCategory::create([
        'name' => 'Design',
    ]);

    $this->actingAs($user);

    $this->put(route('jobCategory.update', $category), [
        'name' => 'Engineering',
    ])->assertRedirect(route('jobCategory.index'));

    $this->put(route('jobCategory.update', $category), [
        'name' => 'Design',
    ])->assertSessionHasErrors('name');
});
