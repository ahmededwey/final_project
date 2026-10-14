<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('components.theme-init')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
    <main class="flex min-h-screen flex-col items-center px-4 py-6 sm:justify-center sm:px-6">
        <div class="mb-8 flex w-full max-w-md items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-sm font-semibold text-slate-700 transition hover:text-indigo-600 dark:text-slate-200 dark:hover:text-indigo-300">
                <x-application-logo class="h-9 w-9 text-indigo-600 dark:text-indigo-400" />
                <span>Job tracker</span>
            </a>
            <x-theme-toggle />
        </div>

        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 sm:p-8 dark:border-slate-800 dark:bg-slate-900 dark:shadow-black/20">
            {{ $slot }}
        </div>
    </main>
</body>

</html>