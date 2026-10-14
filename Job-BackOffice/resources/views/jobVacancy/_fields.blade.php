<div class="space-y-5 p-6">
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Job title') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}" required autofocus
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('title') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
        @error('title')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="companyId" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Company') }} <span class="text-red-500">*</span>
            </label>
            <select name="companyId" id="companyId" required
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('companyId') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                <option value="" disabled @selected(old('companyId', $jobVacancy->companyId) === null)>{{ __('Select a company') }}</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(old('companyId', $jobVacancy->companyId) == $company->id)>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            @error('companyId')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="categoryId" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Job category') }} <span class="text-red-500">*</span>
            </label>
            <select name="categoryId" id="categoryId" required
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('categoryId') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                <option value="" disabled @selected(old('categoryId', $jobVacancy->categoryId) === null)>{{ __('Select a category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('categoryId', $jobVacancy->categoryId) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categoryId')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="location" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Location') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}" required
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('location') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
        @error('location')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="salary" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Salary') }} <span class="text-xs font-normal text-gray-500">({{ __('Optional') }})</span>
            </label>
            <input type="number" step="0.01" min="0" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('salary') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('salary')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="type" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Employment type') }} <span class="text-red-500">*</span>
            </label>
            <select name="type" id="type" required
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('type') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(old('type', $jobVacancy->type ?? $types[0]) === $type)>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('type')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Description') }} <span class="text-red-500">*</span>
        </label>
        <textarea name="description" id="description" rows="5" required
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('description') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description', $jobVacancy->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
