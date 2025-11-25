<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.applications.index') }}" class="text-indigo-600 hover:text-indigo-900">My Applications</a> / {{ $application->project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 pb-6 border-b">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                               ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                               ($application->status === 'shortlisted' ? 'bg-blue-100 text-blue-800' : 
                               'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst($application->status) }}
                        </span>
                        <p class="mt-2 text-sm text-gray-500">
                            Applied on {{ $application->applied_at->format('M d, Y H:i') }}
                        </p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Project Details</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900">{{ $application->project->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $application->project->company->name }}</p>
                                <p class="text-sm text-gray-500 mt-2">{{ \Illuminate\Support\Str::limit($application->project->description, 200) }}</p>
                                <div class="mt-3 flex gap-4 text-sm text-gray-500">
                                    <span>Duration: {{ $application->project->duration_weeks }} weeks</span>
                                    <span>•</span>
                                    <span>Max Applicants: {{ $application->project->max_applicants ?? 'Unlimited' }}</span>
                                </div>
                            </div>
                        </div>

                        @if($application->cover_letter)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Cover Letter</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                            </div>
                        @endif

                        @if($application->decision_notes)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Decision Notes</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $application->decision_notes }}</p>
                            </div>
                        @endif

                        @if($application->decided_at)
                            <div>
                                <p class="text-sm text-gray-500">
                                    Decision made on {{ $application->decided_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

