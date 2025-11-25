<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.deliverables.index') }}" class="text-indigo-600 hover:text-indigo-900">My Deliverables</a> / {{ $deliverable->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 pb-6 border-b">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $deliverable->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                               ($deliverable->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                               ($deliverable->status === 'revision_requested' ? 'bg-yellow-100 text-yellow-800' : 
                               ($deliverable->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                               'bg-gray-100 text-gray-800'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $deliverable->status)) }}
                        </span>
                        <p class="mt-2 text-sm text-gray-500">
                            Submitted on {{ $deliverable->submitted_at->format('M d, Y H:i') }}
                        </p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Project</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900">{{ $deliverable->placement->project->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $deliverable->placement->project->company->name }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Title</h3>
                            <p class="text-gray-700">{{ $deliverable->title }}</p>
                        </div>

                        @if($deliverable->description)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $deliverable->description }}</p>
                            </div>
                        @endif

                        @if($deliverable->file_path)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">File</h3>
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($deliverable->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    Download File
                                </a>
                            </div>
                        @endif

                        @if($deliverable->feedback)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Feedback</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $deliverable->feedback }}</p>
                            </div>
                        @endif

                        @if($deliverable->reviewed_at)
                            <div>
                                <p class="text-sm text-gray-500">
                                    Reviewed on {{ $deliverable->reviewed_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

