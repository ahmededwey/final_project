<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Job Vacancy Details') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Viewing details and incoming candidate applications.
                </p>
            </div>
            <a href="{{ route('jobVacancy.index') }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Job Vacancies
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Success Message -->
            @if (session('success'))
                <div class="flex items-center gap-3 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 10 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-emerald-800">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Vacancy Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-xl font-bold text-gray-900">{{ $jobVacancy->title }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 capitalize">
                                {{ $jobVacancy->type }}
                            </span>
                        </div>
                        <p class="text-xs font-mono text-gray-400 mt-1">ID: {{ $jobVacancy->id }}</p>
                    </div>

                    <a href="{{ route('jobVacancy.edit', $jobVacancy) }}" 
                       class="inline-flex items-center gap-2 px-3.5 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200/60 text-xs font-semibold rounded-lg hover:bg-indigo-100 transition-all shadow-sm shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Edit Vacancy</span>
                    </a>
                </div>

                <!-- Metadata Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-4 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Company</span>
                        <span class="font-semibold text-gray-800">{{ $jobVacancy->company->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Salary</span>
                        <span class="font-semibold text-emerald-600">
                            {{ $jobVacancy->salary ? '$' . number_format($jobVacancy->salary, 2) : 'Not specified' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Location / Category</span>
                        <span class="font-semibold text-gray-800">
                            {{ $jobVacancy->location ?? 'N/A' }} 
                            <span class="text-gray-400 font-normal">({{ $jobVacancy->category->name ?? 'Uncategorized' }})</span>
                        </span>
                    </div>
                </div>

                @if($jobVacancy->description)
                    <div class="pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400 font-medium block mb-1">Job Description</span>
                        <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-line">{{ $jobVacancy->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Applications Section Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Job Applications</h3>
                    <p class="text-xs text-gray-500">Candidates who applied for this position.</p>
                </div>
                <span class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold text-xs rounded-full">
                    {{ $jobVacancy->jobApplications->count() }} Total
                </span>
            </div>

            <!-- Job Applications Table Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/75 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">Applicant / User</th>
                                <th scope="col" class="px-6 py-4">AI Score & Feedback</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($jobVacancy->jobApplications as $jobApplication)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    
                                    <!-- User Name & Details Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0 uppercase border border-indigo-100">
                                                {{ strtoupper(substr($jobApplication->user->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('jobApplication.show', $jobApplication) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                                    {{ $jobApplication->user->name ?? 'Unknown Candidate' }}
                                                </a>
                                                <div class="text-xs text-gray-400 flex items-center gap-1.5 mt-0.5">
                                                    <span>{{ $jobApplication->user->email ?? 'No email' }}</span>
                                                    @if($jobApplication->resume)
                                                        <span>•</span>
                                                        <span class="text-indigo-600 font-medium">Resume Attached</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- AI Score & Feedback Column -->
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <div class="flex items-center gap-2 mb-1">
                                                @php
                                                    $score = (float) $jobApplication->aiGeneratedScore;
                                                    $badgeClass = match(true) {
                                                        $score >= 80 => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                        $score >= 50 => 'bg-amber-50 text-amber-700 border-amber-200',
                                                        default => 'bg-rose-50 text-rose-700 border-rose-200',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border {{ $badgeClass }}">
                                                    {{ number_format($score, 1) }}%
                                                </span>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="h-1.5 rounded-full {{ $score >= 80 ? 'bg-emerald-500' : ($score >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ min($score, 100) }}%"></div>
                                                </div>
                                            </div>
                                            @if($jobApplication->aiGeneratedFeedback)
                                                <p class="text-xs text-gray-500 truncate" title="{{ $jobApplication->aiGeneratedFeedback }}">
                                                    {{ $jobApplication->aiGeneratedFeedback }}
                                                </p>
                                            @else
                                                <span class="text-xs text-gray-400 italic">No AI feedback generated</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Status Column -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                     

                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold capitalize border border-gray-200 bg-gray-50 text-gray-700 w-max">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                {{ $jobApplication->status ?? 'Pending' }}
                                            </span>
                                            <span class="text-[10px] text-gray-400">
                                                Applied {{ $jobApplication->created_at ? $jobApplication->created_at->diffForHumans() : 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Action Buttons Column -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            
                                            <!-- View Application Details -->
                                            <a href="{{ route('jobApplication.show', $jobApplication) }}" 
                                               class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all" 
                                               title="View Application">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            <!-- Soft Delete Application -->
                                            <form action="{{ route('jobApplication.destroy', $jobApplication) }}" method="POST" class="inline" onsubmit="return confirm('Delete this application?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-1.5 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all" 
                                                        title="Delete Application">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-900 font-semibold text-sm">No applications yet</p>
                                            <p class="text-xs text-gray-500 mt-1">There are currently no job applications submitted for this vacancy.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>