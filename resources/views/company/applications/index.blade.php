<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aplikasi Masuk - Vinix Micro Internship</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .sidebar { transition: all 0.3s ease; }
    .sidebar.closed { width: 5rem; }
    .sidebar.closed .nav-text { opacity: 0; }
  </style>
</head>
<body class="bg-gray-50 font-sans">

  <!-- SIDEBAR -->
  <aside id="sidebar" class="sidebar fixed left-0 top-0 h-full w-64 bg-white shadow-xl z-50">
    <div class="p-6 border-b">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold">V</div>
          <h1 class="text-xl font-bold text-gray-800 nav-text">Vinix</h1>
        </div>
        <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700 lg:hidden">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>

    <nav class="p-4 space-y-2">
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-home w-5"></i>
        <span class="nav-text">Dashboard</span>
      </a>

      @role('student')
      <a href="{{ route('student.projects.browse') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek Tersedia</span>
      </a>
      <a href="{{ route('student.placements.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-tasks w-5"></i>
        <span class="nav-text">Internship Saya</span>
      </a>
      <a href="{{ route('student.applications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-file-alt w-5"></i>
        <span class="nav-text">Lamaran Saya</span>
      </a>
      <a href="{{ route('student.certificates.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-certificate w-5"></i>
        <span class="nav-text">Sertifikat</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-user w-5"></i>
        <span class="nav-text">Profil</span>
      </a>
      @endrole

      @role('company')
      <a href="{{ route('company.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek Saya</span>
      </a>
      <a href="{{ route('company.projects.create') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-plus w-5"></i>
        <span class="nav-text">Buat Proyek</span>
      </a>
      <a href="{{ route('company.applications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
        <i class="fas fa-file-alt w-5"></i>
        <span class="nav-text">Aplikasi Masuk</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-user w-5"></i>
        <span class="nav-text">Profil</span>
      </a>
      @endrole

      @role('admin')
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-tachometer-alt w-5"></i>
        <span class="nav-text">Dashboard Admin</span>
      </a>
      <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek</span>
      </a>
      <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-users w-5"></i>
        <span class="nav-text">Pengguna</span>
      </a>
      <a href="{{ route('admin.companies.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-building w-5"></i>
        <span class="nav-text">Perusahaan</span>
      </a>
      <a href="{{ route('admin.skills.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-tags w-5"></i>
        <span class="nav-text">Kemampuan</span>
      </a>
      <a href="{{ route('admin.ukm-requests.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-comments w-5"></i>
        <span class="nav-text">Permintaan UKM</span>
      </a>
      @endrole
    </nav>

    <div class="absolute bottom-0 w-full p-4 border-t">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center space-x-3 text-red-600 hover:text-red-700 w-full">
          <i class="fas fa-sign-out-alt w-5"></i>
          <span class="nav-text">Keluar</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="lg:ml-64 p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Aplikasi Masuk</h1>
        <p class="text-gray-600">Kelola lamaran untuk proyek Anda</p>
      </div>

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

      <!-- Filter Tabs -->
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8">
            <a href="?status=all" class="{{ request('status') == 'all' || !request('status') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
              Semua ({{ $allApplications->count() }})
            </a>
            <a href="?status=pending" class="{{ request('status') == 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
              Menunggu ({{ $pendingApplications->count() }})
            </a>
            <a href="?status=accepted" class="{{ request('status') == 'accepted' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
              Diterima ({{ $acceptedApplications->count() }})
            </a>
            <a href="?status=rejected" class="{{ request('status') == 'rejected' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
              Ditolak ({{ $rejectedApplications->count() }})
            </a>
          </nav>
        </div>
      </div>

      <!-- Applications List -->
      <div class="space-y-4">
        @forelse($applications as $application)
          <div class="bg-white rounded-xl shadow-sm border p-6 hover:bg-gray-50 transition-colors">
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <div class="flex items-center mb-3">
                  <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                    <span class="text-indigo-600 font-medium">
                      {{ strtoupper(substr($application->user->name, 0, 1)) }}
                    </span>
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-900">{{ $application->user->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                  </div>
                </div>

                <div class="mb-3">
                  <span class="text-sm font-medium text-gray-900">Proyek:</span>
                  <a href="{{ route('company.projects.show', $application->project) }}" class="ml-2 text-sm text-indigo-600 hover:text-indigo-800">
                    {{ $application->project->title }}
                  </a>
                </div>

                @if($application->cover_letter)
                  <div class="mt-3 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                  </div>
                @endif

                <div class="mt-4 flex items-center space-x-6 text-sm text-gray-500">
                  <span>Diajukan: {{ $application->applied_at->format('d M Y, H:i') }}</span>
                  @if($application->matching_score)
                    <span class="flex items-center">
                      <i class="fas fa-star text-yellow-400 mr-1"></i>
                      Skor Kecocokan: {{ $application->matching_score }}%
                    </span>
                  @endif
                </div>
              </div>

              <div class="ml-4 text-right">
                <!-- Status Badge -->
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                  {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                  {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                  {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                  {{ ucfirst(__($application->status)) }}
                </span>

                <!-- Action Buttons -->
                @if($application->status === 'pending')
                  <div class="mt-3 space-x-2">
                    <button onclick="openDecisionModal({{ $application->id }}, 'accept', {{ $application->project->id }})"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                      Terima
                    </button>
                    <button onclick="openDecisionModal({{ $application->id }}, 'reject', {{ $application->project->id }})"
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                      Tolak
                    </button>
                  </div>
                @endif
              </div>
            </div>

            @if($application->status === 'accepted' && $application->decision_note)
              <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-800">
                  <strong>Catatan:</strong> {{ $application->decision_note }}
                </p>
              </div>
            @elseif($application->status === 'rejected' && $application->decision_note)
              <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-800">
                  <strong>Alasan penolakan:</strong> {{ $application->decision_note }}
                </p>
              </div>
            @endif
          </div>
        @empty
          <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
            <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada aplikasi</h3>
            <p class="text-gray-500">Belum ada aplikasi masuk untuk proyek Anda.</p>
          </div>
        @endforelse
      </div>
    </div>
  </main>

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
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Tambahkan catatan jika diperlukan..."></textarea>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeDecisionModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
              Batal
            </button>
            <button type="submit" id="submitBtn"
                    class="px-4 py-2 rounded-lg text-white">
              Konfirmasi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('closed');
    }

    function openDecisionModal(applicationId, decision, projectId) {
      const modal = document.getElementById('decisionModal');
      const form = document.getElementById('decisionForm');
      const title = document.getElementById('modalTitle');
      const submitBtn = document.getElementById('submitBtn');

      document.getElementById('decisionInput').value = decision;
      form.action = `/company/projects/${projectId}/applications/${applicationId}/decide`;

      if (decision === 'accept') {
        title.textContent = 'Terima Aplikasi';
        submitBtn.className = 'px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700';
        submitBtn.textContent = 'Terima';
      } else {
        title.textContent = 'Tolak Aplikasi';
        submitBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700';
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
</body>
</html>
