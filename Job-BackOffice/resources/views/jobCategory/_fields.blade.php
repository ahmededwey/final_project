<div>
    <label for="name" class="mb-2 block text-sm font-semibold text-gray-900">
        {{ __('Category name') }} <span class="text-red-500">*</span>
    </label>
    <input type="text" name="name" id="name" value="{{ old('name', $jobCategory->name) }}" required autofocus
        class="block w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm transition-all focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 text-red-900 focus:border-red-500 focus:ring-red-500 @enderror">
    @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
