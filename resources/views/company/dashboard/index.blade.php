<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Perusahaan - Vinix Micro Internship</title>
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
      <a href="{{ route('company.applications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-users w-5"></i>
        <span class="nav-text">Aplikasi Masuk</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-user w-5"></i>
        <span class="nav-text">Profil</span>
      </a>
      @endrole

      @role('admin')
      <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-users w-5"></i>
        <span class="nav-text">Pengguna</span>
      </a>
      <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-user w-5"></i>
        <span class="nav-text">Profil</span>
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
      <h1 class="text-4xl font-bold mb-4">Dashboard Perusahaan</h1>
      <p class="text-lg mb-6 max-w-2xl">Kelola proyek mikro magang Anda dan pantau aplikasi peserta secara real-time</p>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('company.projects.index') }}" class="bg-white text-purple-700 px-6 py-3 rounded-lg font-semibold hover:shadow-md transition">Lihat Proyek Saya</a>
        <a href="{{ route('company.projects.create') }}" class="border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-700 transition">Buat Proyek Baru</a>
      </div>
    </section>

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            {{ session('warning') }}
            <a href="{{ route('profile.edit') }}" class="ml-4 text-yellow-800 underline">Lengkapi Profil</a>
        </div>
    @endif

    <!-- COMPANY-SPECIFIC DASHBOARD -->
    <section id="dashboard" class="grid md:grid-cols-3 gap-6">
      @php
          $company = \App\Models\Company::where('user_id', Auth::id())->first();
          $projects = $company ? \App\Models\Project::where('company_id', $company->id)->get() : collect();
          $pendingProjects = $projects->where('status', 'pending')->count();
          $openProjects = $projects->where('status', 'open')->count();
          $totalApplications = $company ? \App\Models\ProjectApplication::whereHas('project', function($q) use ($company) {
              $q->where('company_id', $company->id);
          })->count() : 0;
          $activePlacements = $company ? \App\Models\Placement::whereHas('project', function($q) use ($company) {
              $q->where('company_id', $company->id);
          })->whereIn('status', ['in_progress'])->count() : 0;
      @endphp
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Proyek Saya</h3>
          <span class="text-2xl font-bold text-purple-600">{{ $projects->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Jumlah proyek yang telah Anda buat</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Proyek Terbuka</h3>
          <span class="text-2xl font-bold text-blue-600">{{ $openProjects }}</span>
        </div>
        <p class="text-sm text-gray-600">Proyek yang sedang mencari peserta</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Aplikasi Masuk</h3>
          <span class="text-2xl font-bold text-green-600">{{ $totalApplications }}</span>
        </div>
          <p class="text-sm text-gray-600">Aplikasi yang masuk ke proyek Anda</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Penempatan Aktif</h3>
          <span class="text-2xl font-bold text-yellow-600">{{ $activePlacements }}</span>
        </div>
        <p class="text-sm text-gray-600">Peserta yang sedang mengerjakan proyek Anda</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Proyek Pending</h3>
          <span class="text-2xl font-bold text-orange-600">{{ $pendingProjects }}</span>
        </div>
        <p class="text-sm text-gray-600">Proyek menunggu persetujuan admin</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">UMKM</h3>
          <span class="text-2xl font-bold text-indigo-600">{{ $company ? $company->name : 'Belum Terdaftar' }}</span>
        </div>
        <p class="text-sm text-gray-600">Nama perusahaan/UMKM Anda</p>
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