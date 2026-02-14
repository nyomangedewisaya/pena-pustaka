@extends('layout.admin')
@section('title', 'Transaksi Pena Pustaka')

@section('content')

    <x-header title="Kelola Transaksi" icon="bi-arrow-left-right" countData="-" link="/transactions/create"
        createLink="Tambah Transaksi" caption="Kelola transaksi peminjaman buku disini" />

    <div x-data="alpineInit()">

        <div class="flex items-center w-full justify-center mb-6">
            <div class="flex items-center gap-1 bg-gray-100 p-1.5 rounded-2xl border border-gray-200">
                <button type="button" @click="viewOptions = 'peminjaman'"
                    class="rounded-xl cursor-pointer px-5 py-2.5 text-sm font-semibold active:scale-95 transition-all duration-200 ease-in-out flex items-center gap-2"
                    :class="viewOptions == 'peminjaman' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50'">
                    <i class="bi bi-box-arrow-up-right"></i> Peminjaman
                </button>
                <button type="button" @click="viewOptions = 'persetujuan'"
                    class="rounded-xl cursor-pointer px-5 py-2.5 text-sm font-semibold active:scale-95 transition-all duration-200 ease-in-out flex items-center gap-2"
                    :class="viewOptions == 'persetujuan' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50'">
                    <i class="bi bi-check-circle"></i> Persetujuan
                </button>
                <button type="button" @click="viewOptions = 'laporan'"
                    class="rounded-xl cursor-pointer px-5 py-2.5 text-sm font-semibold active:scale-95 transition-all duration-200 ease-in-out flex items-center gap-2"
                    :class="viewOptions == 'laporan' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50'">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </button>
            </div>
        </div>

        <div x-cloak x-show="transactionModal" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">

            <div x-show="transactionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="transactionModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        @click.outside="transactionModal = false"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-100">

                        <form :action="actionUrl" method="post">
                            @csrf
                            @method('PUT')

                            <div
                                class="bg-gray-50/50 px-4 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-100 text-blue-600 rounded-lg p-2">
                                        <i class="bi bi-journal-check text-xl"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <h3 class="text-base font-bold leading-6 text-gray-900">
                                            <span
                                                x-text="modalType === 'return' ? 'Kembalikan Buku' : 'Setujui Pengembalian'"></span>
                                        </h3>
                                        <p class="text-xs text-gray-500 font-medium" x-text="dataTransaksi.title"></p>
                                    </div>
                                </div>
                                <button type="button" @click="transactionModal = false"
                                    class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="px-4 py-6 sm:px-6">
                                <p class="text-sm font-medium text-gray-700 mb-4">Bagaimana kondisi buku saat dikembalikan?
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="condition" value="good" class="peer sr-only" required
                                            checked>
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-gray-100 bg-white transition-all duration-200 hover:border-blue-200 hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:shadow-sm">
                                            <i
                                                class="bi bi-check-circle-fill text-2xl text-gray-300 mb-2 group-hover:text-blue-400 peer-checked:text-blue-500 transition-colors"></i>
                                            <span
                                                class="text-xs font-bold text-gray-600 peer-checked:text-blue-700">Baik</span>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="condition" value="damaged" class="peer sr-only"
                                            required>
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-gray-100 bg-white transition-all duration-200 hover:border-orange-200 hover:bg-gray-50 peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-sm">
                                            <i
                                                class="bi bi-exclamation-triangle-fill text-2xl text-gray-300 mb-2 group-hover:text-orange-400 peer-checked:text-orange-500 transition-colors"></i>
                                            <span
                                                class="text-xs font-bold text-gray-600 peer-checked:text-orange-700">Rusak</span>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="condition" value="lost" class="peer sr-only" required>
                                        <div
                                            class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-gray-100 bg-white transition-all duration-200 hover:border-red-200 hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50/50 peer-checked:shadow-sm">
                                            <i
                                                class="bi bi-x-circle-fill text-2xl text-gray-300 mb-2 group-hover:text-red-400 peer-checked:text-red-500 transition-colors"></i>
                                            <span
                                                class="text-xs font-bold text-gray-600 peer-checked:text-red-700">Hilang</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div
                                class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100 gap-2">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 hover:bg-blue-700 hover:shadow-blue-500/30 sm:w-auto transition-all transform active:scale-95"
                                    x-text="modalType === 'return' ? 'Konfirmasi Kembali' : 'Setujui'">
                                </button>
                                <button type="button" @click="transactionModal = false"
                                    class="mt-2 sm:mt-0 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div x-cloak x-show="viewOptions == 'peminjaman'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-white rounded-xl shadow-xl shadow-gray-200/40 border border-gray-100 p-6">

            <div class="flex items-center gap-4 mb-6">
                <div class="bg-blue-100 text-blue-600 px-4 py-3 rounded-full">
                    <i class="bi bi-box-arrow-up-right text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Peminjaman Aktif</h2>
                    <p class="text-sm text-gray-500">Daftar buku yang sedang dipinjam anggota.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-gray-700 text-left text-sm">
                    <thead class="bg-gray-100 text-gray-500 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-5 py-3 whitespace-nowrap">No</th>
                            <th class="px-5 py-3 whitespace-nowrap">Buku</th>
                            <th class="px-5 py-3 whitespace-nowrap">Peminjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Jatuh Tempo</th>
                            <th class="px-5 py-3 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($borrowedTransactions as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-800">{{ $item->book->title }}</div>
                                    <div class="text-xs font-semibold text-blue-600 mt-1">{{ $item->book->category->name }}
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-800">{{ $item->user->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user->class }}</div>
                                </td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 font-medium text-rose-600">
                                    {{ \Carbon\Carbon::parse($item->late_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 text-center">
                                    <button @click="openData(@js($item), '{{ route('transactions.return.admin', $item->id) }}', 'return')" type="button"
                                        class="bg-green-500 hover:bg-green-600 text-white rounded-lg px-3 py-1.5 text-xs font-bold transition-all shadow-sm active:scale-95 inline-flex items-center gap-1">
                                        <i class="bi bi-box-arrow-in-down-left"></i> Kembalikan
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-500">
                                    Tidak ada data peminjaman aktif.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-cloak x-show="viewOptions == 'persetujuan'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-white rounded-xl shadow-xl shadow-gray-200/40 border border-gray-100 p-6">

            <div class="flex items-center gap-4 mb-6">
                <div class="bg-amber-100 text-amber-600 px-4 py-3 rounded-full">
                    <i class="bi bi-check-circle text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Menunggu Persetujuan</h2>
                    <p class="text-sm text-gray-500">Pengajuan pengembalian yang perlu konfirmasi admin.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-gray-700 text-left text-sm">
                    <thead class="bg-gray-100 text-gray-500 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-5 py-3 whitespace-nowrap">No</th>
                            <th class="px-5 py-3 whitespace-nowrap">Buku</th>
                            <th class="px-5 py-3 whitespace-nowrap">Peminjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Tanggal Kembali</th>
                            <th class="px-5 py-3 whitespace-nowrap">Jatuh Tempo</th>
                            <th class="px-5 py-3 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($approvedTransactions as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-800">{{ $item->book->title }}</div>
                                    <div class="text-xs font-semibold text-blue-600 mt-1">{{ $item->book->category->name }}
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="font-bold text-gray-800">{{ $item->user->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user->class }}</div>
                                </td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3 text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->return_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 font-medium text-rose-600">
                                    {{ \Carbon\Carbon::parse($item->late_date)->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('transactions.reject', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg px-3 py-1.5 text-xs font-bold transition-all shadow-sm active:scale-95 flex items-center gap-1">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        </form>
                                        <button @click="openData(@js($item), '{{ route('transactions.approve', $item->id) }}', 'approve')" type="button"
                                            type="button"
                                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-3 py-1.5 text-xs font-bold transition-all shadow-sm active:scale-95 flex items-center gap-1">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-gray-500">
                                    Semua pengajuan telah diproses.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-cloak x-show="viewOptions == 'laporan'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-white rounded-xl shadow-xl shadow-gray-200/40 border border-gray-200 p-6">

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-purple-100 text-purple-600 px-4 py-3 rounded-full">
                        <i class="bi bi-file-earmark-text text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Laporan Transaksi</h2>
                        <p class="text-sm text-gray-500">Riwayat semua transaksi perpustakaan.</p>
                    </div>
                </div>
                <form action="{{ route('transactions') }}" method="GET" class="flex items-center gap-4">
                    <select name="status" class="bg-white rounded-xl border border-gray-300 outline-none px-4 py-1.5 appearance-none focus:ring-1 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach (['borrowed' => 'Dipinjam', 'returned' => 'Dikembalikan', 'late' => 'Terlambat'] as $item => $label)
                            <option value="{{ $item }}" {{ request('status') == $item ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>

                    <select name="condition" class="bg-white rounded-xl border border-gray-300 outline-none px-4 py-1.5 appearance-none focus:ring-1 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">Semua Kondisi</option>
                        @foreach (['good' => 'Baik', 'damaged' => 'Rusak', 'lost' => 'Hilang'] as $item => $label)
                            <option value="{{ $item }}" {{ request('condition') == $item ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-gray-700 text-left text-sm">
                    <thead class="bg-gray-100 text-gray-500 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-5 py-3 whitespace-nowrap">No</th>
                            <th class="px-5 py-3 whitespace-nowrap">Judul Buku</th>
                            <th class="px-5 py-3 whitespace-nowrap">Nama Peminjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="px-5 py-3 whitespace-nowrap">Jatuh Tempo</th>
                            <th class="px-5 py-3 whitespace-nowrap">Tanggal Kembali</th>
                            <th class="px-5 py-3 whitespace-nowrap">Denda</th>
                            <th class="px-5 py-3 whitespace-nowrap">Status</th>
                            <th class="px-5 py-3 whitespace-nowrap">Kondisi</th>
                            <th class="px-5 py-3 whitespace-nowrap text-center">Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($allTransactions as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $item->book->title }}</td>
                                <td class="px-5 py-3 text-gray-600 text-nowrap">{{ $item->user->full_name }}</td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3">{{ \Carbon\Carbon::parse($item->late_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    {{ $item->return_date ? \Carbon\Carbon::parse($item->return_date)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td
                                    class="px-5 py-3 font-medium text-nowrap {{ $item->fine > 0 ? 'text-rose-600' : 'text-gray-400' }}">
                                    {{ $item->fine > 0 ? 'Rp ' . number_format($item->fine, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($item->status == 'borrowed')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-700">Dipinjam</span>
                                    @elseif($item->status == 'pending')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-700">Menunggu</span>
                                    @elseif($item->status == 'returned')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">Dikembalikan</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">Terlambat</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    @if ($item->condition == 'good')
                                        <span class="text-green-600 text-xs font-bold flex items-center gap-1"><i
                                                class="bi bi-check-circle"></i> Baik</span>
                                    @elseif($item->condition == 'damaged')
                                        <span class="text-orange-500 text-xs font-bold flex items-center gap-1"><i
                                                class="bi bi-exclamation-triangle"></i> Rusak</span>
                                    @elseif($item->condition == 'lost')
                                        <span class="text-red-600 text-xs font-bold flex items-center gap-1"><i
                                                class="bi bi-x-circle"></i> Hilang</span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-center">
                                    @if ($item->status == 'returned' || $item->status == 'late')
                                        <i
                                            class="bg-green-500 text-white px-2 py-1 rounded-lg bi bi-check-circle text-xs"></i>
                                    @else
                                        <i
                                            class="bg-gray-300 text-white px-2 py-1 rounded-lg bi bi-hourglass-split text-xs"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-8 text-center text-gray-500">
                                    Belum ada riwayat transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function alpineInit() {
            return {
                viewOptions: localStorage.getItem('transaction_tab') || 'peminjaman',
                init() {
                    this.$watch('viewOptions', value => {
                        localStorage.setItem('transaction_tab', value)
                    })
                },

                transactionModal: false,
                modalType: '',
                actionUrl: '',
                dataTransaksi: {
                    id: '',
                    title: ''
                },

                openData(data, url, type) {
                    this.dataTransaksi.id = data.id;
                    this.dataTransaksi.title = data.book.title;
                    this.actionUrl = url;
                    this.modalType = type;
                    this.transactionModal = true;
                }
            }
        }
    </script>
@endsection
