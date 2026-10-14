<div class="space-y-5 p-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Company name') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required autofocus
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('name') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
        @error('name')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="industry" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Industry') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="industry" id="industry" value="{{ old('industry', $company->industry) }}" required
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('industry') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
            @error('industry')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="ownerId" class="mb-2 block text-sm font-semibold text-gray-900">
                {{ __('Owner') }} <span class="text-red-500">*</span>
            </label>
            <select name="ownerId" id="ownerId" required
                class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('ownerId') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
                <option value="" disabled @selected(old('ownerId', $company->ownerId ?? auth()->id()) === null)>{{ __('Select an owner') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('ownerId', $company->ownerId ?? auth()->id()) == $user->id)>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('ownerId')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Address') }} <span class="text-red-500">*</span>
        </label>
        <input type="text" name="address" id="address" value="{{ old('address', $company->address) }}" required
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('address') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
        @error('address')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="website" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Website') }} <span class="text-xs font-normal text-gray-500">({{ __('Optional') }})</span>
        </label>
        <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}" placeholder="https://example.com"
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('website') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
        @error('website')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-gray-900">
            {{ __('Description') }} <span class="text-xs font-normal text-gray-500">({{ __('Optional') }})</span>
        </label>
        <textarea name="description" id="description" rows="4"
            class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-blue-600 focus:ring-2 focus:ring-blue-600 @error('description') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description', $company->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
