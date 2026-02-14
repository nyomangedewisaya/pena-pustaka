@extends('layout.admin')
@section('title', 'Dashboard Admin')
@section('content')
    @php
        $stats = [
            [
                'label' => 'Total Kategori Aktif',
                'count' => $countCategories,
                'icon' => 'bi-collection',
                'bg_class' => 'bg-blue-500',      
                'from_class' => 'from-blue-600',  
            ],
            [
                'label' => 'Total Buku Aktif',
                'count' => $countBooks,
                'icon' => 'bi-book',
                'bg_class' => 'bg-yellow-400',
                'from_class' => 'from-yellow-500',
            ],
            [
                'label' => 'Total Anggota Aktif',
                'count' => $countUsers,
                'icon' => 'bi-people',
                'bg_class' => 'bg-violet-600',
                'from_class' => 'from-violet-700',
            ],
            [
                'label' => 'Total Transaksi',
                'count' => $countTransactions,
                'icon' => 'bi-arrow-left-right',
                'bg_class' => 'bg-green-600',
                'from_class' => 'from-green-700',
            ],
        ];
    @endphp

    <div class="bg-linear-to-r from-blue-600 to-blue-700 rounded-xl w-full p-5 flex justify-between items-center shadow-lg shadow-blue-500/30">
        <div class="flex flex-col -space-y-1">
            <h2 class="text-2xl text-white font-extrabold">Selamat Datang {{ Auth::user()->full_name }}!</h2>
            <p class="text-sm text-blue-100 font-medium mt-1">Pantau aktivitas perpustakaan Pena Pustaka disini.</p>
        </div>
        <div class="bg-white/10 p-3 rounded-full hidden sm:block">
            <img src="{{ asset('assets/images/logo.png') }}" class="rounded-full w-15 h-15 object-cover" alt="Logo" onerror="this.style.display='none'">
        </div>
    </div>

    <div class="grid lg:grid-cols-5 grid-cols-2 mt-6 gap-5">
        <div class="lg:col-span-1 col-span-2 relative flex flex-col items-center justify-start p-5 py-6 pl-6 rounded-xl border border-gray-100 bg-linear-to-r from-blue-400 to-blue-700 text-white shadow-xl shadow-gray-200/50 hover:scale-[1.02] duration-200 group overflow-hidden">
            <div class="flex items-center gap-1.5">
                <i class="bi bi-currency-dollar text-sm bg-blue-400/90 rounded-full px-1.5 py-0.5"></i>
                <p class="text-sm font-medium">Pendapatan denda</p>
            </div>
            <h2 class="text-2xl font-bold mt-1">Rp. {{ number_format($totalFine, 0, ',', '.') }}</h2>
        </div>
        @foreach ($stats as $item)
            <div class="relative flex flex-col items-start justify-start p-5 py-6 pl-6 rounded-xl border border-gray-100 bg-linear-to-r from-white to-gray-50 {{ str_replace('bg-', 'to-', $item['bg_class']) }}/5 shadow-xl shadow-gray-200/50 hover:scale-[1.02] duration-200 group overflow-hidden">
                <div class="absolute top-0 right-0 p-3 rounded-bl-2xl {{ $item['bg_class'] }} text-white shadow-lg shadow-{{ str_replace('bg-', '', $item['bg_class']) }}/30">
                    <i class="bi {{ $item['icon'] }} text-2xl"></i>
                </div>
                
                <p class="text-gray-500 text-sm font-medium z-10">{{ $item['label'] }}</p>
                <h2 class="text-3xl font-bold text-gray-800 mt-1 z-10">{{ $item['count'] }}</h2>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-lg shadow-gray-200/40">
            <div class="flex items-center gap-4 mb-5">
                <div class="bg-yellow-500/10 px-3 py-2 rounded-full text-yellow-500">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">Stok Hampir Habis</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium truncate w-48 sm:w-auto">
                        Perhatikan buku dengan sisa stok sedikit!
                    </p>
                </div>
            </div>
            
            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-gray-700 text-sm text-left">
                    <thead class="uppercase font-semibold bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">No</th>
                            <th class="px-4 py-3 whitespace-nowrap">Judul</th>
                            <th class="px-4 py-3 whitespace-nowrap">Pengarang</th>
                            <th class="px-4 py-3 whitespace-nowrap">Penerbit</th>
                            <th class="px-4 py-3 whitespace-nowrap">Tahun</th>
                            <th class="px-4 py-3 whitespace-nowrap text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($lowestStockBook as $item)
                            <tr class="hover:bg-gray-50/50 duration-150">
                                <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->title }}</td>
                                <td class="px-4 py-3">{{ $item->author }}</td>
                                <td class="px-4 py-3">{{ $item->publisher }}</td>
                                <td class="px-4 py-3">{{ $item->publication_year }}</td>
                                <td class="px-4 py-3 font-bold text-center text-rose-500 bg-rose-50 rounded-lg">{{ $item->stock }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-4 text-center text-gray-500">Aman, stok buku tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-lg shadow-gray-200/40 mb-5">
            <div class="flex items-center gap-4 mb-5">
                <div class="bg-green-500/10 px-3 py-2 rounded-full text-green-600">
                    <i class="bi bi-clock-history text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium truncate w-48 sm:w-auto">
                        5 transaksi terakhir yang tercatat sistem.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="w-full text-gray-700 text-sm text-left">
                    <thead class="uppercase font-semibold bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">No</th>
                            <th class="px-4 py-3 whitespace-nowrap">Peminjam</th>
                            <th class="px-4 py-3 whitespace-nowrap">Buku</th>
                            <th class="px-4 py-3 whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="px-4 py-3 whitespace-nowrap">Jatuh Tempo</th>
                            <th class="px-4 py-3 whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($newestTransactions as $item)
                            <tr class="hover:bg-gray-50/50 duration-150">
                                <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $item->user->full_name }}</td>
                                <td class="px-4 py-3">{{ $item->book->title }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->late_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($item->status == 'borrowed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="bi bi-hourglass-split"></i> Dipinjam
                                        </span>
                                    @elseif($item->status == 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="bi bi-dash-circle"></i> Menunggu
                                        </span>
                                    @elseif($item->status == 'returned')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                            <i class="bi bi-exclamation-circle"></i> Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-4 text-center text-gray-500">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection