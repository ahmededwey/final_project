<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;

class JobApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'company-owner'], true);
    }

    public function view(User $user, JobApplication $jobApplication): bool
    {
        return $this->ownsApplication($user, $jobApplication);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, JobApplication $jobApplication): bool
    {
        return $this->ownsApplication($user, $jobApplication);
    }

    public function delete(User $user, JobApplication $jobApplication): bool
    {
        return $this->ownsApplication($user, $jobApplication);
    }

    public function restore(User $user, JobApplication $jobApplication): bool
    {
        return $this->ownsApplication($user, $jobApplication);
    }

    public function forceDelete(User $user, JobApplication $jobApplication): bool
    {
        return $this->ownsApplication($user, $jobApplication);
    }

    private function ownsApplication(User $user, JobApplication $jobApplication): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'company-owner'
                && JobVacancy::withTrashed()
                    ->whereKey($jobApplication->jobVacancyId)
                    ->whereHas('company', fn ($query) => $query->withTrashed()->where('ownerId', $user->id))
                    ->exists());
    }
}
