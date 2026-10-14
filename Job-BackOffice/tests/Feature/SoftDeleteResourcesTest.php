<?php

use App\Models\JobCategory;
use App\Models\User;

test('category filters and trash actions use shared soft delete behavior', function () {
    $activeCategory = JobCategory::create([
        'name' => 'Active category',
    ]);
    $trashedCategory = JobCategory::create([
        'name' => 'Archived category',
    ]);
    $trashedCategory->delete();

    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)
        ->get(route('jobCategory.index', ['trashed' => 'only']))
        ->assertSee('Archived category')
        ->assertDontSee('Active category');

    $this->get(route('jobCategory.index', ['trashed' => 'with']))
        ->assertSee('Archived category')
        ->assertSee('Active category');

    $this->post(route('jobCategory.restore', $trashedCategory->id))
        ->assertSessionHas('success', 'Job category restored successfully.');

    expect($trashedCategory->fresh()->trashed())->toBeFalse();

    $this->delete(route('jobCategory.force-delete', $trashedCategory->id))
        ->assertSessionHas('success', 'Job category permanently deleted.');

    $this->assertDatabaseMissing('job_categories', ['id' => $trashedCategory->id]);
    $this->assertDatabaseHas('job_categories', ['id' => $activeCategory->id]);
});
