@props(['indexRoute', 'activeLabel', 'archivedLabel'])

@php
    $showTrashed = request()->query('trashed') === 'only';
@endphp

<div class="flex flex-col gap-4 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
    <nav class="flex space-x-1 rounded-lg bg-gray-100 p-1" aria-label="{{ __('Record status') }}">
        <a href="{{ route($indexRoute) }}"
            @class([
                'rounded-md px-4 py-2 text-xs font-semibold transition-all',
                'bg-white text-gray-900 shadow-sm' => ! $showTrashed,
                'text-gray-600 hover:text-gray-900' => $showTrashed,
            ])>
            {{ __('Active') }}
        </a>
        <a href="{{ route($indexRoute, ['trashed' => 'only']) }}"
            @class([
                'rounded-md px-4 py-2 text-xs font-semibold transition-all',
                'bg-white text-red-600 shadow-sm' => $showTrashed,
                'text-gray-600 hover:text-red-600' => ! $showTrashed,
            ])>
            {{ __('Trash Bin') }}
        </a>
    </nav>

    <div class="flex items-center gap-2 text-xs text-gray-500">
        <span @class([
            'h-2 w-2 rounded-full',
            'bg-amber-400' => $showTrashed,
            'bg-emerald-400' => ! $showTrashed,
        ])></span>
        {{ __('Showing') }} {{ $showTrashed ? $archivedLabel : $activeLabel }}
    </div>
</div>
