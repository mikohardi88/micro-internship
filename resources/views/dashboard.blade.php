<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Vinix Micro Internship</title>
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
      @role('admin')
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
        <i class="fas fa-tachometer-alt w-5"></i>
        <span class="nav-text">Dashboard Admin</span>
      </a>
      @else
      <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
        <i class="fas fa-home w-5"></i>
        <span class="nav-text">Dashboard</span>
      </a>
      @endrole

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
      <a href="{{ route('admin.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.projects.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <i class="fas fa-briefcase w-5"></i>
        <span class="nav-text">Proyek</span>
      </a>
      <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <i class="fas fa-users w-5"></i>
        <span class="nav-text">Pengguna</span>
      </a>
      <a href="{{ route('admin.companies.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.companies.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <i class="fas fa-building w-5"></i>
        <span class="nav-text">Perusahaan</span>
      </a>
      <a href="{{ route('admin.skills.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.skills.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <i class="fas fa-tags w-5"></i>
        <span class="nav-text">Kemampuan</span>
      </a>
      <a href="{{ route('admin.ukm-requests.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.ukm-requests.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
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
      <h1 class="text-4xl font-bold mb-4">Dashboard</h1>
      <p class="text-lg mb-6 max-w-2xl">Selamat datang di platform Vinix Micro Internship</p>
      <div class="flex flex-wrap gap-3">
        <a href="{{ route('profile.edit') }}" class="bg-white text-purple-700 px-6 py-3 rounded-lg font-semibold hover:shadow-md transition">Edit Profil</a>
        <a href="#" class="border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-700 transition">Lihat Panduan</a>
      </div>
    </section>

    <!-- WELCOME SECTION -->
    <section class="mb-10">
      <div class="bg-white p-8 rounded-xl shadow-sm border text-center">
        <i class="fas fa-user-circle text-6xl text-gray-300 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600 mb-6">Akun Anda belum ditetapkan ke role tertentu. Silakan hubungi administrator untuk mengatur role Anda.</p>
        
        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
          <div class="bg-gray-50 p-6 rounded-lg">
            <i class="fas fa-info-circle text-3xl text-blue-500 mb-3"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Perlu Bantuan?</h3>
            <p class="text-gray-600">Hubungi administrator sistem untuk mendapatkan role yang sesuai akun Anda.</p>
          </div>
          
          <div class="bg-gray-50 p-6 rounded-lg">
            <i class="fas fa-user-edit text-3xl text-green-500 mb-3"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Perbarui Profil</h3>
            <p class="text-gray-600">Lengkapi informasi profil Anda untuk pengalaman yang lebih baik.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- QUICK ACTION SECTION -->
    <section class="mb-10">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
      <div class="grid md:grid-cols-4 gap-6">
        <a href="{{ route('profile.edit') }}" class="bg-white p-6 rounded-xl shadow-sm border text-center hover:shadow-md transition">
          <i class="fas fa-user text-2xl text-purple-600 mb-3"></i>
          <h3 class="font-semibold text-gray-800">Profil</h3>
          <p class="text-sm text-gray-600">Perbarui informasi pribadi</p>
        </a>
        
        <a href="#" class="bg-white p-6 rounded-xl shadow-sm border text-center hover:shadow-md transition">
          <i class="fas fa-cog text-2xl text-blue-600 mb-3"></i>
          <h3 class="font-semibold text-gray-800">Pengaturan</h3>
          <p class="text-sm text-gray-600">Ubah preferensi pengguna</p>
        </a>
        
        <a href="#" class="bg-white p-6 rounded-xl shadow-sm border text-center hover:shadow-md transition">
          <i class="fas fa-question-circle text-2xl text-yellow-600 mb-3"></i>
          <h3 class="font-semibold text-gray-800">Bantuan</h3>
          <p class="text-sm text-gray-600">Dapatkan bantuan sistem</p>
        </a>
        
        <a href="#" class="bg-white p-6 rounded-xl shadow-sm border text-center hover:shadow-md transition">
          <i class="fas fa-shield-alt text-2xl text-red-600 mb-3"></i>
          <h3 class="font-semibold text-gray-800">Keamanan</h3>
          <p class="text-sm text-gray-600">Ubah kata sandi</p>
        </a>
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