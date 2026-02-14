@extends('layout.master')
@section('title', 'Katalog Buku Pena Pustaka')

@section('content')

    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b rounded-xl border-gray-200 shadow-sm mb-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between py-4 gap-4">

                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="{{ route('book.catalog') }}" class="flex items-center gap-3 group">
                        <div
                            class="relative w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden border-2 border-blue-100 group-hover:border-blue-400 transition-colors">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h1
                                class="text-lg md:text-xl font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">
                                Pena Pustaka
                            </h1>
                            <p class="text-xs text-gray-500 hidden sm:block">Katalog Buku</p>
                        </div>
                    </a>

                    <a href="{{ route('transactions.user') }}"
                        class="md:hidden flex items-center justify-center w-10 h-10 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <i class="bi bi-clock-history text-lg"></i>
                    </a>
                </div>

                <div class="w-full md:flex-1 md:max-w-2xl md:mx-4">
                    <form action="{{ route('book.catalog') }}" method="GET" class="relative group">
                        <div
                            class="flex items-center bg-gray-100/80 hover:bg-white border border-gray-200 group-hover:border-blue-300 rounded-xl transition-all focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-400 focus-within:bg-white overflow-hidden">

                            <div class="pl-4 text-gray-400">
                                <i class="bi bi-search"></i>
                            </div>

                            <input type="text" name="search" value="{{ request()->search }}"
                                class="w-full bg-transparent border-none px-3 py-2.5 text-sm focus:ring-0 placeholder-gray-400 text-gray-700 focus:outline-none"
                                placeholder="Cari judul atau penulis...">

                            <div class="h-6 w-px bg-gray-300 mx-1 hidden sm:block"></div>

                            <select name="category"
                                class="hidden sm:block w-70 px-4 bg-transparent border-none text-sm text-gray-600 focus:ring-0 focus:outline-none cursor-pointer hover:text-blue-600 truncate">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request()->category == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="m-1 ml-3 px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all cursor-pointer active:scale-95 duration-300">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('transactions.user') }}"
                        class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:border-blue-300 hover:text-blue-600 hover:shadow-md transition-all">
                        <i class="bi bi-clock-history text-lg"></i>
                        <span>Riwayat Saya</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 rounded-xl px-4 py-2.5
                           text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700
                           duration-300 cursor-pointer active:scale-95 font-medium transition-colors">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-5 pb-5 mt-5">
        @forelse ($data as $item)
            <div
                class="group bg-white rounded-2xl border border-gray-100 p-3 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative overflow-hidden">

                <div class="relative aspect-2/3 rounded-xl overflow-hidden mb-4 bg-gray-100">
                    @if ($item->cover)
                        <img src="{{ asset('storage/' . $item->cover) }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="bi bi-book text-4xl"></i>
                        </div>
                    @endif

                    <div class="absolute top-2 right-2">
                        <span
                            class="px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-blue-600 rounded-md shadow-sm border border-white/50">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>
                    </div>

                    @if ($item->stock <= 0)
                        <div class="absolute inset-0 bg-black/50 backdrop-blur-[1px] flex items-center justify-center">
                            <span class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full shadow-lg">Stok
                                Habis</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-900 leading-snug mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors"
                        title="{{ $item->title }}">
                        {{ $item->title }}
                    </h3>

                    <div class="text-xs text-gray-500 mb-4 flex items-center gap-2">
                        <span>{{ $item->publication_year }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span class="truncate max-w-25">{{ $item->author ?? 'Penulis' }}</span>
                    </div>

                    <div class="mt-auto pt-3 border-t border-gray-50">
                        <a href="{{ route('book.detail', $item->id) }}"
                            class="w-full py-2.5 px-4 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl text-sm font-semibold text-center transition-all duration-200 active:scale-95 flex items-center justify-center gap-2 group-hover/btn:shadow-lg">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <i class="bi bi-search text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum ada buku</h3>
                <p class="text-gray-500 text-sm max-w-sm mt-1">Saat ini belum ada buku yang tersedia dalam katalog.</p>
            </div>
        @endforelse
    </div>
@endsection
