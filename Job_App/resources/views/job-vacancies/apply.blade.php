<x-app-layout>
    <x-slot name="header">
        <nav aria-label="{{ __('Breadcrumb') }}" class="flex items-center gap-2 text-sm">
            <a href="{{ route('dashboard') }}" class="font-medium text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                {{ __('Jobs') }}
            </a>
            <span aria-hidden="true" class="text-slate-300 dark:text-slate-600">/</span>
            <span class="font-semibold text-slate-900 dark:text-white">
                {{ __('Apply for Job') }}
            </span>
        </nav>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400">
                <svg aria-hidden="true" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                </svg>
                {{ __('Back to the Job Vacancy') }}
            </a>

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
                <div class="min-w-0">
                    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                        <div class="border-b border-slate-100 p-6 sm:p-8 dark:border-slate-800">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                    {{ $job->type }}
                                </span>
                                @if ($job->category?->name)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $job->category->name }}
                                    </span>
                                @endif
                            </div>

                            <h1 class="mt-4 break-words text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                                {{ $job->title }}
                            </h1>

                            <p class="mt-2 text-lg font-medium text-slate-600 dark:text-slate-300">
                                {{ $job->company?->name ?? __('Company not listed') }}
                            </p>

                            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-500 dark:text-slate-400">
                                @if ($job->location !== $job->type)
                                    <span class="inline-flex items-center gap-2">
                                        <svg aria-hidden="true" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9.69 18.933 9.69 18.932l.01.005.01-.005.027-.016a16.12 16.12 0 0 0 .477-.3 24.5 24.5 0 0 0 3.256-2.56C15.451 14.13 17 11.876 17 9.5a7 7 0 1 0-14 0c0 2.376 1.549 4.63 3.53 6.556a24.5 24.5 0 0 0 3.256 2.56 16.12 16.12 0 0 0 .477.3l.027.016ZM10 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif

                                @if ($job->created_at)
                                    <span class="inline-flex items-center gap-2">
                                        <svg aria-hidden="true" class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18h-10.5A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2ZM3.5 8v7.25c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25V8h-13Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('Posted') }} {{ $job->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if ($googleDriveConnected)
                       <div class="p-6 sm:p-8">
    <form method="POST" action="{{ route('job-vacancies.processApplication', $job->id) }}" enctype="multipart/form-data">
        @csrf

        {{-- Resume section --}}
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                {{ __('Choose Your Resume') }}
            </h3>

            <div>
                <x-input-label for="existing_resume" :value="__('Select from your Existing Resumes')" />
                {{-- list of resumes (ignore for now) --}}
            </div>
                                    @else
                                        <div class="p-6 sm:p-8">
                                            <div role="status" class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-900 dark:border-amber-900 dark:bg-amber-950/30 dark:text-amber-200">
                                                {{ __('Resume submissions are temporarily unavailable because Google Drive has not been connected by the site administrator. Please try again later.') }}
                                            </div>
                                        </div>
                                    @endif

            {{-- Drag and Drop Upload Zone --}}
            <div x-data="{
                isDragging: false,
                fileName: '',
                fileSize: '',
                handleDrop(e) {
                    const files = e.dataTransfer.files;
                    if (files.length) {
                        this.$refs.fileInput.files = files;
                        this.updateFileInfo(files[0]);
                    }
                },
                handleSelect(e) {
                    const files = e.target.files;
                    if (files.length) {
                        this.updateFileInfo(files[0]);
                    }
                },
                updateFileInfo(file) {
                    this.fileName = file.name;
                    this.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                },
                clearFile() {
                    this.$refs.fileInput.value = '';
                    this.fileName = '';
                    this.fileSize = '';
                }
            }">
                <x-input-label for="resume" :value="__('or Upload New Resume')" class="mb-2" />

                {{-- Hidden Native File Input --}}
                <input 
                    type="file" 
                    name="resume" 
                    id="resume" 
                    x-ref="fileInput"
                    @change="handleSelect($event)"
                    accept=".pdf,.doc,.docx"
                    class="sr-only" 
                    required
                >

                {{-- Drop Zone Area --}}
                <div 
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="isDragging = false; handleDrop($event)"
                    :class="isDragging ? 'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-950/20' : 'border-gray-300 dark:border-gray-700 hover:border-indigo-400 bg-white dark:bg-slate-900'"
                    class="relative border-2 border-dashed rounded-xl p-6 transition-all duration-200 cursor-pointer text-center group"
                    @click="$refs.fileInput.click()"
                >
                    {{-- Default / Empty State --}}
                    <div x-show="!fileName" class="flex flex-col items-center justify-center space-y-2">
                        <div class="p-3 bg-indigo-50 dark:bg-slate-800 rounded-full text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-semibold text-indigo-600 dark:text-indigo-400">Click to upload</span> or drag and drop
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, or DOCX (MAX. 5MB)</p>
                    </div>

                    {{-- Selected File Preview State --}}
                    <div x-show="fileName" x-cloak class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-lg text-left" @click.stop>
                        <div class="flex items-center space-x-3 truncate">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded text-indigo-600 dark:text-indigo-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="truncate">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate" x-text="fileName"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="fileSize"></p>
                            </div>
                        </div>

                        <button 
                            type="button" 
                            @click="clearFile()" 
                            class="p-1 text-gray-400 hover:text-red-500 rounded-md transition-colors"
                            title="Remove file"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Validation Error Display --}}
                <x-input-error :messages="$errors->get('resume')" class="mt-2" />
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end pt-4">
                <x-primary-button>
                    {{ __('Submit Application') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</div>
                        

                       
                    </section>
                </div>

              
            </div>
        </div>
    </div>
</x-app-layout>
