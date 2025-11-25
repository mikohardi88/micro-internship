<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ isset($isEdit) && $isEdit ? 'Edit Proyek - Vinix Micro Internship' : 'Buat Proyek Baru - Vinix Micro Internship' }}</title>
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
      <a href="{{ route('company.projects.create') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('company.projects.create') || request()->routeIs('company.projects.edit') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <i class="fas fa-plus w-5"></i>
        <span class="nav-text">{{ isset($isEdit) && $isEdit ? 'Edit Proyek' : 'Buat Proyek' }}</span>
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
    <div class="max-w-4xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
          {{ isset($isEdit) && $isEdit ? 'Edit Proyek: ' . $project->title : 'Buat Proyek Baru' }}
        </h1>
        <a href="{{ route('company.projects.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
          Kembali
        </a>
      </div>

      <!-- Form Pembuatan/Edit Proyek -->
      <div class="bg-white p-8 rounded-xl shadow-sm border">
        <form method="POST" action="{{ isset($isEdit) && $isEdit ? $action : route('company.projects.store') }}" enctype="multipart/form-data">
          {{ isset($isEdit) && $isEdit ? method_field('PUT') : '' }}
          @csrf

          <div class="mb-6">
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul Proyek *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title ?? '') }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            @error('title')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi *</label>
            <textarea id="description" name="description" rows="6" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description', $project->description ?? '') }}</textarea>
            @error('description')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="duration_weeks" class="block text-gray-700 font-medium mb-2">Durasi (minggu) *</label>
              <select id="duration_weeks" name="duration_weeks" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="" disabled {{ empty(old('duration_weeks', $project->duration_weeks ?? '')) ? 'selected' : '' }}>Pilih durasi</option>
                <option value="1" {{ old('duration_weeks', $project->duration_weeks ?? '') == 1 ? 'selected' : '' }}>1 minggu</option>
                <option value="2" {{ old('duration_weeks', $project->duration_weeks ?? '') == 2 ? 'selected' : '' }}>2 minggu</option>
                <option value="3" {{ old('duration_weeks', $project->duration_weeks ?? '') == 3 ? 'selected' : '' }}>3 minggu</option>
                <option value="4" {{ old('duration_weeks', $project->duration_weeks ?? '') == 4 ? 'selected' : '' }}>4 minggu</option>
                <option value="5" {{ old('duration_weeks', $project->duration_weeks ?? '') == 5 ? 'selected' : '' }}>5 minggu</option>
                <option value="6" {{ old('duration_weeks', $project->duration_weeks ?? '') == 6 ? 'selected' : '' }}>6 minggu</option>
                <option value="7" {{ old('duration_weeks', $project->duration_weeks ?? '') == 7 ? 'selected' : '' }}>7 minggu</option>
                <option value="8" {{ old('duration_weeks', $project->duration_weeks ?? '') == 8 ? 'selected' : '' }}>8 minggu</option>
                <option value="9" {{ old('duration_weeks', $project->duration_weeks ?? '') == 9 ? 'selected' : '' }}>9 minggu</option>
                <option value="10" {{ old('duration_weeks', $project->duration_weeks ?? '') == 10 ? 'selected' : '' }}>10 minggu</option>
                <option value="11" {{ old('duration_weeks', $project->duration_weeks ?? '') == 11 ? 'selected' : '' }}>11 minggu</option>
                <option value="12" {{ old('duration_weeks', $project->duration_weeks ?? '') == 12 ? 'selected' : '' }}>12 minggu</option>
              </select>
              @error('duration_weeks')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="category" class="block text-gray-700 font-medium mb-2">Kategori *</label>
              <select id="category" name="category" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="" disabled {{ empty(old('category', $project->category ?? '')) ? 'selected' : '' }}>Pilih kategori</option>
                <option value="design" {{ old('category', $project->category ?? '') == 'design' ? 'selected' : '' }}>Desain</option>
                <option value="development" {{ old('category', $project->category ?? '') == 'development' ? 'selected' : '' }}>Pengembangan</option>
                <option value="research" {{ old('category', $project->category ?? '') == 'research' ? 'selected' : '' }}>Riset</option>
                <option value="content" {{ old('category', $project->category ?? '') == 'content' ? 'selected' : '' }}>Konten</option>
                <option value="marketing" {{ old('category', $project->category ?? '') == 'marketing' ? 'selected' : '' }}>Pemasaran</option>
              </select>
              @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="mb-6">
            <label for="skills" class="block text-gray-700 font-medium mb-2">Skill yang Dibutuhkan *</label>
            <input
              type="text"
              id="skills"
              name="skills"
              value="{{ old('skills', $project->skills_text ?? ($project->skills?->pluck('name')->implode(',') ?? '')) }}"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
              placeholder="Contoh: Laravel, Tailwind, UI/UX"
              required
            >
            <p class="text-gray-500 text-sm mt-1">Pisahkan beberapa skill dengan koma. Minimal satu skill.</p>
            @error('skills')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="max_applicants" class="block text-gray-700 font-medium mb-2">Jumlah Kandidat Maksimal</label>
            <input type="number" id="max_applicants" name="max_applicants" value="{{ old('max_applicants', $project->max_applicants ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   min="1" placeholder="Contoh: 1 (default)">
            @error('max_applicants')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="budget" class="block text-gray-700 font-medium mb-2">Anggaran (IDR)</label>
            <input type="number" id="budget" name="budget" value="{{ old('budget', $project->budget ?? '') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   min="0" placeholder="Contoh: 1000000">
            @error('budget')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="start_date" class="block text-gray-700 font-medium mb-2">Tanggal Mulai</label>
              <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d') ?? '') }}"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
              @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="end_date" class="block text-gray-700 font-medium mb-2">Tanggal Selesai</label>
              <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d') ?? '') }}"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
              @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="mb-6">
            <label for="requirements" class="block text-gray-700 font-medium mb-2">Persyaratan</label>
            <textarea id="requirements" name="requirements" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('requirements', $project->requirements ?? '') }}</textarea>
            @error('requirements')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="deliverables" class="block text-gray-700 font-medium mb-2">Milestone/Deliverable *</label>
            <textarea id="deliverables" name="deliverables" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      placeholder="Deskripsikan apa yang akan dihasilkan dari proyek ini">{{ old('deliverables', $project->deliverables ?? '') }}</textarea>
            @error('deliverables')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-6">
            <label for="brief" class="block text-gray-700 font-medium mb-2">Brief Proyek</label>
            <input type="file" id="brief" name="brief"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <p class="text-gray-500 text-sm mt-1">Format file: PDF, DOCX, atau DOC. Maksimal 10MB</p>

            @if($project && $project->brief_path)
              <div class="mt-2">
                <p class="text-gray-600">File saat ini:
                  <a href="{{ route('company.projects.download-brief', $project) }}"
                     class="text-blue-500 hover:underline"
                     target="_blank">
                    {{ basename($project->brief_path) }}
                  </a>
                </p>
                <label class="flex items-center mt-2">
                  <input type="checkbox" name="remove_brief" value="1" class="rounded text-purple-600">
                  <span class="ml-2 text-gray-700">Hapus file brief saat ini</span>
                </label>
              </div>
            @endif

            @error('brief')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex justify-end space-x-4">
            <a href="{{ route('company.projects.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
              Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-md transition font-medium">
              {{ isset($isEdit) && $isEdit ? 'Perbarui Proyek' : 'Simpan Proyek' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('closed');
    }

    // Input skill menggunakan select multiple, tidak perlu JavaScript khusus
  </script>
</body>
</html>