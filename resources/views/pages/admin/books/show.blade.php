@extends('layout.master')
@section('title', 'Detail component')
@section('content')

<div x-data="{ open: false }" class="min-h-screen w-full flex items-center justify-center p-4 md:p-6 overflow-hidden relative">

    <div
        class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl shadow-blue-900/10 overflow-hidden flex flex-col max-h-[90vh] overflow-y-auto scroll-smooth relative z-10">

        <div
            class="bg-white/90 backdrop-blur-md sticky top-0 z-20 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('books') }}"
                class="group flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors font-medium text-sm">
                <div class="px-2 py-1 bg-gray-100 rounded-full group-hover:bg-blue-100 transition duration-300">
                    <i class="bi bi-chevron-left text-lg"></i>
                </div>
                Kembali
            </a>
            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $book->stock > 0 ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                    {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                </span>
                <span
                    class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-xs font-bold uppercase tracking-wide">
                    {{ $book->category->name ?? 'Umum' }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-10">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12">

                <div class="shrink-0 mx-auto md:mx-0 w-48 md:w-64 flex flex-col gap-6">
                    <div
                        class="aspect-2/3 rounded-xl overflow-hidden shadow-xl shadow-gray-200 border border-gray-100 relative group">
                        @if ($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <i class="bi bi-book text-6xl opacity-50"></i>
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <div class="text-center md:hidden">
                        <div class="flex items-center justify-center gap-1 text-yellow-400 text-xl">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 mt-1 font-medium">{{ number_format($avgRating, 1) }} / 5.0
                        </p>
                    </div>
                </div>

                <div class="flex-1 flex flex-col h-full">
                    <div class="mb-6">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-2 tracking-tight">
                            {{ $book->title }}</h1>
                        <p class="text-lg text-gray-600 font-medium">Penulis: <span
                                class="text-blue-600">{{ $book->author }}</span></p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Penerbit
                            </p>
                            <p class="text-sm font-bold text-gray-800 truncate" title="{{ $book->publisher }}">
                                {{ $book->publisher }}</p>
                        </div>
                        <div class="md:ml-8">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Tahun</p>
                            <p class="text-sm font-bold text-gray-800">{{ $book->publication_year }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Stok</p>
                            <p class="text-sm font-bold text-gray-800 {{ $book->stock < 3 ? 'text-red-600' : '' }}">
                                {{ $book->stock }} Eks</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Rating</p>
                            <div class="flex items-center gap-1 text-yellow-500 text-sm font-bold">
                                <i class="bi bi-star-fill"></i> {{ number_format($avgRating, 1) }}
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-blue prose-sm max-w-none text-gray-600 leading-relaxed">
                        <h3 class="text-gray-900 font-bold text-lg mb-3 flex items-center gap-2">
                            <i class="bi bi-text-paragraph text-blue-500"></i> Sinopsis
                        </h3>
                        <p class="whitespace-pre-line text-justify">{{ $book->synopsis }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-2 bg-gray-50 border-t border-b border-gray-100"></div>

        <div class="p-6 md:p-10 bg-white pb-20">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-chat-square-quote text-blue-600"></i> Ulasan Pembaca
                    <span
                        class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs ml-2 border border-gray-200">{{ $book->reviews->count() }}</span>
                </h3>
            </div>

            <div class="space-y-6">
                @forelse ($book->reviews as $review)
                    <div class="flex gap-4 pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                        <div
                            class="shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-full bg-linear-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md ring-2 ring-white">
                            {{ substr($review->user->full_name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <h5 class="font-bold text-gray-900">{{ $review->user->full_name }}</h5>
                                <span
                                    class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex text-yellow-400 text-xs mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $review->comment }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 px-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white shadow-sm mb-4">
                            <i class="bi bi-chat-square-text text-3xl text-gray-300"></i>
                        </div>
                        <h4 class="text-gray-900 font-semibold mb-1">Belum ada ulasan</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div x-show="open" style="display: none;" x-on:keydown.escape.window="open = false" class="relative z-50"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100"
                    @click.away="open = false">

                    <div class="bg-gray-50 px-4 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-base font-bold leading-6 text-gray-900 flex items-center gap-2"
                            id="modal-title">
                            <i class="bi bi-bag-check text-blue-600 text-lg"></i>
                            Konfirmasi Peminjaman
                        </h3>
                        <button type="button" @click="open = false"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="px-4 py-6 sm:px-6">
                        <p class="text-sm text-gray-500 mb-6">
                            Apakah Anda yakin ingin meminjam buku ini? Silakan cek detail di bawah ini sebelum
                            melanjutkan.
                        </p>

                        <div class="flex gap-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100 mb-6">
                            <div class="shrink-0 w-16 h-24 rounded-lg overflow-hidden shadow-sm">
                                @if ($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <i class="bi bi-book"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 line-clamp-1">{{ $book->title }}</h4>
                                <p class="text-xs text-gray-500 mb-2">{{ $book->author }}</p>
                                <span
                                    class="px-2 py-0.5 bg-white text-blue-600 border border-blue-200 rounded text-[10px] font-bold uppercase">
                                    {{ $book->category->name }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Tanggal Peminjaman</span>
                                <span class="font-semibold text-gray-800">{{ now()->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Durasi Peminjaman</span>
                                <span class="font-semibold text-gray-800">7 Hari</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Denda jika tidak dikembalikan</span>
                                <span class="font-semibold text-gray-800">Rp. 10.000 / Hari</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-sm pt-3 border-t border-dashed border-gray-200">
                                <span class="text-gray-500">Wajib Kembali Sebelum</span>
                                <span
                                    class="font-bold text-blue-600">{{ now()->addDays(7)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100 gap-2">
                        <form action="" method="POST"
                            class="w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-lg bg-blue-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:w-auto transition-colors">
                                Ya, Pinjam Buku
                            </button>
                        </form>
                        <button type="button" @click="open = false"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
