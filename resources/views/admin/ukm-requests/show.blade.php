<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Permintaan UKM - Vinix Micro Internship</title>
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
          <a href="{{ route('admin.ukm-requests.index') }}" class="text-purple-600 hover:text-purple-800">Permintaan UKM</a> / Detail Permintaan
        </h1>
        <div class="flex gap-3">
          <a href="{{ route('admin.ukm-requests.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg font-medium hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
          </a>
          <a href="{{ route('admin.ukm-requests.edit', $ukmRequest->id) }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
            <i class="fas fa-edit mr-2"></i>Edit
          </a>
        </div>
      </div>
    </div>

    <!-- REQUEST DETAILS -->
    <div class="bg-white p-8 rounded-xl shadow-sm border">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="text-sm font-medium text-gray-500 mb-4">Informasi Umum</h3>

          <div class="space-y-4">
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">ID:</span>
              <span class="text-gray-900">#{{ $ukmRequest->id }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Nama UKM:</span>
              <span class="text-gray-900">{{ $ukmRequest->user->name ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Email UKM:</span>
              <span class="text-gray-900">{{ $ukmRequest->user->email ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Perusahaan:</span>
              <span class="text-gray-900">{{ $ukmRequest->company->name ?? 'Tidak terkait dengan perusahaan' }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Jenis Permintaan:</span>
              <span>
                @switch($ukmRequest->request_type)
                  @case('registration')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                      Pendaftaran
                    </span>
                    @break
                  @case('verification')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                      Verifikasi
                    </span>
                    @break
                  @case('technical_help')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                      Bantuan Teknis
                    </span>
                    @break
                  @case('training')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Pelatihan
                    </span>
                    @break
                  @case('project')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                      Proyek
                    </span>
                    @break
                  @case('marketing')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                      Pemasaran
                    </span>
                    @break
                  @default
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                      Lainnya
                    </span>
                @endswitch
              </span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Judul:</span>
              <span class="text-gray-900">{{ $ukmRequest->title }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Status:</span>
              <span>
                @switch($ukmRequest->status)
                  @case('pending')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                      Pending
                    </span>
                    @break
                  @case('in_progress')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                      Dalam Proses
                    </span>
                    @break
                  @case('resolved')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Selesai
                    </span>
                    @break
                  @case('rejected')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                      Ditolak
                    </span>
                    @break
                @endswitch
              </span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Tanggal Dibuat:</span>
              <span class="text-gray-900">{{ $ukmRequest->created_at->format('d M Y H:i:s') }}</span>
            </div>
            <div class="flex justify-between border-b pb-2">
              <span class="font-medium text-gray-600">Tanggal Diselesaikan:</span>
              <span class="text-gray-900">{{ $ukmRequest->resolved_at ? $ukmRequest->resolved_at->format('d M Y H:i:s') : 'Belum diselesaikan' }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-medium text-gray-600">Admin yang Menyelesaikan:</span>
              <span class="text-gray-900">{{ $ukmRequest->resolver ? $ukmRequest->resolver->name : 'Belum diselesaikan' }}</span>
            </div>
          </div>
        </div>

        <div class="space-y-6">
          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-3">Deskripsi Permintaan</h3>
            <div class="bg-white p-4 rounded border">
              {{ $ukmRequest->description }}
            </div>
          </div>

          @if($ukmRequest->admin_notes)
          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-3">Catatan Admin</h3>
            <div class="bg-white p-4 rounded border">
              {{ $ukmRequest->admin_notes }}
            </div>
          </div>
          @endif
        </div>
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