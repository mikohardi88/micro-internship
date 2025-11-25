<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.placements.index') }}" class="text-indigo-600 hover:text-indigo-900">My Placements</a> / {{ $placement->project->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 pb-6 border-b">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $placement->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($placement->status === 'terminated' ? 'bg-red-100 text-red-800' : 
                               ($placement->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                               'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $placement->status)) }}
                        </span>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Project Details</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900">{{ $placement->project->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $placement->project->company->name }}</p>
                                <p class="text-sm text-gray-500 mt-2">{{ \Illuminate\Support\Str::limit($placement->project->description, 200) }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @if($placement->start_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                                    <p class="text-gray-900 mt-1">{{ $placement->start_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                            @if($placement->end_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                                    <p class="text-gray-900 mt-1">{{ $placement->end_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                            @if($placement->supervisor_name)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Supervisor</h3>
                                    <p class="text-gray-900 mt-1">{{ $placement->supervisor_name }}</p>
                                    @if($placement->supervisor_email)
                                        <p class="text-sm text-gray-500">{{ $placement->supervisor_email }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if($placement->deliverables->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Deliverables</h3>
                                <div class="space-y-2">
                                    @foreach($placement->deliverables as $deliverable)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $deliverable->title }}</p>
                                                    <p class="text-sm text-gray-500">{{ $deliverable->status }}</p>
                                                </div>
                                                <a href="{{ route('student.deliverables.show', $deliverable) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($placement->certificates->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Certificates</h3>
                                <div class="space-y-2">
                                    @foreach($placement->certificates as $certificate)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="font-medium text-gray-900">Certificate #{{ $certificate->certificate_number }}</p>
                                                    <p class="text-sm text-gray-500">Issued: {{ $certificate->issued_at->format('M d, Y') }}</p>
                                                </div>
                                                <a href="{{ route('student.certificates.show', $certificate) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($placement->status === 'in_progress')
                            <div>
                                <a href="{{ route('student.deliverables.create', $placement) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium inline-block">
                                    Submit Deliverable
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

