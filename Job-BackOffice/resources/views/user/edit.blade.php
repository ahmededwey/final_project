<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" 
               class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors"
               title="Back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-900 leading-tight">
                {{ __('Change Password') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Card Wrapper -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden w-full">
                
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Form Body -->
                    <div class="p-6 space-y-5">
                        
                        <!-- Read-Only User Information Section -->
                        <div class="space-y-4 pb-4 border-b border-gray-200">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Full Name
                                </label>
                                <input type="text" 
                                       value="{{ $user->name }}" 
                                       disabled 
                                       class="block w-full px-3.5 py-2.5 bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg cursor-not-allowed shadow-sm select-none">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        Email Address
                                    </label>
                                    <input type="email" 
                                           value="{{ $user->email }}" 
                                           disabled 
                                           class="block w-full px-3.5 py-2.5 bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg cursor-not-allowed shadow-sm select-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        Role
                                    </label>
                                    <input type="text" 
                                           value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" 
                                           disabled 
                                           class="block w-full px-3.5 py-2.5 bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-lg cursor-not-allowed shadow-sm select-none">
                                </div>
                            </div>
                        </div>

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-900 mb-2">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            
                            <input type="password" 
                                   name="current_password" 
                                   id="current_password" 
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full px-3.5 py-2.5 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm transition-all
                                          @error('current_password') border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">

                            @error('current_password')
                                <p class="text-xs text-red-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password & Confirmation Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            
                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">
                                    New Password <span class="text-red-500">*</span>
                                </label>
                                
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       required
                                       autocomplete="new-password"
                                       placeholder="••••••••"
                                       class="block w-full px-3.5 py-2.5 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm transition-all
                                              @error('password') border-red-500 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror">

                                @error('password')
                                    <p class="text-xs text-red-600 mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Confirm New Password <span class="text-red-500">*</span>
                                </label>
                                
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       required
                                       autocomplete="new-password"
                                       placeholder="••••••••"
                                       class="block w-full px-3.5 py-2.5 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 shadow-sm transition-all">
                            </div>
                        </div>

                    </div>

                    <!-- Footer Action Bar -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                        <a href="{{ route('home') }}" 
                           class="px-4 py-2.5 text-xs font-semibold text-gray-700 hover:text-gray-900 hover:bg-gray-200/70 rounded-lg transition-colors">
                            Cancel
                        </a>

                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-400/80 font-medium text-xs uppercase tracking-wider rounded-lg hover:bg-blue-100 hover:text-blue-800 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Update Password</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>