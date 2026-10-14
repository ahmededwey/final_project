<?php

namespace App\Http\Requests;

use App\Models\JobCategory;

class UpdateJobCategoryRequest extends JobCategoryFormRequest
{
    public function rules(): array
    {
        $jobCategory = $this->route('jobCategory');

        return [
            'name' => $this->categoryNameRules($jobCategory instanceof JobCategory ? $jobCategory : null),
        ];
    }
}
