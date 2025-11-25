<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Selamat Datang - Vinix Micro Internship</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .hero-gradient { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
  </style>
</head>
<body class="bg-gray-50 font-sans">

  <!-- NAVBAR -->
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0 flex items-center">
            <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold">V</div>
            <span class="ml-3 text-xl font-bold text-gray-800">Vinix</span>
          </div>
        </div>
        
        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
          <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 px-1 pt-1 text-sm font-medium">
            Dashboard
          </a>
        </div>
        
        <div class="flex items-center">
          @if (Route::has('login'))
            <div class="flex space-x-4">
              @auth
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                  Dashboard
                </a>
              @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">
                  Masuk
                </a>
                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                    Daftar
                  </a>
                @endif
              @endauth
            </div>
          @endif
        </div>
      </div>
    </div>
  </nav>

  <!-- HERO SECTION -->
  <section class="hero-gradient text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">Platform Magang Mikro</h1>
        <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">Temukan, kerjakan, dan kembangkan proyek magang mikro dengan UKM lokal</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          @if (Route::has('login'))
            @auth
              <a href="{{ route('dashboard') }}" class="bg-white text-purple-700 px-8 py-3 rounded-lg font-semibold text-lg hover:shadow-lg transition">
                Ke Dashboard
              </a>
            @else
              <a href="{{ route('login') }}" class="bg-white text-purple-700 px-8 py-3 rounded-lg font-semibold text-lg hover:shadow-lg transition">
                Masuk
              </a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-white hover:text-purple-700 transition">
                  Daftar Sekarang
                </a>
              @endif
            @endauth
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Manfaat Platform Ini</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Platform kami menghubungkan mahasiswa dengan UMKM untuk proyek magang mikro</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-md text-center">
          <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-briefcase text-purple-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Proyek Nyata</h3>
          <p class="text-gray-600">Kerjakan proyek nyata dari UMKM lokal untuk pengalaman kerja langsung</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md text-center">
          <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-graduation-cap text-blue-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Kembangkan Skill</h3>
          <p class="text-gray-600">Bangun portofolio dan tingkatkan skill teknis serta profesional</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md text-center">
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-handshake text-green-600 text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-3">Koneksi Nyata</h3>
          <p class="text-gray-600">Buat koneksi profesional dengan pemilik UMKM dan mentor industri</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS SECTION -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Bagaimana Cara Kerjanya</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ikuti langkah-langkah sederhana untuk memulai pengalaman magang mikro</p>
      </div>

      <div class="grid md:grid-cols-4 gap-6">
        <div class="text-center">
          <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">1</div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Daftar</h3>
          <p class="text-gray-600">Buat akun dan lengkapi profil Anda</p>
        </div>
        <div class="text-center">
          <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">2</div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Jelajahi</h3>
          <p class="text-gray-600">Telusuri proyek yang tersedia</p>
        </div>
        <div class="text-center">
          <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">3</div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Lamar</h3>
          <p class="text-gray-600">Ajukan lamaran ke proyek yang Anda minati</p>
        </div>
        <div class="text-center">
          <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mx-auto mb-4">4</div>
          <h3 class="text-lg font-bold text-gray-800 mb-2">Kerjakan</h3>
          <p class="text-gray-600">Selesaikan proyek dan dapatkan sertifikat</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <div class="flex items-center justify-center mb-4">
          <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold">V</div>
          <span class="ml-3 text-xl font-bold">Vinix</span>
        </div>
        <p class="text-gray-400">Platform Mikro Magang untuk UMKM dan Mahasiswa</p>
      </div>
    </div>
  </footer>

</body>
</html>