<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

abstract class CompanyFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->isMethod('POST')
            ? $this->user()->can('create', Company::class)
            : $this->user()->can('update', $this->route('company'));
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('description') === null) {
            $this->merge(['description' => '']);
        }

        if ($this->user()->role === 'company-owner') {
            $this->merge(['ownerId' => $this->user()->id]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'industry' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'ownerId' => ['required', 'string', 'exists:users,id'],
        ];
    }
}
