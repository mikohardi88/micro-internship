<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Permintaan Magang') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $internshipRequest->title }}</h3>
                            <div class="mt-2 flex items-center space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($internshipRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($internshipRequest->status === 'approved') bg-green-100 text-green-800
                                    @elseif($internshipRequest->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($internshipRequest->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($internshipRequest->status === 'completed') bg-purple-100 text-purple-800
                                    @endif">
                                    {{ ucfirst($internshipRequest->status) }}
                                </span>
                                <span class="text-sm text-gray-600">{{ $internshipRequest->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Umum -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Perusahaan Tujuan</h4>
                            <p class="text-gray-900">{{ $internshipRequest->company->name ?? 'Perusahaan Tidak Ditemukan' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Durasi</h4>
                            <p class="text-gray-900">{{ $internshipRequest->duration_weeks }} minggu</p>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-8">
                        <h4 class="font-medium text-gray-700 mb-2">Deskripsi Permintaan</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $internshipRequest->description }}</p>
                        </div>
                    </div>

                    <!-- Skill yang Dibutuhkan -->
                    @if($internshipRequest->skills_needed && count($internshipRequest->skills_needed) > 0)
                        <div class="mb-8">
                            <h4 class="font-medium text-gray-700 mb-2">Skill yang Dibutuhkan</h4>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $skillIds = is_array($internshipRequest->skills_needed) ? $internshipRequest->skills_needed : json_decode($internshipRequest->skills_needed, true);
                                @endphp
                                @if($skillIds)
                                    @foreach($skillIds as $skillId)
                                        @php
                                            $skill = \App\Models\Skill::find($skillId);
                                        @endphp
                                        @if($skill)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                {{ $skill->name }}
                                            </span>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Catatan Tambahan -->
                    @if($internshipRequest->additional_notes)
                        <div class="mb-8">
                            <h4 class="font-medium text-gray-700 mb-2">Catatan Tambahan</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900">{{ $internshipRequest->additional_notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Status History -->
                    <div class="mb-8">
                        <h4 class="font-medium text-gray-700 mb-2">Catatan Status</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">Dibuat:</span> 
                                            {{ $internshipRequest->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </li>
                                @if($internshipRequest->approved_at)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-700">
                                                <span class="font-medium">Disetujui:</span> 
                                                {{ $internshipRequest->approved_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('student.internship-requests.index') }}" class="px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Kembali
                        </a>
                        @if($internshipRequest->status === 'pending')
                            <a href="{{ route('student.internship-requests.edit', $internshipRequest) }}" class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>