<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Permintaan Magang') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-6">Kirim Permintaan Magang ke Perusahaan</h3>

                    <form method="POST" action="{{ route('student.internship-requests.store') }}">
                        @csrf

                        <!-- Perusahaan -->
                        <div class="mb-6">
                            <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Perusahaan
                            </label>
                            <select name="company_id" id="company_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Pilih perusahaan tujuan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Permintaan
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                placeholder="Contoh: Permintaan Magang UI/UX Design" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Permintaan
                            </label>
                            <textarea name="description" id="description" rows="5" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                placeholder="Jelaskan tentang permintaan magang yang Anda ajukan..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div class="mb-6">
                            <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-2">
                                Durasi (minggu)
                            </label>
                            <select name="duration_weeks" id="duration_weeks" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Pilih durasi</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('duration_weeks') == $i ? 'selected' : '' }}>
                                        {{ $i }} minggu
                                    </option>
                                @endfor
                            </select>
                            @error('duration_weeks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Skill yang Dibutuhkan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Skill yang Dibutuhkan
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($skills as $skill)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="skills_needed[]" id="skill_{{ $skill->id }}" value="{{ $skill->id }}" 
                                            {{ in_array($skill->id, old('skills_needed', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <label for="skill_{{ $skill->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $skill->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('skills_needed')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Tambahan -->
                        <div class="mb-6">
                            <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea name="additional_notes" id="additional_notes" rows="3" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                placeholder="Tambahkan informasi tambahan yang relevan...">{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('student.internship-requests.index') }}" class="px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit" class="ml-3 px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Kirim Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>