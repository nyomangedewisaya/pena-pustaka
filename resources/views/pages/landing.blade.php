<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan Sekolah - Pena Pustaka</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/font/font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
</head>

<body class="text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 md:px-8 h-16 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <div class="flex flex-col">
                    <span class="font-bold text-gray-900 leading-tight">Pena Pustaka</span>
                    <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Perpustakaan
                        Sekolah</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ Auth::user()->role == 'student' ? route('book.catalog') : route('dashboard') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg active:scale-95 transition-all duration-300">
                        Lihat
                    </a>
                    <div class="h-4 w-px bg-gray-300"></div>
                    <span class="text-sm font-bold text-blue-600">Halo, {{ Auth::user()->full_name }}</span>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="grow flex items-center justify-center py-12 px-4">
        <div class="max-w-4xl mx-auto text-center">

            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo"
                class="inline-flex items-center justify-center w-30 h-30 rounded-full mb-6">

            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
                Selamat Datang di <br> Perpustakaan Digital
            </h1>

            <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto leading-relaxed">
                Platform peminjaman buku resmi sekolah. Cari buku pelajaran, novel, atau referensi tugas dengan mudah
                dan cepat.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 text-left max-w-3xl mx-auto">
                <div
                    class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-blue-200 transition-colors">
                    <div class="text-blue-600 text-2xl"><i class="bi bi-journal-bookmark"></i></div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Katalog Lengkap</h3>
                        <p class="text-xs text-gray-500 mt-1">Buku pelajaran & fiksi tersedia.</p>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-blue-200 transition-colors">
                    <div class="text-blue-600 text-2xl"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Pinjam Mudah</h3>
                        <p class="text-xs text-gray-500 mt-1">Durasi pinjam 7 hari.</p>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-start gap-4 hover:border-blue-200 transition-colors">
                    <div class="text-blue-600 text-2xl"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Khusus Siswa</h3>
                        <p class="text-xs text-gray-500 mt-1">Login dengan akun siswa.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div
            class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">

            <div class="text-center md:text-left">
                <p class="font-semibold text-gray-700">Perpustakaan Pena Pustaka</p>
                <p class="text-xs mt-1">Jl. Syam Ratulangi, Rejosari Mataram</p>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <i class="bi bi-clock"></i>
                    <span class="text-xs">Senin - Sabtu (08.00 - 16.00)</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-telephone"></i>
                    <span class="text-xs">(0725) 7568065</span>
                </div>
            </div>

            <p class="text-xs">&copy; {{ date('Y') }} Pena Pustaka</p>
        </div>
    </footer>

</body>

</html>
