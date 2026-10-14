<?php

namespace App\Http\Requests;

use App\Models\JobVacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class JobVacancyFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->isMethod('POST')
            ? $this->user()->can('create', JobVacancy::class)
            : $this->user()->can('update', $this->route('jobVacancy'));
    }

    public function rules(): array
    {
        $companyRule = Rule::exists('companies', 'id');
        if ($this->user()->role === 'company-owner') {
            $companyRule->where('ownerId', $this->user()->id);
        }

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'type' => ['required', 'string', Rule::in(JobVacancy::TYPES)],
            'companyId' => ['required', 'uuid', $companyRule],
            'categoryId' => ['required', 'uuid', Rule::exists('job_categories', 'id')],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'companyId' => 'company',
            'categoryId' => 'job category',
            'type' => 'employment type',
        ];
    }
}
