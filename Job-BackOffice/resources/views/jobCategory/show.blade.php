<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Category Details') }}
            </h2>
            <a href="{{ route('jobCategory.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $jobCategory->name }}</h3>
                <p class="text-xs font-mono text-gray-400">ID: {{ $jobCategory->id }}</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="font-semibold text-gray-700 mb-4">Associated Vacancies ({{ $jobCategory->jobVacancies->count() }})</h4>
                <ul class="divide-y divide-gray-200">
                    @forelse ($jobCategory->jobVacancies as $vacancy)
                        <li class="py-3 text-sm text-gray-700">{{ $vacancy->title }}</li>
                    @empty
                        <li class="py-3 text-sm text-gray-500">No vacancies linked to this category yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>