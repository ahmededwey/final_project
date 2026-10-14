<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Job Application Details') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Viewing candidate application, AI analysis, and resume details.
                </p>
            </div>
            <a href="{{ route('jobApplication.index') }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Job Applications
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

            <!-- Top Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <!-- User Initials Avatar -->
                        <div class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-lg shrink-0 border border-indigo-200">
                            {{ strtoupper(substr($jobApplication->user->name ?? 'U', 0, 2)) }}
                        </div>

                        <div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <h1 class="text-xl font-bold text-gray-900">{{ $jobApplication->user->name ?? 'Unknown Applicant' }}</h1>
                                
                                @php
                                    $statusClasses = match(strtolower($jobApplication->status ?? 'pending')) {
                                        'accepted', 'hired', 'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'rejected', 'declined'           => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'shortlisted', 'interviewing'   => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        default                          => 'bg-amber-50 text-amber-700 border-amber-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border capitalize {{ $statusClasses }}">
                                    {{ $jobApplication->status ?? 'Pending' }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                <span>{{ $jobApplication->user->email ?? 'No email provided' }}</span>
                                <span>•</span>
                                <span class="font-mono text-gray-400">App ID: {{ $jobApplication->id }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3 shrink-0">
                        @if($jobApplication->resume && $jobApplication->resume->fileUrl)
                            <a href="{{ $jobApplication->resume->fileUrl }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-2 px-3.5 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200/60 text-xs font-semibold rounded-lg hover:bg-indigo-100 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>View Original Resume</span>
                            </a>
                        @endif

                        <form action="{{ route('jobApplication.destroy', $jobApplication) }}" method="POST" onsubmit="return confirm('Delete this job application?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-3.5 py-2 bg-rose-50 text-rose-700 border border-rose-200/60 text-xs font-semibold rounded-lg hover:bg-rose-100 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Fast Metadata Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Applied For Position</span>
                        @if($jobApplication->jobVacancy)
                            <a href="{{ route('jobVacancy.show', $jobApplication->jobVacancy) }}" class="font-semibold text-gray-800 hover:text-indigo-600 transition-colors">
                                {{ $jobApplication->jobVacancy->title }}
                            </a>
                        @else
                            <span class="font-semibold text-gray-800">N/A</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Company</span>
                        <span class="font-semibold text-gray-800">{{ $jobApplication->jobVacancy->company->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Application Date</span>
                        <span class="font-semibold text-gray-800">
                            {{ $jobApplication->created_at ? $jobApplication->created_at->format('M d, Y - h:i A') : 'N/A' }}
                            <span class="text-xs text-gray-400 font-normal">({{ $jobApplication->created_at ? $jobApplication->created_at->diffForHumans() : '' }})</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Grid Layout: AI Score & Resume Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column (2 Cols): AI Feedback & Resume Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- AI Analysis Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                AI Analysis & Match Score
                            </h3>
                            
                            @php
                                $score = (float) $jobApplication->aiGeneratedScore;
                                $badgeClass = match(true) {
                                    $score >= 80 => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    $score >= 50 => 'bg-amber-50 text-amber-700 border-amber-200',
                                    default => 'bg-rose-50 text-rose-700 border-rose-200',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                {{ number_format($score, 1) }}% Match Score
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1">
                            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full {{ $score >= 80 ? 'bg-emerald-500' : ($score >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}" 
                                     style="width: {{ min($score, 100) }}%"></div>
                            </div>
                        </div>

                        <!-- Feedback Box -->
                        <div>
                            <span class="text-xs text-gray-400 font-medium block mb-1.5">AI Feedback & Insights</span>
                            @if($jobApplication->aiGeneratedFeedback)
                                <div class="p-4 bg-gray-50/80 rounded-lg border border-gray-100 text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $jobApplication->aiGeneratedFeedback }}
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg border border-dashed border-gray-200 text-xs text-gray-400 italic text-center">
                                    No AI feedback has been generated for this application yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Resume Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Parsed Resume Information
                            </h3>
                            @if($jobApplication->resume)
                                <span class="text-xs font-mono text-gray-400">
                                    File: {{ $jobApplication->resume->fileName ?? 'Attached' }}
                                </span>
                            @endif
                        </div>

                        @if($jobApplication->resume)
                            
                            <!-- Summary -->
                            @if($jobApplication->resume->summary)
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block mb-1">Professional Summary</span>
                                    <p class="text-xs text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 p-3.5 rounded-lg border border-gray-100">
                                        {{ $jobApplication->resume->summary }}
                                    </p>
                                </div>
                            @endif

                            <!-- Skills -->
                            @if($jobApplication->resume->skills)
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block mb-2">Skills & Competencies</span>
                                    <div class="p-3.5 bg-gray-50 rounded-lg border border-gray-100 text-xs text-gray-700 leading-relaxed">
                                        {{ $jobApplication->resume->skills }}
                                    </div>
                                </div>
                            @endif

                            <!-- Experience -->
                            @if($jobApplication->resume->experience)
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block mb-1">Work Experience</span>
                                    <div class="p-3.5 bg-gray-50 rounded-lg border border-gray-100 text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                                        {{ $jobApplication->resume->experience }}
                                    </div>
                                </div>
                            @endif

                            <!-- Education -->
                            @if($jobApplication->resume->education)
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block mb-1">Education</span>
                                    <div class="p-3.5 bg-gray-50 rounded-lg border border-gray-100 text-xs text-gray-700 leading-relaxed whitespace-pre-line">
                                        {{ $jobApplication->resume->education }}
                                    </div>
                                </div>
                            @endif

                            <!-- Contact Details -->
                            @if($jobApplication->resume->contactDetails)
                                <div>
                                    <span class="text-xs text-gray-400 font-medium block mb-1">Parsed Contact Information</span>
                                    <div class="p-3.5 bg-gray-50 rounded-lg border border-gray-100 text-xs text-gray-700">
                                        {{ $jobApplication->resume->contactDetails }}
                                    </div>
                                </div>
                            @endif

                        @else
                            <div class="py-8 text-center text-gray-400 text-xs italic">
                                No resume record associated with this application.
                            </div>
                        @endif

                    </div>

                </div>

                <!-- Right Column (1 Col): Target Job Vacancy Side Card -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4 sticky top-6">
                        <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
                            Target Job Vacancy
                        </h3>

                        @if($jobApplication->jobVacancy)
                            <div class="space-y-3 text-xs">
                                <div>
                                    <span class="text-gray-400 block font-medium">Job Title</span>
                                    <span class="font-bold text-gray-900 text-sm">{{ $jobApplication->jobVacancy->title }}</span>
                                </div>

                                <div>
                                    <span class="text-gray-400 block font-medium">Company</span>
                                    <span class="font-semibold text-gray-800">{{ $jobApplication->jobVacancy->company->name ?? 'N/A' }}</span>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-100">
                                    <div>
                                        <span class="text-gray-400 block font-medium">Employment Type</span>
                                        <span class="font-semibold text-gray-800">{{ $jobApplication->jobVacancy->type ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 block font-medium">Category</span>
                                        <span class="font-semibold text-gray-800">{{ $jobApplication->jobVacancy->category->name ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-gray-100">
                                    <span class="text-gray-400 block font-medium">Offered Salary</span>
                                    <span class="font-semibold text-emerald-600 text-sm">
                                        {{ $jobApplication->jobVacancy->salary ? '$' . number_format($jobApplication->jobVacancy->salary, 2) : 'Not specified' }}
                                    </span>
                                </div>

                                <div class="pt-2 border-t border-gray-100">
                                    <span class="text-gray-400 block font-medium">Location</span>
                                    <span class="font-semibold text-gray-800">{{ $jobApplication->jobVacancy->location ?? 'N/A' }}</span>
                                </div>

                                <div class="pt-4">
                                    <a href="{{ route('jobVacancy.show', $jobApplication->jobVacancy) }}" 
                                       class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold rounded-lg border border-gray-200 transition-colors">
                                        <span>View Full Vacancy Page</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Job Vacancy details are unavailable.</p>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>