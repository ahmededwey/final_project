<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Top Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">Active Users</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $activeUsers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
                </div>


                <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900">Total Jobs</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalJobs }}</p>
                    <p class="text-sm text-gray-500 mt-1">All time</p>  

                </div>
            </div>

            <!-- Most Applied Jobs Table Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-base font-bold text-gray-900 mb-6">
                    Most Applied Jobs
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3.5">Job Title</th>
                                <th class="pb-3.5">Company</th>
                                <th class="pb-3.5">Applications</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($mostAppliedJobs ?? [] as $job)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 font-semibold text-gray-800">{{ $job->title }}</td>
                                    <td class="py-4 text-gray-600">{{ $job->company->name ?? 'N/A' }}</td>
                                    <td class="py-4 text-gray-600">{{ $job->applications_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">No job applications recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Converting Job Posts Table Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-base font-bold text-gray-900 mb-6">
                    Top Converting Job Posts
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3.5">Job Title</th>
                                <th class="pb-3.5">Views</th>
                                <th class="pb-3.5">Applications</th>
                                <th class="pb-3.5">Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($topConvertingJobs ?? [] as $job)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 font-semibold text-gray-800">{{ $job->title }}</td>
                                    <td class="py-4 text-gray-600">{{ number_format($job->views_count) }}</td>
                                    <td class="py-4 text-gray-600">{{ $job->applications_count }}</td>
                                    <td class="py-4 font-semibold text-gray-800">{{ $job->conversion_rate }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No page view data available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>