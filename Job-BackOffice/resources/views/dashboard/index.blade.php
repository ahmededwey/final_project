<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ now()->format('l, F j, Y') }}</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                    {{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Here’s what’s happening across your hiring workspace.') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('jobApplication.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm8 1.5V7h2.5L12 4.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H6Z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Review applications') }}
                </a>
                <a href="{{ route('jobVacancy.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 3a1 1 0 0 1 1 1v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5H4a1 1 0 1 1 0-2h5V4a1 1 0 0 1 1-1Z" />
                    </svg>
                    {{ __('Post a job') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="relative isolate overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-indigo-800 px-6 py-7 shadow-lg sm:px-8 sm:py-8">
                <div class="absolute -right-12 -top-24 -z-10 h-72 w-72 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <div class="absolute -bottom-32 right-1/3 -z-10 h-64 w-64 rounded-full bg-cyan-300/10 blur-3xl"></div>
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="max-w-xl">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-100">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            {{ __('Hiring overview') }}
                        </div>
                        <h2 class="mt-4 text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ __('Build your next great team.') }}</h2>
                        <p class="mt-2 max-w-lg text-sm leading-6 text-indigo-100/80">
                            {{ __('Track candidates, keep your openings moving, and spot what needs attention today.') }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 sm:min-w-64">
                        <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs font-medium text-indigo-100/75">{{ __('New this week') }}</p>
                            <p class="mt-1 text-2xl font-bold text-white">{{ number_format($applicationsLast7Days) }}</p>
                            <p class="mt-0.5 text-xs text-indigo-100/75">{{ __('applications') }}</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs font-medium text-indigo-100/75">{{ __('Needs review') }}</p>
                            <p class="mt-1 text-2xl font-bold text-white">{{ number_format($pendingApplications) }}</p>
                            <p class="mt-0.5 text-xs text-indigo-100/75">{{ __('pending') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section aria-label="{{ __('Key metrics') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Job applications') }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalApplications) }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm8 1.5V7h2.5L12 4.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H6Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs">
                        <span class="rounded-full bg-amber-50 px-2 py-1 font-semibold text-amber-700">{{ number_format($pendingApplications) }} {{ __('pending') }}</span>
                        <span class="text-gray-400">{{ __('across all openings') }}</span>
                    </div>
                </article>

                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Active job postings') }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalJobs) }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1ZM4 8h12v8H4V8Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs">
                        <span class="font-semibold text-cyan-700">{{ __('Open for candidates') }}</span>
                        <a href="{{ route('jobVacancy.index') }}" class="ml-auto font-semibold text-indigo-600 hover:text-indigo-700">{{ __('View jobs') }} <span aria-hidden="true">→</span></a>
                    </div>
                </article>

                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Active Users') }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($activeUsers) }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM3 18a7 7 0 1 1 14 0H3Zm12.5-9.1a3.5 3.5 0 1 0-1.1-6.8 5.5 5.5 0 0 1 0 6.1c.4.2.7.4 1.1.7ZM17 18h2a5 5 0 0 0-3.5-4.8 8.9 8.9 0 0 1 1.5 4.8Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span class="text-gray-500">{{ __('Logged in within the last 30 days') }}</span>
                    </div>
                </article>

                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Partner companies') }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalCompanies) }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M3 18V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v9h-6v-3H9v3H3Zm2-2h2v-2h2v2h2V5H5v11Zm2-9h2v2H7V7Zm0 4h2v2H7v-2Zm6 0h2v2h-2v-2Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-xs">
                        <a href="{{ route('company.index') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">{{ __('Manage companies') }} <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6 xl:col-span-2">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">{{ __('Application activity') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('New submissions over the last seven days') }}</p>
                        </div>
                        <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700">{{ number_format($applicationsLast7Days) }} {{ __('this week') }}</span>
                    </div>

                    <div class="mt-7 grid h-48 grid-cols-7 items-end gap-2 sm:gap-4" role="img" aria-label="{{ __('Application activity for the last seven days') }}">
                        @foreach ($applicationTrend as $point)
                            <div class="flex h-full min-w-0 flex-col items-center justify-end gap-2">
                                <span class="text-xs font-semibold text-gray-600">{{ $point['count'] }}</span>
                                <div class="flex h-36 w-full items-end rounded-t-lg bg-slate-50">
                                    <div
                                        class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-violet-400 transition-all"
                                        style="height: {{ (int) $point['count'] === 0 ? 0 : max(12, (int) round($point['count'] / $applicationTrendMax * 100)) }}%"
                                        title="{{ $point['date'] }}: {{ $point['count'] }} {{ __('applications') }}"
                                    ></div>
                                </div>
                                <span class="text-xs font-medium text-gray-500">{{ $point['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex justify-between border-t border-gray-100 pt-3 text-xs text-gray-400">
                        <span>{{ $applicationTrend->first()['date'] }}</span>
                        <span>{{ $applicationTrend->last()['date'] }}</span>
                    </div>
                </article>

                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">{{ __('Application pipeline') }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ __('A snapshot of candidate decisions') }}</p>
                    </div>
                    @php
                        $pipelineTotal = max($totalApplications, 1);
                        $pendingPercent = (int) round($pendingApplications / $pipelineTotal * 100);
                        $acceptedPercent = (int) round($acceptedApplications / $pipelineTotal * 100);
                        $rejectedPercent = (int) round($rejectedApplications / $pipelineTotal * 100);
                    @endphp
                    <div class="mt-6 flex h-2 overflow-hidden rounded-full bg-gray-100" role="img" aria-label="{{ __('Pending :pending, accepted :accepted, rejected :rejected', ['pending' => $pendingApplications, 'accepted' => $acceptedApplications, 'rejected' => $rejectedApplications]) }}">
                        <span class="bg-amber-400" style="width: {{ $pendingPercent }}%"></span>
                        <span class="bg-emerald-500" style="width: {{ $acceptedPercent }}%"></span>
                        <span class="bg-rose-400" style="width: {{ $rejectedPercent }}%"></span>
                    </div>
                    <div class="mt-6 space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                                <span class="text-sm font-medium text-gray-600">{{ __('Pending review') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($pendingApplications) }} <span class="ml-1 font-normal text-gray-400">{{ $pendingPercent }}%</span></span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-sm font-medium text-gray-600">{{ __('Accepted') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($acceptedApplications) }} <span class="ml-1 font-normal text-gray-400">{{ $acceptedPercent }}%</span></span>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
                                <span class="text-sm font-medium text-gray-600">{{ __('Rejected') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($rejectedApplications) }} <span class="ml-1 font-normal text-gray-400">{{ $rejectedPercent }}%</span></span>
                        </div>
                    </div>
                    <a href="{{ route('jobApplication.index') }}" class="mt-7 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        {{ __('Open application inbox') }} <span aria-hidden="true">→</span>
                    </a>
                </article>
            </section>

            <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm xl:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-5 sm:px-6">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">{{ __('Recent applications') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Stay on top of your latest candidates') }}</p>
                        </div>
                        <a href="{{ route('jobApplication.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">{{ __('View all') }} <span aria-hidden="true">→</span></a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 text-left">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">{{ __('Candidate') }}</th>
                                    <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Position') }}</th>
                                    <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Status') }}</th>
                                    <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ __('Applied') }}</th>
                                    <th scope="col" class="px-5 py-3"><span class="sr-only">{{ __('Open application') }}</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($recentApplications as $application)
                                    @php
                                        $statusClasses = match ($application->status) {
                                            'accepted' => 'bg-emerald-50 text-emerald-700',
                                            'rejected' => 'bg-rose-50 text-rose-700',
                                            default => 'bg-amber-50 text-amber-700',
                                        };
                                    @endphp
                                    <tr class="transition hover:bg-slate-50/80">
                                        <td class="whitespace-nowrap px-5 py-4 sm:px-6">
                                            <div class="flex items-center gap-3">
                                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-700">
                                                    {{ strtoupper(substr($application->user->name ?? 'A', 0, 1)) }}
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold text-gray-900">{{ $application->user->name ?? __('Unknown candidate') }}</p>
                                                    <p class="truncate text-xs text-gray-500">{{ $application->user->email ?? __('No email available') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <p class="max-w-44 truncate text-sm font-medium text-gray-800">{{ $application->jobVacancy->title ?? __('Job no longer available') }}</p>
                                            <p class="max-w-44 truncate text-xs text-gray-500">{{ $application->jobVacancy->company->name ?? __('') }}</p>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">{{ ucfirst($application->status) }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $application->created_at->diffForHumans() }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            <a href="{{ route('jobApplication.show', $application) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-indigo-50 hover:text-indigo-600" aria-label="{{ __('View application from :name', ['name' => $application->user->name ?? __('candidate')]) }}">
                                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M3.22 10a7.5 7.5 0 0 1 13.56 0 7.5 7.5 0 0 1-13.56 0Zm6.78-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm0 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4Z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-gray-400">
                                                <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm8 1.5V7h2.5L12 4.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <p class="mt-3 text-sm font-semibold text-gray-900">{{ __('No applications yet') }}</p>
                                            <p class="mt-1 text-sm text-gray-500">{{ __('New candidate submissions will appear here.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-base font-bold text-gray-900">{{ __('Top openings') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Ranked by applications received') }}</p>
                        </div>
                        <span class="rounded-lg bg-violet-50 px-2.5 py-1.5 text-xs font-semibold text-violet-700">{{ __('Top 5') }}</span>
                    </div>
                    @php
                        $maxVacancyApplications = max(1, (int) $topVacancies->max('job_applications_count'));
                    @endphp
                    <div class="mt-5 space-y-5">
                        @forelse ($topVacancies as $vacancy)
                            <a href="{{ route('jobVacancy.show', $vacancy) }}" class="group block">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-800 transition group-hover:text-indigo-600">{{ $vacancy->title }}</p>
                                        <p class="mt-0.5 truncate text-xs text-gray-500">{{ $vacancy->company->name ?? __('Company unavailable') }}</p>
                                    </div>
                                    <span class="shrink-0 text-sm font-bold text-gray-700">{{ number_format($vacancy->job_applications_count) }}</span>
                                </div>
                                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-violet-400" style="width: {{ (int) $vacancy->job_applications_count === 0 ? 0 : max(4, (int) round($vacancy->job_applications_count / $maxVacancyApplications * 100)) }}%"></div>
                                </div>
                            </a>
                        @empty
                            <div class="rounded-xl bg-slate-50 px-4 py-8 text-center">
                                <p class="text-sm font-semibold text-gray-800">{{ __('No job openings yet') }}</p>
                                <a href="{{ route('jobVacancy.create') }}" class="mt-2 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-700">{{ __('Create your first job') }} <span class="ml-1" aria-hidden="true">→</span></a>
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('jobVacancy.index') }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        {{ __('Manage all openings') }} <span aria-hidden="true">→</span>
                    </a>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
