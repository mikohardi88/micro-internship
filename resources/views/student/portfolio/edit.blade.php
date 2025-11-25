<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.portfolio.index') }}" class="text-indigo-600 hover:text-indigo-900">My Portfolio</a> / Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('student.portfolio.update', $portfolioItem) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $portfolioItem->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $portfolioItem->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="file" value="File (Optional)" />
                            <input id="file" name="file" type="file" class="mt-1 block w-full" />
                            @if($portfolioItem->file_path)
                                <p class="mt-1 text-sm text-gray-500">Current file: {{ basename($portfolioItem->file_path) }}</p>
                            @endif
                            <p class="mt-1 text-sm text-gray-500">Max size: 10MB</p>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="url" value="URL (Optional)" />
                            <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url', $portfolioItem->url)" />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="visibility" value="Visibility" />
                            <select id="visibility" name="visibility" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="public" @selected(old('visibility', $portfolioItem->visibility) === 'public')>Public</option>
                                <option value="private" @selected(old('visibility', $portfolioItem->visibility) === 'private')>Private</option>
                            </select>
                            <x-input-error :messages="$errors->get('visibility')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @checked(old('featured', $portfolioItem->featured))>
                                <span class="ml-2 text-sm text-gray-600">Featured</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('student.portfolio.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>Update Portfolio Item</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

