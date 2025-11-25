<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.course-completions.index') }}" class="text-indigo-600 hover:text-indigo-900">My Course Completions</a> / Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('student.course-completions.update', $courseCompletion) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="course_name" value="Course Name" />
                            <x-text-input id="course_name" name="course_name" type="text" class="mt-1 block w-full" :value="old('course_name', $courseCompletion->course_name)" required />
                            <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="institution" value="Institution" />
                            <x-text-input id="institution" name="institution" type="text" class="mt-1 block w-full" :value="old('institution', $courseCompletion->institution)" />
                            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="completion_date" value="Completion Date" />
                            <x-text-input id="completion_date" name="completion_date" type="date" class="mt-1 block w-full" :value="old('completion_date', $courseCompletion->completion_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('completion_date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="certificate_url" value="Certificate URL (Optional)" />
                            <x-text-input id="certificate_url" name="certificate_url" type="url" class="mt-1 block w-full" :value="old('certificate_url', $courseCompletion->certificate_url)" />
                            <x-input-error :messages="$errors->get('certificate_url')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="skills_learned" value="Skills Learned (Optional)" />
                            <textarea id="skills_learned" name="skills_learned" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('skills_learned', $courseCompletion->skills_learned) }}</textarea>
                            <x-input-error :messages="$errors->get('skills_learned')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('student.course-completions.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <x-primary-button>Update Course Completion</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

