<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Vinix Micro Internship</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-lg p-8 mb-6 text-white">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Verifikasi Email</h1>
                    <p class="text-blue-100 text-lg">Periksa email Anda untuk tautan verifikasi</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-xl p-8">
            <div class="mb-6 text-blue-800 text-lg font-medium">
                {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirim. Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded-lg mb-6 font-medium">
                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                </div>
            @endif

            <div class="space-y-6">
                <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:ring-4 focus:ring-blue-300 focus:outline-none shadow-lg">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-bold underline">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
