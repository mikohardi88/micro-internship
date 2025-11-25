<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifikasi - Vinix Micro Internship</title>
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
      <!-- PAGE HEADER -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Notifikasi</h1>

        @if($notifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Tandai semua sudah dibaca
                </button>
            </form>
        @endif
      </div>

      @if($notifications->count() > 0)
          <div class="bg-white rounded-lg shadow overflow-hidden border">
              @foreach($notifications as $notification)
                  <div class="border-b border-gray-200 last:border-b-0">
                      <div class="p-4 flex items-start">
                          <div class="flex-1">
                              <div class="flex justify-between">
                                  <h3 class="font-medium text-gray-900">
                                      {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                  </h3>
                                  <span class="text-sm text-gray-500">
                                      {{ $notification->created_at->diffForHumans() }}
                                  </span>
                              </div>

                              <p class="mt-1 text-gray-600">
                                  {{ $notification->data['message'] ?? $notification->data['body'] ?? 'Tidak ada pesan' }}
                              </p>

                              @if(!is_null($notification->read_at))
                                  <span class="inline-block mt-2 px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                      Sudah dibaca
                                  </span>
                              @else
                                  <span class="inline-block mt-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">
                                      Belum dibaca
                                  </span>
                              @endif
                          </div>

                          <div class="ml-4 flex space-x-2">
                              @if(is_null($notification->read_at))
                                  <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                                      @csrf
                                      <button type="submit" class="text-blue-500 hover:text-blue-700">
                                          <i class="fas fa-check"></i> Tandai
                                      </button>
                                  </form>
                              @endif

                              <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="text-red-500 hover:text-red-700 ml-2">
                                      <i class="fas fa-trash"></i> Hapus
                                  </button>
                              </form>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>

          <div class="mt-6">
              {{ $notifications->links() }}
          </div>
      @else
          <div class="bg-white rounded-lg shadow p-8 text-center border">
              <i class="fas fa-bell text-5xl text-gray-300 mb-4"></i>
              <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak ada notifikasi</h3>
              <p class="text-gray-500">Anda tidak memiliki notifikasi saat ini.</p>
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