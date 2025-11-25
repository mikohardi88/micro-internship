<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Proyek - Vinix Micro Internship</title>
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
          <i class="fas fa-arrow-left mr-2"></i>Daftar Proyek
        </a>
      </div>

      <!-- PAGE HEADER -->
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Proyek</h1>
        <p class="text-gray-600">Kelola dan tinjau semua proyek yang ada dalam sistem</p>
      </div>

      <!-- TABS -->
      <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-8">
            <a href="{{ route('admin.projects.index', ['status' => 'pending']) }}" class="{{ $status === 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
              Menunggu Persetujuan
              <span class="bg-gray-100 text-gray-900 ml-2 py-0.5 px-2 rounded-full text-xs font-medium">
                {{ \App\Models\Project::where('status', 'pending')->count() }}
              </span>
            </a>
            <a href="{{ route('admin.projects.index', ['status' => 'approved']) }}" class="{{ $status === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
              Disetujui
            </a>
            <a href="{{ route('admin.projects.index', ['status' => 'rejected']) }}" class="{{ $status === 'rejected' ? 'border-red-500 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
              Ditolak
            </a>
          </nav>
        </div>
      </div>

      <!-- PROJECT LIST -->
      <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flow-root">
          <ul class="-mb-8">
            @forelse($projects as $project)
              <li>
                <div class="relative pb-8">
                  <div class="relative flex items-start space-x-4">
                    <div class="min-w-0 flex-1">
                      <div class="block focus:outline-none">
                        <div class="flex items-center justify-between">
                          <div class="truncate">
                            <p class="text-lg font-medium text-gray-900">{{ $project->title }}</p>
                          </div>
                          <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                              @if($project->status === 'pending') bg-yellow-100 text-yellow-800 
                              @elseif($project->status === 'approved') bg-green-100 text-green-800 
                              @elseif($project->status === 'rejected') bg-red-100 text-red-800 
                              @elseif($project->status === 'open') bg-blue-100 text-blue-800 
                              @elseif($project->status === 'in_progress') bg-indigo-100 text-indigo-800 
                              @else bg-gray-100 text-gray-800 @endif">
                              {{ str_replace('_', ' ', ucfirst($project->status)) }}
                            </span>
                          </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Oleh: {{ $project->company->name }}</p>
                        <div class="mt-2 flex">
                          <a href="{{ route('admin.projects.show', $project) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Tinjau
                          </a>
                          
                          @if($project->status === 'pending')
                            <form action="{{ route('admin.projects.approve', $project) }}" method="POST" class="ml-2 inline">
                              @csrf
                              <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Setujui
                              </button>
                            </form>
                            <form action="{{ route('admin.projects.reject', $project) }}" method="POST" class="ml-2 inline">
                              @csrf
                              <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                Tolak
                              </button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            @empty
              <div class="text-center py-12">
                <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada proyek</h3>
                <p class="mt-1 text-gray-500">
                  {{ $status === 'pending' ? 'Tidak ada proyek menunggu persetujuan.' : 'Tidak ada proyek ditemukan dalam kategori ini.' }}
                </p>
              </div>
            @endforelse
          </ul>
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
          <div class="mt-8">
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