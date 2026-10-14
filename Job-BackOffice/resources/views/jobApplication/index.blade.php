<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Job Applications') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Manage and review all applicant submissions.
                </p>
            </div>
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

            <x-trash-filter index-route="jobApplication.index" active-label="active Job Applications" archived-label="archived applications" />

            <!-- Main Data Table Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/75 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Applicant</th>
                                <th scope="col" class="px-6 py-4">Job Vacancy</th>
                                <th scope="col" class="px-6 py-4">AI Score</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($jobApplications as $application)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    
                                    <!-- Applicant Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                                {{ strtoupper(substr($application->user->name ?? 'A', 0, 2)) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('jobApplication.show', $application) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                                    {{ $application->user->name ?? 'N/A' }}
                                                </a>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    {{ $application->user->email ?? 'No email provided' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Job Vacancy Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs">
                                            <div class="text-gray-900 font-medium truncate max-w-xs">
                                                {{ $application->jobVacancy->title ?? 'N/A' }}
                                            </div>
                                            <div class="text-gray-400 mt-0.5 flex items-center gap-1.5">
                                                <span>{{ $application->jobVacancy->company->name ?? 'N/A' }}</span>
                                                @if(isset($application->jobVacancy->location))
                                                    <span>•</span>
                                                    <span>{{ $application->jobVacancy->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- AI Score Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($application->aiGeneratedScore !== null)
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold
                                                {{ $application->aiGeneratedScore >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($application->aiGeneratedScore >= 50 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                <span>{{ number_format($application->aiGeneratedScore, 1) }}%</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Not Evaluated</span>
                                        @endif
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($application->trashed())
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Deleted {{ $application->deleted_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium capitalize
                                                {{ match(strtolower($application->status ?? 'pending')) {
                                                    'accepted', 'hired', 'shortlisted' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                                    'rejected' => 'bg-red-50 text-red-700 border border-red-200',
                                                    'interviewing', 'reviewed' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                                    default => 'bg-amber-50 text-amber-700 border border-amber-200',
                                                } }}">
                                                <span class="w-1.5 h-1.5 rounded-full 
                                                    {{ match(strtolower($application->status ?? 'pending')) {
                                                        'accepted', 'hired', 'shortlisted' => 'bg-emerald-500',
                                                        'rejected' => 'bg-red-500',
                                                        'interviewing', 'reviewed' => 'bg-blue-500',
                                                        default => 'bg-amber-500',
                                                    } }}"></span>
                                                {{ $application->status ?? 'Pending' }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            @if ($application->trashed())
                                                
                                                <!-- Restore Action -->
                                                <form action="{{ route('jobApplication.restore', $application->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-md text-xs font-semibold transition-colors">
                                                        Restore
                                                    </button>
                                                </form>

                                                <!-- Permanent Delete Action -->
                                                <form action="{{ route('jobApplication.force-delete', $application->id) }}" method="POST" class="inline" onsubmit="return confirm('This action cannot be undone. Permanently delete?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-md text-xs font-semibold transition-colors">
                                                        Delete Forever
                                                    </button>
                                                </form>

                                            @else
                                                
                                                <!-- View Action -->
                                                <a href="{{ route('jobApplication.show', $application) }}" 
                                                   class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all" 
                                                   title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                <!-- Edit Action -->
                                                <a href="{{ route('jobApplication.edit', $application) }}" 
                                                   class="p-1.5 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-all" 
                                                   title="Edit Application">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>

                                                <!-- Soft Delete Action -->
                                                <form action="{{ route('jobApplication.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('Move this job application to trash?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-1.5 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-all" 
                                                            title="Trash Application">
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
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-900 font-semibold text-sm">No job applications found</p>
                                            <p class="text-xs text-gray-500 mt-1">There are no application records matching your current filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer / Pagination -->
                @if($jobApplications->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                        {{ $jobApplications->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>