<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Companies') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Manage registered companies, track vacancy counts, and organize deleted records.
                </p>
            </div>
            <a href="{{ route('company.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-400/80 font-medium text-xs uppercase tracking-wider rounded-lg hover:bg-blue-100 hover:text-blue-800 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Company
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Toast Notification -->
            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 10 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-emerald-800">{{ session('success') }}</span>
                </div>
            @endif

            <x-trash-filter index-route="company.index" active-label="active companies" archived-label="archived records" />

            <!-- Main Data Table Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/75 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Company & Industry</th>
                                <th scope="col" class="px-6 py-4">Location & Owner</th>
                                <th scope="col" class="px-6 py-4">Status & Details</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($companies as $company)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    
                                    <!-- Company Name & Industry Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                           <div class="w-20 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                                  {{ strtoupper(substr($company->name, 0, 2)) }}
                                            </div>
                                            <div>
                                              <a  href="{{ route('company.show', $company) }}" > <div class="font-semibold text-blue">{{ $company->name }}</div></a>
                                                <div class="text-xs text-gray-500">{{ $company->industry }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Address & Owner Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs">
                                            <div class="text-gray-900 font-medium truncate max-w-xs">{{ $company->address }}</div>
                                            <div class="text-gray-400">Owner: {{ $company->owner->name ?? 'N/A' }}</div>
                                        </div>
                                    </td>

                                    <!-- Status Badge Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($company->trashed())
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Deleted {{ $company->deleted_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                {{ $company->job_vacancies_count ?? 0 }} Active Vacancies
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            @if ($company->trashed())
                                                
                                                <!-- Restore Action -->
                                                <form action="{{ route('company.restore', $company->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-md text-xs font-semibold transition-colors">
                                                        Restore
                                                    </button>
                                                </form>

                                                <!-- Permanent Delete Action -->
                                                <form action="{{ route('company.force-delete', $company->id) }}" method="POST" class="inline" onsubmit="return confirm('This action cannot be undone. Permanently delete?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-md text-xs font-semibold transition-colors">
                                                        Delete Forever
                                                    </button>
                                                </form>
                                                
                                            @else
                                                
                                                <!-- View Action -->
                                                <a href="{{ route('company.show', $company) }}" 
                                                   class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all" 
                                                   title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                <!-- Edit Action -->
                                                <a href="{{ route('company.edit', $company) }}" 
                                                   class="p-1.5 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-all" 
                                                   title="Edit Company">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>

                                                <!-- Soft Delete Action -->
                                                <form action="{{ route('company.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('Move this company to trash?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-1.5 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all" 
                                                            title="Trash Company">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>

                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-900 font-semibold text-sm">No companies found</p>
                                            <p class="text-xs text-gray-500 mt-1">There are no records matching your current filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer / Pagination -->
                @if($companies->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                        {{ $companies->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>