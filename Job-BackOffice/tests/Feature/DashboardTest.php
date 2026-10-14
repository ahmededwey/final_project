<?php

use App\Models\User;

test('dashboard displays the number of job seekers active in the last 30 days', function () {
    User::factory()->create([
        'role' => 'job-seeker',
        'last_login_at' => now()->subDays(10),
    ]);

    User::factory()->create([
        'role' => 'job-seeker',
        'last_login_at' => now()->subDays(31),
    ]);

    User::factory()->create([
        'role' => 'company-owner',
        'last_login_at' => now()->subDays(2),
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Active Users')
        ->assertSee('Application activity')
        ->assertSee('Application pipeline')
        ->assertSee('Recent applications')
        ->assertSee('Top openings')
        ->assertSee('No applications yet')
        ->assertSee('1');
});

test('the dashboard is reserved for admins while job seekers can use other authenticated pages', function () {
    $jobSeeker = User::factory()->create([
        'role' => 'job-seeker',
    ]);

    $this->actingAs($jobSeeker)
        ->get(route('dashboard'))
        ->assertForbidden();

    $this->get(route('jobVacancy.index'))
        ->assertOk()
        ->assertDontSee('Dashboard');
});

test('guests must authenticate before opening the dashboard or job vacancies', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));

    $this->get(route('jobVacancy.index'))
        ->assertRedirect(route('login'));
});
