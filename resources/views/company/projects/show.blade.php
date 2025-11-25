<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('company.projects.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                    &larr; Back to projects
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">
                    {{ $project->title }}
                </h2>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('company.projects.edit', $project) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit
                </a>
                @if($project->status === 'open')
                    <a href="{{ route('company.projects.applications.index', $project) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        View Applications
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="mb-6 pb-6 border-b">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ 
                                $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                ($project->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                ($project->status === 'open' ? 'bg-blue-100 text-blue-800' : 
                                ($project->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                ($project->status === 'in_progress' ? 'bg-purple-100 text-purple-800' : 
                                'bg-gray-100 text-gray-800'))))
                            }}">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                        @if($project->status === 'pending')
                            <p class="mt-2 text-sm text-gray-600">
                                Your project is waiting for admin approval. You will be notified once it's reviewed.
                            </p>
                        @elseif($project->status === 'approved')
                            <p class="mt-2 text-sm text-gray-600">
                                Your project has been approved by admin. It will be published when admin makes it available for students.
                            </p>
                        @elseif($project->status === 'rejected')
                            @if($project->admin_notes)
                                <p class="mt-2 text-sm text-red-600">
                                    <strong>Rejection reason:</strong> {{ $project->admin_notes }}
                                </p>
                            @endif
                        @elseif($project->status === 'open')
                            <p class="mt-2 text-sm text-green-600">
                                Your project is now open for student applications.
                            </p>
                        @endif
                    </div>

                    <!-- Project Details -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $project->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Duration</h3>
                                <p class="text-gray-900">{{ $project->duration_weeks }} weeks</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Max Applicants</h3>
                                <p class="text-gray-900">{{ $project->max_applicants ?? 'Unlimited' }}</p>
                            </div>
                            @if($project->start_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                                    <p class="text-gray-900">{{ $project->start_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                            @if($project->end_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                                    <p class="text-gray-900">{{ $project->end_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                            @if($project->budget)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Budget</h3>
                                    <p class="text-gray-900">Rp {{ number_format($project->budget, 0, ',', '.') }}</p>
                                </div>
                            @endif
                        </div>

                        @if($project->skills->count() > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Required Skills</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->skills as $skill)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">
                                            {{ $skill->name }}
                                            @if($skill->pivot->proficiency_level)
                                                ({{ ucfirst($skill->pivot->proficiency_level) }})
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($project->brief_path)
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Project Brief</h3>
                                <a href="{{ route('company.projects.download-brief', $project) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Download Brief File
                                </a>
                            </div>
                        @endif

                        @if($project->admin_notes && $project->status !== 'rejected')
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 mb-2">Admin Notes</h3>
                                <p class="text-gray-700">{{ $project->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

