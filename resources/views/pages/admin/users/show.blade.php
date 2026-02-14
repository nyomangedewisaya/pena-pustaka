@extends('layout.form')
@section('title', 'Detail Pengguna')

@section('content')

    <div class="min-h-screen w-full flex items-center justify-center p-4 md:p-6 overflow-hidden bg-gray-50/50">

        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl shadow-blue-900/10 overflow-hidden flex flex-col max-h-[90vh] overflow-y-auto scroll-smooth border border-gray-100">
           
            <div class="bg-white/90 backdrop-blur-md sticky top-0 z-10 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <a href="{{ route('users') }}" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors font-medium text-sm">
                    <div class="px-2 py-1 bg-gray-100 rounded-full hover:bg-blue-100 transition">
                        <i class="bi bi-arrow-left text-lg"></i>
                    </div>
                    Kembali
                </a>
               
                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm bg-blue-100 text-blue-700">
                    Siswa
                </span>
            </div>

            <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 p-8 md:p-12 text-center md:text-left overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="bi bi-person-badge text-9xl text-white"></i>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 md:gap-8">
                   
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-white p-1 shadow-xl shrink-0">
                        <div class="w-full h-full rounded-full bg-gray-100 flex items-center justify-center text-4xl md:text-5xl font-bold text-blue-600 uppercase">
                            {{ substr($user->full_name, 0, 1) }}
                        </div>
                    </div>

                    <div class="text-white">
                        <h1 class="text-xl md:text-3xl font-bold mb-1">{{ $user->full_name }}</h1>
                        <p class="text-blue-100 text-lg mb-4">{{ '@' . $user->username }}</p>
                       
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs border border-white/10">
                            <i class="bi bi-calendar-check"></i>
                            <span>Bergabung sejak {{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                   
                    <div>
                        <h3 class="text-gray-800 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                            <i class="bi bi-mortarboard text-blue-600"></i> Identitas Akademik
                        </h3>
                       
                        <dl class="space-y-5">
                            <div>
                                <dt class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Nomor Induk Siswa (NISN)</dt>
                                <dd class="text-gray-900 font-medium text-md mt-0.5 font-mono">
                                    {{ $user->nisn ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Kelas</dt>
                                <dd class="text-gray-900 font-medium text-md mt-1.5">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded border border-gray-200">
                                        {{ $user->class ?? '-' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-gray-800 font-bold text-lg border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                            <i class="bi bi-geo-alt text-blue-600"></i> Kontak & Alamat
                        </h3>
                       
                        <dl class="space-y-5">
                            <div>
                                <dt class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Nomor Telepon</dt>
                                <dd class="text-gray-900 font-medium text-md mt-0.5 flex items-center gap-2">
                                    @if($user->phone)
                                        <span class="bg-green-100 text-green-700 p-1 rounded text-xs"><i class="bi bi-whatsapp"></i></span>
                                        {{ $user->phone }}
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada nomor telepon</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Alamat Lengkap</dt>
                                <dd class="text-gray-700 text-xs leading-relaxed mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    {{ $user->address ?? 'Alamat belum dilengkapi.' }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection