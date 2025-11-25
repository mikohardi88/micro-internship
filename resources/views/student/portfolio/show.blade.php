<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('student.portfolio.index') }}" class="text-indigo-600 hover:text-indigo-900">My Portfolio</a> / {{ $portfolioItem->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('student.portfolio.edit', $portfolioItem) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit
                </a>
                <form action="{{ route('student.portfolio.destroy', $portfolioItem) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 pb-6 border-b">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $portfolioItem->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($portfolioItem->visibility) }}
                            </span>
                            @if($portfolioItem->featured)
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Featured</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Title</h3>
                            <p class="text-gray-700">{{ $portfolioItem->title }}</p>
                        </div>

                        @if($portfolioItem->description)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $portfolioItem->description }}</p>
                            </div>
                        @endif

                        @if($portfolioItem->file_path)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">File</h3>
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($portfolioItem->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    Download File
                                </a>
                            </div>
                        @endif

                        @if($portfolioItem->url)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">URL</h3>
                                <a href="{{ $portfolioItem->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $portfolioItem->url }}
                                </a>
                            </div>
                        @endif

                        @if($portfolioItem->project)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Related Project</h3>
                                <p class="text-gray-700">{{ $portfolioItem->project->title }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

