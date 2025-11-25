<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Jelajahi Proyek - Vinix Micro Internship</title>
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
      <a href="{{ route('student.projects.browse') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-purple-100 text-purple-700 font-medium">
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
      <a href="{{ route('admin.ukm-requests.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 text-gray-700">
        <i class="fas fa-comments w-5"></i>
        <span class="nav-text">Permintaan UKM</span>
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
    <div class="max-w-6xl mx-auto">
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
      
      <!-- PAGE HEADER -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Jelajahi Proyek</h1>
        <p class="text-gray-600">{{ $projects->total() }} proyek tersedia</p>
      </div>

      <!-- FILTER FORM -->
      <form method="GET" action="{{ route('student.projects.browse') }}" class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <input type="text" id="q" name="q" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="{{ request('q') }}" placeholder="Judul atau deskripsi proyek" />
          </div>
          <div>
            <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-1">Durasi (minggu)</label>
            <select id="duration_weeks" name="duration_weeks" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
              <option value="">Beberapa minggu</option>
              @for($i=1;$i<=4;$i++)
                <option value="{{ $i }}" @selected(request('duration_weeks')==$i)>{{ $i }} minggu</option>
              @endfor
            </select>
          </div>
          <div class="flex items-end">
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
              Filter
            </button>
          </div>
        </div>
      </form>

      <!-- PROJECT LIST -->
      <div class="divide-y divide-gray-200 mb-8">
        @forelse($projects as $project)
          <div class="py-6 flex flex-col md:flex-row md:items-start justify-between bg-white rounded-xl shadow-sm border p-6 mb-4">
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-800">{{ $project->title }}</h3>
              <p class="text-sm text-gray-600 mt-2 line-clamp-3">{{ $project->description }}</p>
              <div class="mt-3 text-xs text-gray-500">
                Durasi: {{ $project->duration_weeks }} minggu · Pelamar: {{ $project->applications_count }}/{{ $project->max_applicants }}
              </div>
            </div>
            <div class="mt-4 md:mt-0 md:ml-4">
              @if($project->status === 'open')
                  @if($project->applications_count < $project->max_applicants)
                      <a href="{{ route('student.projects.apply.form', $project) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Pilih & Tempatkan
                      </a>
                  @else
                      <span class="px-4 py-2 bg-gray-400 text-white rounded-lg">Penuh</span>
                  @endif
              @else
                  <a href="{{ route('student.projects.apply.form', $project) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Pilih & Tempatkan
                  </a>
              @endif
            </div>
          </div>
        @empty
          <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
            <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">Tidak ditemukan proyek.</p>
          </div>
        @endforelse
      </div>

      <div class="mt-6">
          {{ $projects->withQueryString()->links() }}
      </div>

      <!-- APPROVED PROJECTS SECTION -->
      @php
          $approvedProjects = \App\Models\Project::where('status', 'approved')->withCount('applications')->latest()->take(6)->get();
      @endphp
      @if($approvedProjects->count() > 0)
      <div class="mt-12">
          <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
              <span class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-2 rounded-lg mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                  </svg>
              </span>
              Proye Yang tersedia 
          </h2>

          <div class="grid md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
              @foreach($approvedProjects as $project)
              <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                  <div class="flex justify-between items-start mb-4">
                      <div class="flex-1">
                          <h3 class="font-bold text-lg text-gray-800 mb-2 flex items-center">
                              <span class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-1 rounded mr-2">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                  </svg>
                              </span>
                              {{ $project->title }}
                          </h3>
                          <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $project->description }}</p>
                      </div>

                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                          </svg>
                          Disetujui
                      </span>
                  </div>

                  <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-4">
                      <span class="flex items-center bg-gray-100 px-2.5 py-1 rounded-full">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          Durasi: {{ $project->duration_weeks }} minggu
                      </span>
                      <span class="flex items-center bg-gray-100 px-2.5 py-1 rounded-full">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg>
                          {{ $project->applications_count }}/{{ $project->max_applicants }}
                      </span>
                  </div>

                  <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                      <a href="{{ route('student.projects.apply.form', $project) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
                          Lihat Detail
                      </a>
                      @if($project->status === 'open')
                          @if($project->applications_count < $project->max_applicants)
                              <a href="{{ route('student.projects.apply.form', $project) }}" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  Pilih & Tempatkan
                              </a>
                          @else
                              <span class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                  </svg>
                                  Penuh
                              </span>
                          @endif
                      @else
                          <a href="#" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                              Daftar Sekarang
                          </a>
                      @endif
                  </div>
              </div>
              @endforeach
          </div>

          <div class="text-center mt-8">
              <a href="{{ route('student.projects.browse') }}" class="inline-flex items-center bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                  Lihat Semua Proyek
              </a>
          </div>
      </div>
      @endif
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