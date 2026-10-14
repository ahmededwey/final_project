<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\User;

class JobVacancyPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'company-owner', 'job-seeker'], true);
    }

    public function view(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->role === 'admin'
            || $user->role === 'job-seeker'
            || ($user->role === 'company-owner'
                && $jobVacancy->company()->where('ownerId', $user->id)->exists());
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'company-owner'], true);
    }

    public function update(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'company-owner'
                && $jobVacancy->company()->where('ownerId', $user->id)->exists());
    }

    public function delete(User $user, JobVacancy $jobVacancy): bool
    {
        return $this->update($user, $jobVacancy);
    }

    public function restore(User $user, JobVacancy $jobVacancy): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'company-owner'
                && Company::withTrashed()
                    ->whereKey($jobVacancy->companyId)
                    ->where('ownerId', $user->id)
                    ->exists());
    }

    public function forceDelete(User $user, JobVacancy $jobVacancy): bool
    {
        return $this->restore($user, $jobVacancy);
    }
}
