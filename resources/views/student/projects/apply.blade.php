<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pilih & Tempatkan: {{ $project->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Box -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-green-800 font-semibold">Penempatan Langsung!</h3>
                        <p class="text-green-700 text-sm mt-1">
                            Dengan memilih proyek ini, Anda akan langsung ditempatkan di magang ini. 
                            Pastikan Anda benar-benar ingin mengikuti proyek ini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Proyek</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Perusahaan:</span>
                            <p class="font-medium">{{ $project->company->name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Durasi:</span>
                            <p class="font-medium">{{ $project->duration_weeks }} minggu</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Lokasi:</span>
                            <p class="font-medium">{{ $project->location ?? 'Remote' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Tanggal Mulai:</span>
                            <p class="font-medium">{{ $project->start_date->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-500">Deskripsi:</span>
                        <p class="text-gray-700 mt-1">{{ $project->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('student.projects.apply', $project) }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="cover_letter" value="Cover Letter (Opsional)" />
                            <textarea id="cover_letter" name="cover_letter" class="mt-1 block w-full border-gray-300 rounded-md" rows="6" placeholder="Jelaskan motivasi, pengalaman relevan, dan ketersediaan Anda.">{{ old('cover_letter') }}</textarea>
                            <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('student.projects.browse') }}" class="px-4 py-2 rounded-md border text-gray-700">Batal</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium">
                                Pilih & Tempatkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
