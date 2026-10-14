<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('components.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
    <header class="motion-enter relative z-10 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/90">
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8" aria-label="{{ __('Main navigation') }}">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-slate-900 dark:text-white">
                <x-application-logo class="h-9 w-9 text-indigo-600 dark:text-indigo-400" />
                <span class="text-sm font-bold tracking-tight sm:text-base">Job tracker</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                <x-theme-toggle />
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                        {{ __('Open dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 sm:inline-flex dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                        {{ __('Get started') }}
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="relative isolate overflow-hidden">
            <div class="absolute inset-x-0 top-0 -z-10 h-[34rem] bg-gradient-to-b from-indigo-50 via-white to-white dark:from-indigo-950/50 dark:via-slate-950 dark:to-slate-950" aria-hidden="true"></div>
            <div class="motion-float absolute -right-24 top-20 -z-10 h-80 w-80 rounded-full bg-indigo-300/20 blur-3xl dark:bg-indigo-500/10" aria-hidden="true"></div>
            <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 pb-20 pt-16 sm:px-6 sm:pt-24 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-28 lg:pt-28">
                <div class="motion-enter max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white/80 px-3 py-1.5 text-xs font-semibold tracking-wide text-indigo-700 shadow-sm dark:border-indigo-400/20 dark:bg-indigo-400/10 dark:text-indigo-200">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        {{ __('A clearer path to your next role') }}
                    </span>
                    <h1 class="mt-7 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl dark:text-white">
                        {{ __('Your job search,') }}
                        <span class="bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent dark:from-indigo-300 dark:to-violet-300">{{ __('without the chaos.') }}</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                        {{ __('Keep your applications and next steps together. Spend less time searching through notes and more time moving forward.') }}
                    </p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                                {{ __('Go to your dashboard') }}
                                <span aria-hidden="true">→</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950">
                                {{ __('Start organizing') }}
                                <span aria-hidden="true">→</span>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800 dark:focus:ring-offset-slate-950">
                                {{ __('I already have an account') }}
                            </a>
                        @endauth
                    </div>
                    <p class="mt-5 text-xs text-slate-500 dark:text-slate-400">{{ __('A calm, focused space for every step of your search.') }}</p>
                </div>

                <div class="motion-enter motion-delay-200 relative mx-auto w-full max-w-lg">
                    <div class="motion-float absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-indigo-200/60 via-sky-100/50 to-violet-200/50 blur-2xl dark:from-indigo-500/15 dark:via-sky-500/10 dark:to-violet-500/15" aria-hidden="true"></div>
                    <div class="relative rounded-3xl border border-slate-200/80 bg-white/90 p-5 shadow-2xl shadow-indigo-950/10 backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-indigo-950/15 sm:p-7 dark:border-slate-700/80 dark:bg-slate-900/90 dark:shadow-black/30 dark:hover:shadow-black/40">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-indigo-600 dark:text-indigo-300">{{ __('Your workspace') }}</p>
                                <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ __('A little more clarity') }}</h2>
                            </div>
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-400/15 dark:text-indigo-300">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="15" rx="3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1M3 11h18m-12 0v2m6-2v2" />
                                </svg>
                            </span>
                        </div>

                        <div class="mt-7 rounded-2xl border border-dashed border-slate-300 bg-slate-50/80 px-5 py-8 text-center transition-colors duration-300 hover:border-indigo-300 dark:border-slate-700 dark:bg-slate-950/60 dark:hover:border-indigo-500/50">
                            <span class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-indigo-600 shadow-sm dark:bg-slate-800 dark:text-indigo-300">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                            </span>
                            <p class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">{{ __('Start with one opportunity') }}</p>
                            <p class="mx-auto mt-2 max-w-xs text-sm leading-6 text-slate-500 dark:text-slate-400">{{ __('Add the details that matter, then keep your next steps close at hand.') }}</p>
                            <div class="mx-auto mt-6 flex max-w-xs items-center gap-2">
                                <span class="h-1.5 flex-1 rounded-full bg-indigo-500"></span>
                                <span class="h-1.5 flex-1 rounded-full bg-sky-400"></span>
                                <span class="h-1.5 flex-1 rounded-full bg-slate-200 dark:bg-slate-700"></span>
                            </div>
                            <div class="mx-auto mt-2 flex max-w-xs justify-between text-[10px] font-medium uppercase tracking-wider text-slate-400">
                                <span>{{ __('Discover') }}</span>
                                <span>{{ __('Connect') }}</span>
                                <span>{{ __('Grow') }}</span>
                            </div>
                        </div>

                        <div class="mt-5 flex items-center gap-3 rounded-xl bg-emerald-50 px-4 py-3 dark:bg-emerald-400/10">
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-emerald-600 dark:bg-emerald-400/15 dark:text-emerald-300">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.07 7.13a1 1 0 0 1-1.42.006l-3.93-3.87a1 1 0 1 1 1.404-1.426l3.22 3.17 6.37-6.418a1 1 0 0 1 1.42-.006Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <p class="text-xs font-medium leading-5 text-emerald-800 dark:text-emerald-200">{{ __('A thoughtful place to keep your plans, notes, and follow-ups together.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="motion-enter motion-delay-300 border-t border-slate-200 dark:border-slate-800">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8 dark:text-slate-400">
            <p>{{ __('A more intentional job search starts here.') }}</p>
            <p>{{ config('app.name', 'Job tracker') }}</p>
        </div>
    </footer>
</body>

</html>
