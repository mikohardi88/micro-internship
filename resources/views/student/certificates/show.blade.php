<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('student.certificates.index') }}" class="text-indigo-600 hover:text-indigo-900">My Certificates</a> / Certificate #{{ $certificate->certificate_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Certificate Number</h3>
                            <p class="text-gray-700 font-mono">{{ $certificate->certificate_number }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Project</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900">{{ $certificate->placement->project->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $certificate->placement->project->company->name }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Issued Date</h3>
                            <p class="text-gray-700">{{ $certificate->issued_at->format('F d, Y') }}</p>
                        </div>

                        @if($certificate->file_path)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Certificate File</h3>
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($certificate->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    Download Certificate
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

