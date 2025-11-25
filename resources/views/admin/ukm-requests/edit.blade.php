<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Permintaan UKM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium">Edit Permintaan UKM</h3>
                        <a href="{{ route('admin.ukm-requests.show', $ukmRequest->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Kembali</a>
                    </div>

                    <form action="{{ route('admin.ukm-requests.update', $ukmRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3">Informasi Umum</h4>

                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between border-b pb-1">
                                        <span class="font-medium text-gray-600">ID:</span>
                                        <span class="text-gray-800">{{ $ukmRequest->id }}</span>
                                    </div>
                                    <div class="flex justify-between border-b pb-1">
                                        <span class="font-medium text-gray-600">Nama UKM:</span>
                                        <span class="text-gray-800">{{ $ukmRequest->user->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b pb-1">
                                        <span class="font-medium text-gray-600">Email UKM:</span>
                                        <span class="text-gray-800">{{ $ukmRequest->user->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b pb-1">
                                        <span class="font-medium text-gray-600">Jenis Permintaan:</span>
                                        <span>
                                            @switch($ukmRequest->request_type)
                                                @case('registration')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Pendaftaran
                                                    </span>
                                                    @break
                                                @case('verification')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                        Verifikasi
                                                    </span>
                                                    @break
                                                @case('technical_help')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Bantuan Teknis
                                                    </span>
                                                    @break
                                                @case('training')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Pelatihan
                                                    </span>
                                                    @break
                                                @case('project')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Proyek
                                                    </span>
                                                    @break
                                                @case('marketing')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Pemasaran
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Lainnya
                                                    </span>
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="flex justify-between border-b pb-1">
                                        <span class="font-medium text-gray-600">Judul:</span>
                                        <span class="text-gray-800">{{ $ukmRequest->title }}</span>
                                    </div>
                                </div>

                                <div class="bg-white p-3 rounded border">
                                    <h4 class="font-medium text-gray-700 mb-2">Deskripsi Permintaan</h4>
                                    <div class="max-h-40 overflow-y-auto">
                                        {{ $ukmRequest->description }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror" required>
                                        <option value="pending" {{ old('status', $ukmRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status', $ukmRequest->status) == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="resolved" {{ old('status', $ukmRequest->status) == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        <option value="rejected" {{ old('status', $ukmRequest->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin</label>
                                    <textarea name="admin_notes" id="admin_notes" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('admin_notes') border-red-500 @enderror" rows="6">{{ old('admin_notes', $ukmRequest->admin_notes) }}</textarea>
                                    @error('admin_notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Catatan ini hanya akan terlihat oleh admin</p>
                                </div>

                                <div class="flex space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Perbarui Permintaan</button>
                                    <a href="{{ route('admin.ukm-requests.show', $ukmRequest->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>