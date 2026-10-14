<?php

use App\Models\User;

test('authenticated users can view the home page', function () {
    $user = User::factory()->create([
        'role' => 'job-seeker',
    ]);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Latest job openings')
        ->assertSee('No job openings yet')
        ->assertSee('Home')
        ->assertDontSee('Open admin dashboard');
});

test('admins can open the home page and use its dashboard shortcut', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Open admin dashboard')
        ->assertSee('Dashboard');
});
