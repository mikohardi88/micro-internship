<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Certificates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="divide-y divide-gray-200">
                        @forelse($certificates as $certificate)
                            <div class="py-4 flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Certificate #{{ $certificate->certificate_number }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $certificate->placement->project->title }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $certificate->placement->project->company->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Issued: {{ $certificate->issued_at->format('M d, Y') }}</p>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('student.certificates.show', $certificate) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Certificate
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-gray-500">No certificates found.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $certificates->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

