<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-indigo-600">Company workspace</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">Manage your companies, open roles, and incoming applications.</p>
            </div>
            @if ($companies->isNotEmpty())
                <a href="{{ route('jobVacancy.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 4a1 1 0 0 1 1 1v4h4a1 1 0 1 1 0 2h-4v4a1 1 0 1 1-2 0v-4H5a1 1 0 1 1 0-2h4V5a1 1 0 0 1 1-1Z" /></svg>
                    Create Job Vacancy
                </a>
            @endif
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <section aria-labelledby="overview-heading">
            <div class="mb-4">
                <h2 id="overview-heading" class="text-lg font-semibold text-gray-900">Overview</h2>
                <p class="mt-1 text-sm text-gray-500">A snapshot of your hiring activity.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['label' => 'Total job vacancies', 'value' => $totalVacancies, 'color' => 'indigo', 'icon' => 'M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1ZM4 8h12v8H4V8Z'],
                    ['label' => 'Active vacancies', 'value' => $activeVacancies, 'color' => 'emerald', 'icon' => 'M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm4.2 5.8-4.7 5a1 1 0 0 1-1.5 0L5.8 10.5a1 1 0 0 1 1.4-1.4l1.6 1.6 4-4.2a1 1 0 0 1 1.4 1.3Z'],
                    ['label' => 'Closed vacancies', 'value' => $closedVacancies, 'color' => 'amber', 'icon' => 'M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm3 9H7a1 1 0 1 1 0-2h6a1 1 0 1 1 0 2Z'],
                    ['label' => 'Total applications', 'value' => $totalApplications, 'color' => 'sky', 'icon' => 'M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.4a2 2 0 0 0-.6-1.4l-3.4-3.4a2 2 0 0 0-1.4-.6H4Zm7 1.5L14.5 8H12a1 1 0 0 1-1-1V4.5ZM5 11a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H6Z'],
                ] as $stat)
                    <article class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                                <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($stat['value']) }}</p>
                            </div>
                            <span @class([
                                'flex h-11 w-11 items-center justify-center rounded-xl',
                                'bg-indigo-50 text-indigo-600' => $stat['color'] === 'indigo',
                                'bg-emerald-50 text-emerald-600' => $stat['color'] === 'emerald',
                                'bg-amber-50 text-amber-600' => $stat['color'] === 'amber',
                                'bg-sky-50 text-sky-600' => $stat['color'] === 'sky',
                            ])>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="{{ $stat['icon'] }}" /></svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section aria-labelledby="companies-heading">
            <div class="mb-4 flex items-end justify-between gap-4">
                <div>
                    <h2 id="companies-heading" class="text-lg font-semibold text-gray-900">My Company</h2>
                    <p class="mt-1 text-sm text-gray-500">Company profiles linked to your account.</p>
                </div>
                @if ($companies->isNotEmpty())
                    <a href="{{ route('company.create') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Add company</a>
                @endif
            </div>

            @if ($companies->isEmpty())
                <div class="rounded-2xl border border-dashed border-indigo-200 bg-white px-6 py-12 text-center shadow-sm">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 18V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v9h-6v-3H9v3H3Zm2-2h2v-2h2v2h2V5H5v11Zm2-9h2v2H7V7Zm0 4h2v2H7v-2Z" clip-rule="evenodd" /></svg>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-gray-900">You haven't created your company yet.</h3>
                    <p class="mt-2 text-sm text-gray-500">Create a company profile before publishing your first vacancy.</p>
                    <a href="{{ route('company.create') }}" class="mt-5 inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">Create Company</a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
                    @foreach ($companies as $company)
                        <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                            <div class="flex items-start gap-4 border-b border-gray-100 p-5 sm:p-6">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-600 text-lg font-bold text-white">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($company->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="truncate text-lg font-semibold text-gray-900">{{ $company->name }}</h3>
                                    <p class="mt-0.5 text-sm text-gray-500">{{ $company->industry }}</p>
                                    <p class="mt-2 flex items-center gap-1.5 text-sm text-gray-500">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18s6-5.2 6-10A6 6 0 1 0 4 8c0 4.8 6 10 6 10Zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" /></svg>
                                        {{ $company->address }}
                                    </p>
                                </div>
                                <a href="{{ route('company.edit', $company) }}" class="shrink-0 rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">Edit Company</a>
                            </div>
                            <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6">
                                <div class="sm:col-span-2">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">About</p>
                                    <p class="mt-1 line-clamp-3 text-sm leading-6 text-gray-600">{{ $company->description ?: 'No company description provided.' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Website</p>
                                    @if ($company->website)
                                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="mt-1 block truncate text-sm font-medium text-indigo-600 hover:text-indigo-700">{{ $company->website }}</a>
                                    @else
                                        <p class="mt-1 text-sm text-gray-500">Not provided</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Email</p>
                                    <p class="mt-1 truncate text-sm text-gray-700">{{ $company->owner?->email ?? auth()->user()->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Phone</p>
                                    <p class="mt-1 text-sm text-gray-500">Not provided</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Active vacancies</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ number_format($company->active_job_vacancies_count) }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section aria-labelledby="vacancies-heading" class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 id="vacancies-heading" class="text-lg font-semibold text-gray-900">My Job Vacancies</h2>
                    <p class="mt-1 text-sm text-gray-500">Your latest active roles and their application activity.</p>
                </div>
                @if ($companies->isNotEmpty())
                    <a href="{{ route('jobVacancy.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Manage vacancies <span aria-hidden="true">→</span></a>
                @endif
            </div>
            @if ($companies->isEmpty())
                <div class="px-6 py-10 text-center text-sm text-gray-500">Create your company profile to start managing job vacancies.</div>
            @elseif ($jobVacancies->isEmpty())
                <div class="px-6 py-10 text-center">
                    <p class="text-sm font-medium text-gray-700">No job vacancies yet.</p>
                    <a href="{{ route('jobVacancy.create') }}" class="mt-2 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-700">Create your first vacancy</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 sm:px-6">Position</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Applications</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Created</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Expires</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 sm:px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($jobVacancies as $vacancy)
                                <tr class="align-top transition hover:bg-gray-50/70">
                                    <td class="px-5 py-4 sm:px-6">
                                        @if ($vacancy->trashed())
                                            <span class="font-semibold text-gray-900">{{ $vacancy->title }}</span>
                                        @else
                                            <a href="{{ route('jobVacancy.show', $vacancy) }}" class="font-semibold text-gray-900 hover:text-indigo-600">{{ $vacancy->title }}</a>
                                        @endif
                                        <p class="mt-1 text-xs text-gray-500">{{ $vacancy->category?->name ?? 'Uncategorized' }} · {{ $vacancy->company?->name }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($vacancy->trashed())
                                            <span class="inline-flex rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">Closed</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm font-medium text-gray-700">{{ number_format($vacancy->job_applications_count) }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">{{ $vacancy->created_at?->format('M j, Y') ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500">Not set</td>
                                    <td class="px-5 py-4 text-right sm:px-6">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            @if ($vacancy->trashed())
                                                <form action="{{ route('jobVacancy.restore', $vacancy->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg border border-emerald-100 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Reopen</button>
                                                </form>
                                            @else
                                                <a href="{{ route('jobVacancy.show', $vacancy) }}" class="rounded-lg border border-gray-200 px-2.5 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">View</a>
                                                <a href="{{ route('jobVacancy.edit', $vacancy) }}" class="rounded-lg border border-gray-200 px-2.5 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">Edit</a>
                                            @endif
                                            <a href="{{ route('jobApplication.index', ['jobVacancyId' => $vacancy->id]) }}" class="rounded-lg border border-indigo-100 bg-indigo-50 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100">Applications</a>
                                            @unless ($vacancy->trashed())
                                                <form action="{{ route('jobVacancy.destroy', $vacancy) }}" method="POST" onsubmit="return confirm('Move this vacancy to the trash?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-lg border border-rose-100 px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                                </form>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($jobVacancies->hasPages())
                    <div class="border-t border-gray-100 px-5 py-4 sm:px-6">{{ $jobVacancies->links() }}</div>
                @endif
            @endif
        </section>
    </div>
</x-app-layout>
