<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Mahasiswa - Vinix Micro Internship</title>
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
      <h1 class="text-4xl font-bold mb-4">Dashboard Mahasiswa</h1>
      <p class="text-lg mb-6 max-w-2xl">Temukan proyek mikro magang, kembangkan skill, dan bangun portofolio Anda</p>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('student.projects.browse') }}" class="bg-white text-purple-700 px-6 py-3 rounded-lg font-semibold hover:shadow-md transition">Cari Proyek</a>
        <a href="{{ route('student.placements.index') }}" class="border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-700 transition">Lihat Internship Saya</a>
      </div>
    </section>

    <!-- STUDENT-SPECIFIC DASHBOARD -->
    <section id="dashboard" class="grid md:grid-cols-3 gap-6">
      @php
          $applications = \App\Models\ProjectApplication::where('user_id', Auth::id())->get();
          $placements = \App\Models\Placement::where('user_id', Auth::id())->get();
          $deliverables = \App\Models\Deliverable::whereHas('placement', fn($q) => $q->where('user_id', Auth::id()))->get();
          $certificates = \App\Models\Certificate::where('user_id', Auth::id())->get();
      @endphp
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Aplikasi Saya</h3>
          <span class="text-2xl font-bold text-purple-600">{{ $applications->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Proyek yang telah Anda ajukan</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Penempatan Aktif</h3>
          <span class="text-2xl font-bold text-blue-600">{{ $placements->whereIn('status', ['in_progress'])->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Proyek internship yang sedang Anda ikuti</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Sertifikat</h3>
          <span class="text-2xl font-bold text-green-600">{{ $certificates->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Sertifikat yang telah Anda peroleh</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Lamaran Diterima</h3>
          <span class="text-2xl font-bold text-indigo-600">{{ $applications->where('status', 'accepted')->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Jumlah lamaran yang diterima</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Penempatan Selesai</h3>
          <span class="text-2xl font-bold text-yellow-600">{{ $placements->where('status', 'completed')->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Jumlah proyek selesai</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-semibold text-gray-800">Proyek Dilamar</h3>
          <span class="text-2xl font-bold text-orange-600">{{ $applications->count() }}</span>
        </div>
        <p class="text-sm text-gray-600">Jumlah proyek yang Anda lamar</p>
      </div>
    </section>

    <!-- RECENT ACTIVITIES -->
    <section class="mt-10">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Aktivitas Terbaru</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <!-- My Applications -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Lamaran Terbaru</h3>
            <a href="{{ route('student.applications.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
              Lihat Semua
            </a>
          </div>
          @forelse(auth()->user()->applications()->with('project')->latest()->limit(5)->get() as $application)
            <div class="flex justify-between items-center border-b border-gray-100 py-3 last:border-b-0">
              <div>
                <h4 class="font-medium text-gray-900">{{ $application->project->title }}</h4>
                <span class="inline-block mt-1 px-2 py-1 text-xs {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }} rounded">
                  {{ ucfirst($application->status) }}
                </span>
              </div>
              <a href="{{ route('student.applications.show', $application) }}" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          @empty
            <p class="text-gray-500 text-center py-4">Anda belum melamar proyek apapun</p>
          @endforelse
        </div>

        <!-- My Placements -->
        <div class="bg-white p-6 rounded-xl shadow-sm border">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-800">Penempatan Saya</h3>
            <a href="{{ route('student.placements.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
              Lihat Semua
            </a>
          </div>
          @forelse(auth()->user()->placements()->with('project')->latest()->limit(5)->get() as $placement)
            <div class="flex justify-between items-center border-b border-gray-100 py-3 last:border-b-0">
              <div>
                <h4 class="font-medium text-gray-900">{{ $placement->project->title }}</h4>
                <span class="inline-block mt-1 px-2 py-1 text-xs {{ $placement->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} rounded">
                  {{ ucfirst($placement->status) }}
                </span>
              </div>
              <a href="{{ route('student.placements.show', $placement) }}" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          @empty
            <p class="text-gray-500 text-center py-4">Anda belum memiliki penempatan</p>
          @endforelse
        </div>
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