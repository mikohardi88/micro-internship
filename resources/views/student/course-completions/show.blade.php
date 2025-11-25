<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('student.course-completions.index') }}" class="text-indigo-600 hover:text-indigo-900">My Course Completions</a> / {{ $courseCompletion->course_name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('student.course-completions.edit', $courseCompletion) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit
                </a>
                <form action="{{ route('student.course-completions.destroy', $courseCompletion) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Course Name</h3>
                            <p class="text-gray-700">{{ $courseCompletion->course_name }}</p>
                        </div>

                        @if($courseCompletion->institution)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Institution</h3>
                                <p class="text-gray-700">{{ $courseCompletion->institution }}</p>
                            </div>
                        @endif

                        @if($courseCompletion->completion_date)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Completion Date</h3>
                                <p class="text-gray-700">{{ $courseCompletion->completion_date->format('F d, Y') }}</p>
                            </div>
                        @endif

                        @if($courseCompletion->certificate_url)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Certificate</h3>
                                <a href="{{ $courseCompletion->certificate_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    View Certificate
                                </a>
                            </div>
                        @endif

                        @if($courseCompletion->skills_learned)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Skills Learned</h3>
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $courseCompletion->skills_learned }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

