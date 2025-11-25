<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Perusahaan - Vinix Micro Internship</title>
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
    <!-- PAGE HEADER -->
    <div class="mb-8">
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
          <a href="{{ route('admin.companies.index') }}" class="text-purple-600 hover:text-purple-800">Perusahaan</a> / {{ $company->name }}
        </h1>
        <div class="flex gap-3">
          <a href="{{ route('admin.companies.edit', $company) }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700">
            <i class="fas fa-edit mr-2"></i>Edit
          </a>
          <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
              <i class="fas fa-trash mr-2"></i>Delete
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- COMPANY DETAILS -->
    <div class="bg-white p-8 rounded-xl shadow-sm border">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
          <h3 class="text-sm font-medium text-gray-500 mb-1">Nama Perusahaan</h3>
          <p class="text-gray-900 text-lg font-medium">{{ $company->name }}</p>
        </div>
        <div>
          <h3 class="text-sm font-medium text-gray-500 mb-1">Pemilik</h3>
          <p class="text-gray-900">{{ $company->user->name ?? 'N/A' }}</p>
          <p class="text-sm text-gray-500">{{ $company->user->email ?? '' }}</p>
        </div>
        @if($company->industry)
          <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Industri</h3>
            <p class="text-gray-900">{{ $company->industry }}</p>
          </div>
        @endif
        @if($company->size)
          <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Ukuran</h3>
            <p class="text-gray-900">{{ $company->size }}</p>
          </div>
        @endif
        @if($company->website)
          <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Website</h3>
            <a href="{{ $company->website }}" target="_blank" class="text-purple-600 hover:text-purple-800">{{ $company->website }}</a>
          </div>
        @endif
      </div>

      @if($company->description)
        <div class="mb-8 pt-6 border-t border-gray-200">
          <h3 class="text-sm font-medium text-gray-500 mb-3">Deskripsi</h3>
          <p class="text-gray-900 whitespace-pre-wrap">{{ $company->description }}</p>
        </div>
      @endif

      <div class="pt-6 border-t border-gray-200">
        <h3 class="text-sm font-medium text-gray-500 mb-3">Proyek</h3>
        <p class="text-gray-900">{{ $company->projects->count() }} proyek</p>
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

