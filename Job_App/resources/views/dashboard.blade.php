<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                {{ __('Your workspace') }}
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                {{ __('Dashboard') }}
            </h1>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (auth()->user()->role === 'admin')
                <section class="mb-6 flex flex-col gap-4 rounded-xl border border-indigo-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between dark:border-slate-800 dark:bg-slate-900">
                    <div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">{{ __('Resume storage') }}</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                            {{ $googleDriveConnected ? __('Google Drive is connected. New resumes will be stored in the configured folder.') : __('Connect Google Drive once to enable resume uploads for applicants.') }}
                        </p>
                    </div>
                    @if ($googleDriveConnected)
                        <div class="flex shrink-0 items-center gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ __('Connected') }}
                            </span>
                            <a href="{{ route('google-drive.connect') }}" class="text-sm font-medium text-indigo-600 transition hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ __('Reconnect') }}
                            </a>
                        </div>
                    @else
                        <a href="{{ route('google-drive.connect') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            {{ __('Connect Google Drive') }}
                        </a>
                    @endif
                </section>
            @endif

            @if (session('status'))
                <div role="status" class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                    {{ session('status') }}
                </div>
            @endif

            @error('google_drive')
                <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                    {{ $message }}
                </div>
            @enderror

            <form method="GET" action="{{ route('dashboard') }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col md:flex-row gap-3 w-full">
                        <div class="flex-1">
                            <input
                                type="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search jobs, companies, or locations..."
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>

                        <div class="flex gap-2 flex-wrap">
                            @foreach (\App\Models\JobVacancy::TYPES as $type)
                                <label class="flex items-center gap-2 px-4 py-2 border rounded-lg cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="job_type[]"
                                        value="{{ $type }}"
                                        @checked(in_array($type, $selectedJobTypes, true))
                                    >
                                    <span>{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                            Search
                        </button>
                        <a href="{{ route('dashboard') }}" class="rounded-lg border px-4 py-2 text-slate-700 dark:text-slate-200">
                            Clear filters
                        </a>
                    </div>
                </div>
            </form>


            {{-- Job Vacancies --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse ($jobs as $job)

                    <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-5">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                            <a href="{{ route('job-vacancies.show', $job->id) }}" class="hover:underline">
                                {{ $job->title }}
                            </a>
                        </h2>

                        <p class="text-slate-500 dark:text-slate-400">
                            {{ $job->company?->name ?? 'Company not listed' }}
                        </p>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                          @if ($job->location === $job->type)
    {{ $job->type }}
@else
    {{ $job->location }} | {{ $job->type }}
@endif
                        </p>

                    </div>

                @empty

                    <div class="col-span-full text-center py-10 text-slate-500">
                        No jobs found.
                    </div>

                @endforelse

            </div>


            {{-- Pagination --}}
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>

        </div>

    </div>

</x-app-layout>