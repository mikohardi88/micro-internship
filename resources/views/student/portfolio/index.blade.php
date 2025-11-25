<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Portfolio') }}
            </h2>
            <a href="{{ route('student.portfolio.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add Portfolio Item
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('student.portfolio.index') }}" class="mb-6">
                        <div class="flex gap-4">
                            <select name="visibility" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Visibility</option>
                                <option value="public" @selected(request('visibility') === 'public')>Public</option>
                                <option value="private" @selected(request('visibility') === 'private')>Private</option>
                            </select>
                            <x-primary-button type="submit">Filter</x-primary-button>
                        </div>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($portfolioItems as $item)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                @if($item->file_path)
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">File Attached</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h3>
                                        @if($item->featured)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Featured</span>
                                        @endif
                                    </div>
                                    @if($item->description)
                                        <p class="text-sm text-gray-600 mb-2">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mt-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $item->visibility === 'public' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($item->visibility) }}
                                        </span>
                                        <div class="flex gap-2">
                                            <a href="{{ route('student.portfolio.show', $item) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                            <a href="{{ route('student.portfolio.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center">
                                <p class="text-gray-500">No portfolio items found.</p>
                                <a href="{{ route('student.portfolio.create') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900">
                                    Add Your First Portfolio Item
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $portfolioItems->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

