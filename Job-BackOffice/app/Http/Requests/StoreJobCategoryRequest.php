<?php

namespace App\Http\Requests;

class StoreJobCategoryRequest extends JobCategoryFormRequest
{
    public function rules(): array
    {
        return ['name' => $this->categoryNameRules()];
    }
}
