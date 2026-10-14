<x-app-layout>
    <x-slot name="header">
        <nav aria-label="{{ __('Breadcrumb') }}" class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="font-medium text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                {{ __('Jobs') }}
            </a>
            <span aria-hidden="true" class="text-slate-300 dark:text-slate-600">/</span>
            <span class="font-semibold text-slate-900 dark:text-white">
                {{ __('Job details') }}
            </span>
        </nav>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
                    {{ session('status') }}
                </div>
            @endif

            <a href="{{ route('dashboard') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                </svg>
                {{ __('Back to jobs') }}
            </a>

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
                <div class="min-w-0">
                    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="border-b border-slate-100 p-6 sm:p-8 dark:border-slate-800">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                    {{ $job->type }}
                                </span>
                                @if ($job->category?->name)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $job->category->name }}
                                    </span>
                                @endif
                            </div>

                            <h1 class="mt-4 break-words text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                                {{ $job->title }}
                            </h1>

                            <p class="mt-2 text-lg font-medium text-slate-600 dark:text-slate-300">
                                {{ $job->company?->name ?? __('Company not listed') }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-500 dark:text-slate-400">
                                @if ($job->location !== $job->type)
                                    <span class="inline-flex items-center gap-2">
                                        <svg aria-hidden="true" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9.69 18.933 9.69 18.932l.01.005.01-.005.027-.016a16.12 16.12 0 0 0 .477-.3 24.5 24.5 0 0 0 3.256-2.56C15.451 14.13 17 11.876 17 9.5a7 7 0 1 0-14 0c0 2.376 1.549 4.63 3.53 6.556a24.5 24.5 0 0 0 3.256 2.56 16.12 16.12 0 0 0 .477.3l.027.016ZM10 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif

                                @if ($job->created_at)
                                    <span class="inline-flex items-center gap-2">
                                        <svg aria-hidden="true" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18h-10.5A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2ZM3.5 8v7.25c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V8h-13Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Posted') }} {{ $job->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('About this role') }}
                            </h2>
                            <div class="mt-4 whitespace-pre-line break-words text-base leading-7 text-slate-600 dark:text-slate-300">{{ $job->description }}</div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-6 lg:sticky lg:top-6">
                    <section class="rounded-2xl border border-indigo-100 bg-indigo-50 p-6 dark:border-indigo-900 dark:bg-indigo-950/40">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ __('Interested in this role?') }}
                        </h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            {{ __('Take the next step and apply for this opportunity.') }}
                        </p>
                        <a href="{{ route('job-vacancies.apply', $job->id) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                            {{ __('Apply now') }}
                        </a> 
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ __('Job overview') }}
                        </h2>

                        <dl class="mt-5 divide-y divide-slate-100 dark:divide-slate-800">
                            <div class="py-4 first:pt-0">
                                <dt class="text-sm text-slate-500 dark:text-slate-400">{{ __('Salary') }}</dt>
                                <dd class="mt-1 break-words font-semibold text-slate-900 dark:text-white">
                                    {{ $job->salary ?? __('Not specified') }}
                                </dd>
                            </div>

                            <div class="py-4">
                                <dt class="text-sm text-slate-500 dark:text-slate-400">{{ __('Location') }}</dt>
                                <dd class="mt-1 break-words font-semibold text-slate-900 dark:text-white">
                                    {{ $job->location }}
                                </dd>
                            </div>

                            <div class="py-4">
                                <dt class="text-sm text-slate-500 dark:text-slate-400">{{ __('Employment type') }}</dt>
                                <dd class="mt-1 break-words font-semibold text-slate-900 dark:text-white">
                                    {{ $job->type }}
                                </dd>
                            </div>

                            <div class="py-4 last:pb-0">
                                <dt class="text-sm text-slate-500 dark:text-slate-400">{{ __('Company') }}</dt>
                                <dd class="mt-1 break-words font-semibold text-slate-900 dark:text-white">
                                    {{ $job->company?->name ?? __('Not specified') }}
                                </dd>
                            </div>
                        </dl>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
