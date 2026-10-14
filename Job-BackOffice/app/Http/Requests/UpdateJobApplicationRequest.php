<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   
    public function rules(): array
    {
        return [
        'status'=> ['required', 'string', Rule::in(['pending','accepted','rejected'])],
        // 'aiGeneratedScore'  => ['nullable', 'numeric', 'min:0', 'max:10.00'],
        // 'aiGeneratedFeedback'=>['nullable','string'],
        // 'userId'=> ['required', 'uuid', Rule::exists('users', 'id')],
        // 'resumeId'=> ['required', 'uuid', Rule::exists('resumes', 'id')],
        // 'jobVacancyId'=> ['required', 'uuid', Rule::exists('job_vacancies', 'id')],  
        ];
    }
       /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'resumeId'  => 'resume',
            'jobVacancyId' => 'job vacancy',
        ];
    }
}
