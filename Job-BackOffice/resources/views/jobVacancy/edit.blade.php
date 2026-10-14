<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('jobVacancy.index') }}" class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900" title="{{ __('Back to job vacancies') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold leading-tight text-gray-900">{{ __('Edit job vacancy') }}</h1>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-md">
                <form action="{{ route('jobVacancy.update', $jobVacancy) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('jobVacancy._fields')

                    <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <a href="{{ route('jobVacancy.index') }}" class="rounded-lg px-4 py-2.5 text-xs font-semibold text-gray-700 transition-colors hover:bg-gray-200/70 hover:text-gray-900">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-blue-400/80 bg-blue-50 px-4 py-2 text-xs font-medium uppercase tracking-wider text-blue-700 transition-all hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{ __('Update job vacancy') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
