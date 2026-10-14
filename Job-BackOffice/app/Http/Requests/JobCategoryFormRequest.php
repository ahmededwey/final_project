<?php

namespace App\Http\Requests;

use App\Models\JobCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class JobCategoryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<int, string|ValidationRule>
     */
    protected function categoryNameRules(?JobCategory $jobCategory = null): array
    {
        $uniqueRule = Rule::unique('job_categories', 'name');

        if ($jobCategory !== null) {
            $uniqueRule->ignore($jobCategory);
        }

        return [
            'required',
            'string',
            'max:255',
            $uniqueRule,
        ];
    }
}
