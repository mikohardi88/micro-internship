<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Applications - {{ $project->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Project Info -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-600">{{ $project->applications_count }} aplikasi diterima</p>
                    </div>

                    <!-- Applications List -->
                    <div class="space-y-4">
                        @forelse($applications as $application)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-indigo-600 font-medium">
                                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $application->user->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                            </div>
                                        </div>
                                        
                                        @if($application->cover_letter)
                                            <div class="mt-3 p-3 bg-gray-50 rounded">
                                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                                            </div>
                                        @endif

                                        <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                                            <span>Diajukan: {{ $application->applied_at->format('d M Y, H:i') }}</span>
                                            @if($application->matching_score)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    Skor Kecocokan: {{ $application->matching_score }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <!-- Status Badge -->
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($application->status) }}
                                        </span>

                                        <!-- Action Buttons -->
                                        @if($application->status === 'pending')
                                            <div class="mt-3 space-x-2">
                                                <button onclick="openDecisionModal({{ $application->id }}, 'accept')" 
                                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                                    Terima
                                                </button>
                                                <button onclick="openDecisionModal({{ $application->id }}, 'reject')" 
                                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                    Tolak
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($application->status === 'accepted' && $application->decision_note)
                                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded">
                                        <p class="text-sm text-green-800">
                                            <strong>Catatan:</strong> {{ $application->decision_note }}
                                        </p>
                                    </div>
                                @elseif($application->status === 'rejected' && $application->decision_note)
                                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded">
                                        <p class="text-sm text-red-800">
                                            <strong>Alasan penolakan:</strong> {{ $application->decision_note }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aplikasi</h3>
                                <p class="mt-1 text-sm text-gray-500">Mahasiswa belum mendaftar untuk proyek ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Decision Modal -->
    <div id="decisionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                    Buat Keputusan
                </h3>
                <form id="decisionForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="decision" id="decisionInput">
                    
                    <div class="mt-4">
                        <label for="note" class="block text-sm font-medium text-gray-700">
                            Catatan (opsional)
                        </label>
                        <textarea id="note" name="note" rows="3" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeDecisionModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn" 
                                class="px-4 py-2 rounded-md text-white">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDecisionModal(applicationId, decision) {
            const modal = document.getElementById('decisionModal');
            const form = document.getElementById('decisionForm');
            const title = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('submitBtn');
            
            document.getElementById('decisionInput').value = decision;
            form.action = `{{ route('company.projects.applications.decide', $project) }}`.replace('{application}', applicationId);
            
            if (decision === 'accept') {
                title.textContent = 'Terima Aplikasi';
                submitBtn.className = 'px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700';
                submitBtn.textContent = 'Terima';
            } else {
                title.textContent = 'Tolak Aplikasi';
                submitBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700';
                submitBtn.textContent = 'Tolak';
            }
            
            modal.classList.remove('hidden');
        }

        function closeDecisionModal() {
            document.getElementById('decisionModal').classList.add('hidden');
            document.getElementById('decisionForm').reset();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('decisionModal');
            if (event.target === modal) {
                closeDecisionModal();
            }
        }
    </script>
</x-app-layout>
