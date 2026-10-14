<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">{{ now()->format('l, F j, Y') }}</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                    {{ __('Welcome, :name', ['name' => auth()->user()->name]) }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Explore opportunities and find your next career move.') }}</p>
            </div>
            <a href="{{ route('jobVacancy.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ __('Browse all jobs') }}
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a1 1 0 0 1 1-1h9.586l-3.293-3.293a1 1 0 1 1 1.414-1.414l5 5a1 1 0 0 1 0 1.414l-5 5a1 1 0 1 1-1.414-1.414L13.586 11H4a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-7xl space-y-8">
            <section class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-indigo-950 to-indigo-700 px-6 py-8 shadow-lg sm:px-10 sm:py-12">
                <div class="absolute -right-16 -top-24 -z-10 h-80 w-80 rounded-full bg-indigo-300/20 blur-3xl"></div>
                <div class="absolute -bottom-36 left-1/3 -z-10 h-72 w-72 rounded-full bg-cyan-300/10 blur-3xl"></div>
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        {{ __('Your next opportunity starts here') }}
                    </span>
                    <h2 class="mt-5 text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('Find work that moves you forward.') }}</h2>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-indigo-100/85 sm:text-base">
                        {{ __('Discover new openings from companies looking for people like you. Your next great role could be one application away.') }}
                    </p>
                    <a href="{{ route('jobVacancy.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-indigo-800 shadow-sm transition hover:bg-indigo-50">
                        {{ __('Explore job openings') }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="mt-8 inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/15 sm:absolute sm:bottom-8 sm:right-8 sm:mt-0">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M3 3a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3Zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-5Zm9-9a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V3Zm0 8a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1v-6Z" />
                        </svg>
                        {{ __('Open admin dashboard') }}
                    </a>
                @endif
            </section>

            <section>
                <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-indigo-600">{{ __('Fresh opportunities') }}</p>
                        <h2 class="mt-1 text-xl font-bold tracking-tight text-gray-900">{{ __('Latest job openings') }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Recently posted roles from our partner companies.') }}</p>
                    </div>
                    <a href="{{ route('jobVacancy.index') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-700">
                        {{ __('View all jobs') }} <span aria-hidden="true">→</span>
                    </a>
                </div>

                @forelse ($jobVacancies as $vacancy)
                    @if ($loop->first)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @endif
                    <a href="{{ route('jobVacancy.show', $vacancy) }}" class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-100 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-base font-bold text-indigo-700">
                                {{ strtoupper(substr($vacancy->company->name ?? 'J', 0, 1)) }}
                            </span>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">{{ $vacancy->type }}</span>
                        </div>
                        <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $vacancy->company->name ?? __('Company') }}</p>
                        <h3 class="mt-1 line-clamp-2 text-lg font-bold text-gray-900 transition group-hover:text-indigo-700">{{ $vacancy->title }}</h3>
                        <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-sm text-gray-500">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18s7-5.33 7-11A7 7 0 1 0 3 7c0 5.67 7 11 7 11Zm0-8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg>
                                {{ $vacancy->location }}
                            </span>
                            @if ($vacancy->category)
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 0 1 1-1h6a1 1 0 0 1 .7.3l6 6a2 2 0 0 1 0 2.8l-5.6 5.6a2 2 0 0 1-2.8 0l-6-6A1 1 0 0 1 2 10V4a1 1 0 0 1 1-1Zm3 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $vacancy->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="mt-auto flex items-center justify-between gap-3 border-t border-gray-100 pt-4 mt-5">
                            <div>
                                @if ($vacancy->salary)
                                    <p class="text-sm font-bold text-gray-900">{{ number_format((float) $vacancy->salary) }}</p>
                                    <p class="text-xs text-gray-500">{{ __('Salary') }}</p>
                                @else
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Salary not specified') }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400">{{ $vacancy->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                    @if ($loop->last)
                        </div>
                    @endif
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1ZM4 8h12v8H4V8Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <h3 class="mt-4 text-sm font-bold text-gray-900">{{ __('No job openings yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Check back soon for new opportunities.') }}</p>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
