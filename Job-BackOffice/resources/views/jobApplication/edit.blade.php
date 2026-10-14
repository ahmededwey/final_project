<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('jobApplication.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
               title="Back to Job Applications">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">
                {{ __('Edit Job Application Status') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Card Wrapper -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden w-full">
                
                <form action="{{ route('jobApplication.update', $jobApplication) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Input Body -->
                    <div class="p-6 space-y-5">
                        
                        <!-- Read-Only Information Summary Section -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-gray-200">
                            <!-- Applicant Name -->
                            <div>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Applicant</span>
                                <p class="text-sm font-medium text-gray-900 bg-gray-50 px-3.5 py-2.5 rounded-lg border border-gray-200">
                                    {{ $jobApplication->user->name ?? 'N/A' }}
                                </p>
                            </div>

                            <!-- Job Vacancy Title -->
                            <div>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Job Vacancy</span>
                                <p class="text-sm font-medium text-gray-900 bg-gray-50 px-3.5 py-2.5 rounded-lg border border-gray-200">
                                    {{ $jobApplication->jobVacancy->title ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Read-Only AI Details Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-gray-200">
                            <!-- AI Generated Score -->
                            <div>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">AI Match Score</span>
                                <p class="text-sm font-medium text-gray-900 bg-gray-50 px-3.5 py-2.5 rounded-lg border border-gray-200">
                                    {{ $jobApplication->aiGeneratedScore ? number_format($jobApplication->aiGeneratedScore, 2) . '%' : 'N/A' }}
                                </p>
                            </div>

                            <!-- Resume Link/Info -->
                            <div>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Resume ID</span>
                                <p class="text-sm font-medium text-gray-900 bg-gray-50 px-3.5 py-2.5 rounded-lg border border-gray-200 truncate">
                                    {{ $jobApplication->resumeId ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Read-Only AI Generated Feedback -->
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">AI Generated Feedback</span>
                            <div class="text-sm text-gray-700 bg-gray-50 p-3.5 rounded-lg border border-gray-200 whitespace-pre-line min-h-[100px]">
                                {{ $jobApplication->aiGeneratedFeedback ?? 'No AI feedback available for this application yet.' }}
                            </div>
                        </div>

                        <!-- Editable Status Dropdown -->
                        <div class="pt-2">
                            <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">
                                Application Status <span class="text-red-500">*</span>
                            </label>
                            
                            <select name="status" 
                                    id="status" 
                                    required 
                                    class="block w-full px-3.5 py-2.5 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm transition-all
                                           @error('status') border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="" disabled>Select a Status</option>
                                @foreach(['pending', 'accepted', 'rejected'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status', $jobApplication->status) === $statusOption ? 'selected' : '' }}>
                                        {{ $statusOption }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <p class="text-xs text-red-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Footer Action Bar -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                        <a href="{{ route('jobApplication.index') }}" 
                           class="px-4 py-2.5 text-xs font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-200/70 rounded-lg transition-colors">
                            Cancel
                        </a>

                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-400/80 font-medium text-xs uppercase tracking-wider rounded-lg hover:bg-blue-100 hover:text-blue-800 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Update Status</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>