<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin - Vinix Micro Internship</title>
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
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
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
      <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek</span>
      </a>
      <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-users w-5"></i>
        <span class="nav-text">Pengguna</span>
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

    <!-- HERO SECTION -->
    <section class="gradient-bg text-white rounded-2xl p-8 mb-10 shadow-lg">
      <h1 class="text-4xl font-bold mb-4">Dashboard Admin</h1>
      <p class="text-lg mb-6 max-w-2xl">Verifikasi dan setujui proyek dari UKM</p>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.projects.index', ['status' => 'pending']) }}" class="bg-white text-purple-700 px-6 py-3 rounded-lg font-semibold hover:shadow-md transition">
          Proyek Menunggu Persetujuan ({{ \App\Models\Project::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('admin.projects.index') }}" class="border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-700 transition">Kelola Semua Proyek</a>
      </div>
    </section>

    <!-- PENDING PROJECTS SECTION -->
    <section class="mb-10">
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Proyek Menunggu Persetujuan</h2>
          <a href="{{ route('admin.projects.index', ['status' => 'pending']) }}" class="text-blue-500 hover:text-blue-700 font-medium">
            Lihat semua &rarr;
          </a>
        </div>

        @forelse(\App\Models\Project::where('status', 'pending')->latest()->limit(10)->get() as $project)
          <div class="flex flex-col md:flex-row md:items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
            <div class="mb-3 md:mb-0 md:mr-4 flex-1">
              <h4 class="font-medium text-gray-900">{{ $project->title }}</h4>
              <p class="text-sm text-gray-500">Oleh: {{ $project->company->name ?? 'Perusahaan Tidak Ditemukan' }}</p>
              <p class="text-sm text-gray-500 mt-1">Deskripsi: {{ Str::limit(strip_tags($project->description), 100) }}</p>
            </div>
            <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
              <a href="{{ route('admin.projects.show', $project) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center">
                Tinjau
              </a>
            </div>
          </div>
        @empty
          <div class="text-center py-8">
            <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900">Tidak ada proyek menunggu</h3>
            <p class="text-gray-500 mt-1">Semua proyek sudah ditinjau</p>
          </div>
        @endforelse
      </div>
    </section>

  </main>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('closed');
    }
  </script>
</body>
</html>