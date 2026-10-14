<nav class="z-20 w-full shrink-0 border-b border-gray-200 bg-white lg:sticky lg:top-0 lg:flex lg:h-screen lg:w-64 lg:flex-col lg:border-b-0 lg:border-r" aria-label="{{ __('Main navigation') }}">
    <div class="flex h-16 shrink-0 items-center border-b border-gray-100 px-5 lg:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm shadow-indigo-200">
                <x-application-logo class="h-5 w-auto fill-current" />
            </span>
            <span class="text-base font-bold tracking-tight text-gray-900">{{ __('Shaghalni') }}</span>
        </a>
    </div>

    <ul class="flex flex-nowrap items-center gap-1 overflow-x-auto px-3 py-2 lg:flex-1 lg:flex-col lg:items-stretch lg:gap-1 lg:overflow-y-auto lg:overflow-x-hidden lg:px-4 lg:py-6">
        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10.7 2.3a1 1 0 0 0-1.4 0l-7 7a1 1 0 0 0 1.4 1.4l.3-.3V17a1 1 0 0 0 1 1h4v-5h2v5h4a1 1 0 0 0 1-1v-6.6l.3.3a1 1 0 0 0 1.4-1.4l-7-7Z" />
            </svg>
            {{ __('Home') }}
        </x-nav-link>
        @if (auth()->user()->role === 'admin')
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.7 2.3a1 1 0 0 0-1.4 0l-7 7a1 1 0 0 0 1.4 1.4l.3-.3V17a1 1 0 0 0 1 1h4v-5h2v5h4a1 1 0 0 0 1-1v-6.6l.3.3a1 1 0 0 0 1.4-1.4l-7-7Z" />
                </svg>
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 18V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v9h-6v-3H9v3H3Zm2-2h2v-2h2v2h2V5H5v11Zm2-9h2v2H7V7Zm0 4h2v2H7v-2Zm6 0h2v2h-2v-2Z" clip-rule="evenodd" />
            </svg>
            {{ __('Companies') }}
            </x-nav-link>
            <x-nav-link :href="route('jobApplication.index')" :active="request()->routeIs('jobApplication.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm8 1.5V7h2.5L12 4.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H6Z" clip-rule="evenodd" />
            </svg>
            {{ __('Applications') }}
            </x-nav-link>
            <x-nav-link :href="route('jobCategory.index')" :active="request()->routeIs('jobCategory.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 3a1 1 0 0 1 1-1h6a1 1 0 0 1 .7.3l6 6a2 2 0 0 1 0 2.8l-5.6 5.6a2 2 0 0 1-2.8 0l-6-6A1 1 0 0 1 2 10V4a1 1 0 0 1 1-1Zm3 2a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" clip-rule="evenodd" />
            </svg>
            {{ __('Categories') }}
            </x-nav-link>
        @elseif (auth()->user()->role === 'company-owner')
            <x-nav-link :href="route('company-owner.dashboard')" :active="request()->routeIs('company-owner.dashboard')">
                <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3 3h6v6H3V3Zm8 0h6v4h-6V3ZM3 11h6v6H3v-6Zm8-2h6v8h-6V9Z" />
                </svg>
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('company.index')" :active="request()->routeIs('company.*')">
                <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 18V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v9h-6v-3H9v3H3Zm2-2h2v-2h2v2h2V5H5v11Zm2-9h2v2H7V7Zm0 4h2v2H7v-2Zm6 0h2v2h-2v-2Z" clip-rule="evenodd" />
                </svg>
                {{ __('My Company') }}
            </x-nav-link>
            @if (auth()->user()->role !== 'company-owner')
                <x-nav-link :href="route('jobVacancy.index')" :active="request()->routeIs('jobVacancy.*')">
                    <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1ZM4 8h12v8H4V8Z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Job Vacancies') }}
                </x-nav-link>
            @endif
            <x-nav-link :href="route('jobApplication.index')" :active="request()->routeIs('jobApplication.*')">
                <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm8 1.5V7h2.5L12 4.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H6Z" clip-rule="evenodd" />
                </svg>
                {{ __('Applications') }}
            </x-nav-link>
        @endif
        <x-nav-link :href="route('jobVacancy.index')" :active="request()->routeIs('jobVacancy.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6 2a1 1 0 0 0-1 1v1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 1 0-2 0v1H7V3a1 1 0 0 0-1-1ZM4 8h12v8H4V8Z" clip-rule="evenodd" />
            </svg>
            {{ __('Job Vacancies') }}
        </x-nav-link>
        @if (auth()->user()->role === 'admin')
        <x-nav-link :href="route('resume.index')" :active="request()->routeIs('resume.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm7 1.5V7h3.5L11 3.5ZM5 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H6Z" clip-rule="evenodd" />
            </svg>
            {{ __('Resumes') }}
        </x-nav-link>
        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM3 18a7 7 0 1 1 14 0H3Z" />
            </svg>
            {{ __('Users') }}
        </x-nav-link>
        @endif

        <li class="hidden pt-4 lg:block"><hr class="border-gray-200"></li>

        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
            <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16Zm0 3a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 9.2a6 6 0 0 1 10 0 5.9 5.9 0 0 1-10 0Z" clip-rule="evenodd" />
            </svg>
            {{ __('Profile') }}
        </x-nav-link>
        <li class="shrink-0 lg:mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center rounded-md px-4 py-2 text-left text-sm font-medium text-rose-600 transition hover:bg-rose-50">
                    <svg class="mr-3 h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3a1 1 0 1 1-2 0V4H5v12h6v-3a1 1 0 1 1 2 0v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4Zm11.3 3.3a1 1 0 0 1 1.4 0l3 3a1 1 0 0 1 0 1.4l-3 3a1 1 0 0 1-1.4-1.4l1.3-1.3H8a1 1 0 1 1 0-2h7.6l-1.3-1.3a1 1 0 0 1 0-1.4Z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </li>
    </ul>
</nav>
