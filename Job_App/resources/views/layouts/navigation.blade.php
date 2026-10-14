<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/90">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex min-w-0 items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-3 text-slate-900 dark:text-white">
                <x-application-logo class="h-9 w-9 text-indigo-600 dark:text-indigo-400" />
                <span class="hidden text-sm font-bold tracking-tight sm:inline">Job tracker</span>
            </a>

            <div class="hidden h-16 items-center gap-7 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
                    {{ __('My applications') }}
                </x-nav-link>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2">
            <x-theme-toggle />

            <div class="hidden sm:block">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
                            <span class="max-w-36 truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.22 7.22a.75.75 0 0 1 1.06 0L10 10.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button
                type="button"
                @click="open = ! open"
                :aria-expanded="open"
                aria-controls="mobile-navigation"
                aria-label="{{ __('Toggle navigation') }}"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:hidden dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
            >
                <svg x-show="! open" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-cloak x-show="open" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-navigation" x-cloak x-show="open" x-transition class="border-t border-slate-200 px-4 pb-4 pt-2 sm:hidden dark:border-slate-800">
        <div class="space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
                {{ __('My applications') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
        </div>

        <div class="mt-4 border-t border-slate-200 pt-4 dark:border-slate-800">
            <p class="px-3 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</p>
            <p class="px-3 pt-1 text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</nav>
