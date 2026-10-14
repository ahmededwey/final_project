<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('User Details') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Viewing complete profile information for {{ $user->name }}.
                </p>
            </div>
            <a href="{{ route('user.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 font-medium text-xs uppercase tracking-wider rounded-lg hover:bg-gray-50 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Main Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                
                <!-- Profile Header Banner / Info Section -->
                <div class="p-6 sm:p-8 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <!-- Large Avatar Initials -->
                    <div class="w-20 h-20 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-2xl shadow-inner shrink-0">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                    </div>

                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                            
                            <!-- Role Badge -->
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 capitalize">
                                {{ $user->role ?? 'Standard' }}
                            </span>

                            <!-- Status Badge -->
                            @if($user->trashed())
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Deleted {{ $user->deleted_at->diffForHumans() }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $user->email }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    @if(!$user->trashed() && strtolower($user->role) !== 'admin')
                        <div class="flex items-center gap-2 self-start sm:self-center">
                            <a href="{{ route('user.edit', $user) }}" 
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Detailed Information Grid -->
                <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50">
                    
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Full Name</span>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Address</span>
                        <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Account Role</span>
                        <p class="text-sm font-medium text-gray-900 capitalize">{{ $user->role ?? 'Standard' }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Account Created</span>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $user->created_at ? $user->created_at->format('F j, Y, g:i a') : 'N/A' }}
                        </p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Updated</span>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $user->updated_at ? $user->updated_at->format('F j, Y, g:i a') : 'N/A' }}
                        </p>
                    </div>

                    @if($user->trashed())
                        <div class="bg-white p-4 rounded-xl border border-red-100 shadow-sm space-y-1">
                            <span class="text-xs font-semibold text-red-400 uppercase tracking-wider">Deleted At</span>
                            <p class="text-sm font-medium text-red-700">
                                {{ $user->deleted_at->format('F j, Y, g:i a') }}
                            </p>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>