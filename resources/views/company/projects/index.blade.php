<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Proyek Saya - Vinix Micro Internship</title>
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
      <a href="{{ route('company.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
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
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-800">Proyek Saya</h1>
          <p class="text-gray-600">Kelola proyek magang mikro Anda</p>
        </div>
        <a href="{{ route('company.projects.create') }}" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
          Buat Proyek Baru
        </a>
      </div>

      <!-- Flash Messages -->
      @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          {{ session('error') }}
        </div>
      @endif

      <!-- Project List -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="overflow-hidden
          @if($projects->count() > 0)
            divide-y divide-gray-200
          @endif">
          @forelse($projects as $project)
            <div class="py-4 flex items-center justify-between hover:bg-gray-50">
              <div class="flex-1 min-w-0">
                <a href="{{ route('company.projects.show', $project) }}" class="block hover:text-indigo-600">
                  <p class="text-sm font-medium text-gray-900 truncate">
                    {{ $project->title }}
                  </p>
                  <p class="text-sm text-gray-500 truncate mt-1">
                    {{ \Illuminate\Support\Str::limit($project->description, 100) }}
                  </p>
                  <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                    <span>Durasi: {{ $project->duration_weeks }} minggu</span>
                    <span>•</span>
                    <span>Pelamar Maks: {{ $project->max_applicants ?? 'Tidak terbatas' }}</span>
                    @if($project->applications_count ?? 0)
                      <span>•</span>
                      <span>Pelamar: {{ $project->applications_count }}</span>
                    @endif
                  </div>
                </a>
              </div>
              <div class="ml-4 flex-shrink-0 flex items-center space-x-3">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                  {{
                      $project->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                      ($project->status === 'approved' ? 'bg-green-100 text-green-800' :
                      ($project->status === 'open' ? 'bg-blue-100 text-blue-800' :
                      ($project->status === 'rejected' ? 'bg-red-100 text-red-800' :
                      ($project->status === 'in_progress' ? 'bg-purple-100 text-purple-800' :
                      'bg-gray-100 text-gray-800'))))
                  }}">
                  {{ ucfirst(str_replace('_', ' ', __($project->status))) }}
                </span>
                <div class="flex space-x-2">
                  <a href="{{ route('company.projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                    Edit
                  </a>
                  @if($project->status === 'open')
                    <a href="{{ route('company.projects.applications.index', $project) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                      Lihat Lamaran
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @empty
            <div class="text-center py-12">
              <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
              <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada proyek</h3>
              <p class="mt-1 text-gray-500">
                Mulai dengan membuat proyek baru.
              </p>
              <div class="mt-6">
                <a href="{{ route('company.projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                  Buat Proyek
                </a>
              </div>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
          <div class="mt-6">
            {{ $projects->withQueryString()->links() }}
          </div>
        @endif
      </div>
    </div>
  </main>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('closed');
    }
  </script>
</body>
</html>

