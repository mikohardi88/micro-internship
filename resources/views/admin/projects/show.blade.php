<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Review Proyek - Vinix Micro Internship</title>
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

  <!-- SIDEBAR KEREN -->
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
      <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
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
      <!-- BREADCRUMB -->
      <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
          <i class="fas fa-arrow-left mr-2"></i>Kembali ke daftar proyek
        </a>
      </div>

      <!-- PROJECT DETAILS -->
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="flex flex-wrap justify-between items-start mb-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $project->title }}</h1>
            <div class="flex items-center space-x-4">
              <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                @if($project->status === 'pending') bg-yellow-100 text-yellow-800 
                @elseif($project->status === 'approved') bg-green-100 text-green-800 
                @elseif($project->status === 'rejected') bg-red-100 text-red-800 
                @elseif($project->status === 'open') bg-blue-100 text-blue-800 
                @elseif($project->status === 'in_progress') bg-indigo-100 text-indigo-800 
                @else bg-gray-100 text-gray-800 @endif">
                {{ str_replace('_', ' ', ucfirst($project->status)) }}
              </span>
              <span class="text-sm text-gray-500">Oleh: {{ $project->company->name ?? 'N/A' }}</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Project Information -->
          <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-50 p-5 rounded-lg">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Proyek</h2>
              <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
            </div>

            <div class="bg-gray-50 p-5 rounded-lg">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Kebutuhan Proyek</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <h3 class="font-medium text-gray-700">Durasi</h3>
                  <p class="text-gray-900">{{ $project->duration_weeks }} minggu</p>
                </div>
                <div>
                  <h3 class="font-medium text-gray-700">Jumlah Peserta</h3>
                  <p class="text-gray-900">{{ $project->max_applicants ?? 'Tidak terbatas' }}</p>
                </div>
                @if($project->budget)
                <div>
                  <h3 class="font-medium text-gray-700">Anggaran</h3>
                  <p class="text-gray-900">Rp{{ number_format($project->budget, 0, ',', '.') }}</p>
                </div>
                @endif
                <div>
                  <h3 class="font-medium text-gray-700">Tanggal Mulai</h3>
                  <p class="text-gray-900">{{ $project->start_date ? $project->start_date->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                  <h3 class="font-medium text-gray-700">Tanggal Selesai</h3>
                  <p class="text-gray-900">{{ $project->end_date ? $project->end_date->format('d M Y') : 'N/A' }}</p>
                </div>
              </div>
            </div>

            <!-- Skills Required -->
            <div class="bg-gray-50 p-5 rounded-lg">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Kemampuan yang Dibutuhkan</h2>
              <div class="flex flex-wrap gap-2">
                @if($project->skills->count() > 0)
                  @foreach($project->skills as $skill)
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $skill->name }}</span>
                  @endforeach
                @else
                  <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">Tidak ada keterampilan khusus</span>
                @endif
              </div>
            </div>
          </div>

          <!-- Company Information -->
          <div>
            <div class="bg-gray-50 p-5 rounded-lg mb-6">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Perusahaan</h2>
              <div class="space-y-3">
                <div>
                  <h3 class="font-medium text-gray-700">Nama Perusahaan</h3>
                  <p class="text-gray-900">{{ $project->company->name }}</p>
                </div>
                @if($project->company->industry)
                <div>
                  <h3 class="font-medium text-gray-700">Industri</h3>
                  <p class="text-gray-900">{{ $project->company->industry }}</p>
                </div>
                @endif
                @if($project->company->company_size)
                <div>
                  <h3 class="font-medium text-gray-700">Ukuran Perusahaan</h3>
                  <p class="text-gray-900">{{ $project->company->company_size }}</p>
                </div>
                @endif
                @if($project->company->address)
                <div>
                  <h3 class="font-medium text-gray-700">Alamat</h3>
                  <p class="text-gray-900">{{ $project->company->address }}</p>
                </div>
                @endif
                @if($project->company->website)
                <div>
                  <h3 class="font-medium text-gray-700">Website</h3>
                  <p class="text-gray-900">{{ $project->company->website }}</p>
                </div>
                @endif
              </div>
            </div>

            <!-- Approval Actions -->
            @if($project->status === 'pending')
            <div class="bg-white border border-gray-200 p-5 rounded-lg shadow-sm">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Tindakan</h2>
              <form action="{{ route('admin.projects.approve', $project) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                  <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                  <textarea name="notes" id="notes" rows="3" placeholder="Tambahkan catatan opsional..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
                  Setujui Proyek
                </button>
              </form>
              
              <form action="{{ route('admin.projects.reject', $project) }}" method="POST">
                @csrf
                <button type="button" onclick="toggleRejectForm()" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                  Tolak Proyek
                </button>
                
                <div id="reject-form" class="hidden mt-4">
                  <div class="mb-4">
                    <label for="reject_reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea name="reject_reason" id="reject_reason" rows="3" required placeholder="Jelaskan alasan penolakan..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                  </div>
                  <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                    Konfirmasi Penolakan
                  </button>
                </div>
              </form>
            </div>
            @elseif($project->admin_notes)
            <div class="bg-gray-50 p-5 rounded-lg">
              <h2 class="text-xl font-semibold text-gray-800 mb-4">Catatan Admin</h2>
              <p class="text-gray-700">{{ $project->admin_notes }}</p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('closed');
    }
    
    function toggleRejectForm() {
      const rejectForm = document.getElementById('reject-form');
      const button = event.target;
      
      if (rejectForm.classList.contains('hidden')) {
        rejectForm.classList.remove('hidden');
        button.textContent = 'Batal';
        button.onclick = function() {
          rejectForm.classList.add('hidden');
          button.textContent = 'Tolak Proyek';
          button.onclick = function() { toggleRejectForm(); };
        };
      }
    }
  </script>
</body>
</html>