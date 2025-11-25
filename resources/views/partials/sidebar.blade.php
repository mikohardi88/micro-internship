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
      <i class="fas @if(auth()->user()->hasRole('admin')) fa-tachometer-alt @else fa-home @endif w-5"></i>
      <span class="nav-text">@if(auth()->user()->hasRole('admin')) Dashboard Admin @else Dashboard @endif</span>
    </a>

    @role('student')
    <a href="{{ route('student.projects.browse') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('student.projects.browse') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-briefcase w-5"></i>
      <span class="nav-text">Proyek Tersedia</span>
    </a>
    <a href="{{ route('student.placements.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('student.placements.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-tasks w-5"></i>
      <span class="nav-text">Internship Saya</span>
    </a>
    <a href="{{ route('student.applications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('student.applications.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-file-alt w-5"></i>
      <span class="nav-text">Lamaran Saya</span>
    </a>
    <a href="{{ route('student.certificates.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('student.certificates.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-certificate w-5"></i>
      <span class="nav-text">Sertifikat</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-user w-5"></i>
      <span class="nav-text">Profil</span>
    </a>
    @endrole

    @role('company')
    <a href="{{ route('company.projects.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('company.projects.*') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-briefcase w-5"></i>
      <span class="nav-text">Proyek Saya</span>
    </a>
    <a href="{{ route('company.projects.create') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('company.projects.create') || request()->routeIs('company.projects.edit') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-plus w-5"></i>
      <span class="nav-text">Buat Proyek</span>
    </a>
    <a href="{{ route('company.applications.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('company.applications.index') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
      <i class="fas fa-file-alt w-5"></i>
      <span class="nav-text">Aplikasi Masuk</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-purple-100 text-purple-700 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
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