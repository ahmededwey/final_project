<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'company-owner'], true);
    }

    public function view(User $user, Company $company): bool
    {
        return $user->role === 'admin'
            || ($user->role === 'company-owner' && $company->ownerId === $user->id);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'company-owner'], true);
    }

    public function update(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }

    public function delete(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }

    public function restore(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $this->view($user, $company);
    }
}
