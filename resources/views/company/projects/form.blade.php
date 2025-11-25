<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($isEdit) && $isEdit ? 'Edit Project' : 'Create Project' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ $action }}">
                        @csrf
                        @if(isset($isEdit) && $isEdit)
                            @method('PUT')
                        @endif

                        <!-- TITLE -->
                        <div class="mb-4">
                            <x-input-label for="title" value="Title" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                value="{{ old('title', $project->title) }}" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="mb-4">
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description"
                                class="mt-1 block w-full border-gray-300 rounded-md" rows="5"
                                required>{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- SKILLS TEXT INPUT -->
                        <div class="mb-4">
                            <x-input-label for="skills" value="Skills" />
                            <x-text-input
                                id="skills"
                                name="skills"
                                type="text"
                                class="mt-1 block w-full"
                                value="{{ old('skills', $project->skills_text ?? ($project->skills?->pluck('name')->implode(',') ?? '')) }}"
                                placeholder="Contoh: Laravel, Tailwind, UI/UX"
                                required
                            />
                            <p class="text-gray-500 text-sm mt-1">Pisahkan beberapa skill dengan koma. Minimal satu skill.</p>
                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                        </div>

                        <!-- 3 INPUT GRID -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="duration_weeks" value="Duration (weeks)" />
                                <x-text-input id="duration_weeks" name="duration_weeks" type="number"
                                    min="1" max="4" class="mt-1 block w-full"
                                    value="{{ old('duration_weeks', $project->duration_weeks) }}" required />
                                <x-input-error :messages="$errors->get('duration_weeks')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="max_applicants" value="Max Applicants" />
                                <x-text-input id="max_applicants" name="max_applicants" type="number" min="1"
                                    class="mt-1 block w-full"
                                    value="{{ old('max_applicants', $project->max_applicants) }}" />
                                <x-input-error :messages="$errors->get('max_applicants')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="budget" value="Budget" />
                                <x-text-input id="budget" name="budget" type="number" min="0"
                                    class="mt-1 block w-full"
                                    value="{{ old('budget', $project->budget) }}" />
                                <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 rounded-md border text-gray-700">Cancel</a>
                            <x-primary-button>
                                {{ isset($isEdit) && $isEdit ? 'Update' : 'Create' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
