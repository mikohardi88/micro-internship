<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Deliverables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('student.deliverables.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <select name="status" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="submitted" @selected(request('status') === 'submitted')>Submitted</option>
                                <option value="under_review" @selected(request('status') === 'under_review')>Under Review</option>
                                <option value="revision_requested" @selected(request('status') === 'revision_requested')>Revision Requested</option>
                                <option value="accepted" @selected(request('status') === 'accepted')>Accepted</option>
                                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                            </select>
                            <x-primary-button type="submit">Filter</x-primary-button>
                        </div>
                    </form>

                    <div class="divide-y divide-gray-200">
                        @forelse($deliverables as $deliverable)
                            <div class="py-4 flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $deliverable->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $deliverable->placement->project->title }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Submitted: {{ $deliverable->submitted_at->format('M d, Y') }}</p>
                                    @if($deliverable->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($deliverable->description, 100) }}</p>
                                    @endif
                                </div>
                                <div class="ml-4 flex items-center gap-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $deliverable->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                           ($deliverable->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                           ($deliverable->status === 'revision_requested' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($deliverable->status === 'under_review' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-gray-100 text-gray-800'))) }}">
                                        {{ ucfirst(str_replace('_', ' ', $deliverable->status)) }}
                                    </span>
                                    <a href="{{ route('student.deliverables.show', $deliverable) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-gray-500">No deliverables found.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $deliverables->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

