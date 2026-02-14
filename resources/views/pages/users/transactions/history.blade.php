<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riwayat Transaksi Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/font/font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
</head>

<body class="bg-gray-50 p-4 md:p-8">
    <x-alert />
    <div x-data="alpineInit()" class="w-full max-w-6xl mx-auto">

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between p-4 gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('book.catalog') }}"
                    class="flex items-center justify-center w-10 h-10 bg-gray-50 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-200">
                    <i class="bi bi-chevron-left text-lg"></i>
                </a>
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold text-gray-800">Koleksi Buku Saya</h2>
                    <p class="text-xs text-gray-500 font-medium">Kelola peminjaman dan riwayat bacaan Anda.</p>
                </div>
            </div>

            <div class="flex bg-gray-100/80 p-1 rounded-xl w-full md:w-auto">
                <button type="button" @click="viewOptions = 'dipinjam'"
                    :class="viewOptions === 'dipinjam' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="flex-1 md:flex-none px-6 py-2.5 rounded-lg text-xs transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="bi bi-book-half"></i>
                    Dipinjam
                    @if (count($borrowedTransactions) > 0)
                        <span
                            class="bg-blue-100 text-blue-600 text-[10px] px-1.5 py-0.5 rounded-md ml-1">{{ count($borrowedTransactions) }}</span>
                    @endif
                </button>

                <button type="button" @click="viewOptions = 'dikembalikan'"
                    :class="viewOptions === 'dikembalikan' ? 'bg-white text-blue-600 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="flex-1 md:flex-none px-6 py-2.5 rounded-lg text-xs transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="bi bi-clock-history"></i>
                    Riwayat
                </button>
            </div>
        </div>

        <div class="relative min-h-75">

            <div x-cloak x-show="viewOptions === 'dipinjam'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-gray-800 w-16">No</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Judul Buku</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Tanggal Pinjam</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Jatuh Tempo</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800 text-center">Status</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($borrowedTransactions as $item)
                                    <tr class="hover:bg-blue-50/30 transition-colors">
                                        <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800">{{ $item->book->title }}</span>
                                                <span
                                                    class="text-[10px] text-blue-500">{{ $item->book->category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            <div
                                                class="flex items-center gap-2 {{ \Carbon\Carbon::parse($item->late_date)->isPast() ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                                <i class="bi bi-hourglass-split"></i>
                                                {{ \Carbon\Carbon::parse($item->late_date)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if (\Carbon\Carbon::parse($item->late_date)->isPast())
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 animate-pulse">Terlambat</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Dipinjam</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item->status == 'borrowed')
                                                <button
                                                    @click="openReturnModal(
                                                    '{{ $item->book->title }}',
                                                    '{{ $item->id }}'
                                                )"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 flex items-center gap-1 mx-auto">
                                                    <i class="bi bi-box-arrow-in-down-left"></i> Kembalikan
                                                </button>
                                            @else
                                                <div
                                                    class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-bold w-fit mx-auto">
                                                    Menunggu</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                                    <i class="bi bi-journal-bookmark text-2xl text-gray-300"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">Tidak ada buku yang sedang
                                                    dipinjam.</p>
                                                <a href="{{ route('book.catalog') }}"
                                                    class="mt-2 text-blue-600 text-sm hover:underline">Cari buku di
                                                    katalog</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div x-cloak x-show="viewOptions === 'dikembalikan'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-gray-800 w-16">No</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Judul Buku</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Tanggal Pinjam</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Tanggal Kembali</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Denda</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800">Kondisi</th>
                                    <th class="px-6 py-4 font-semibold text-gray-800 text-center">Ulasan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($returnedTransactions as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-800">{{ $item->book->title }}</span>
                                                <span class="text-[10px] text-blue-500">
                                                    {{ $item->book->category->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ \Carbon\Carbon::parse($item->loan_date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            {{ \Carbon\Carbon::parse($item->return_date)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-nowrap">
                                            @if ($item->fine > 0)
                                                <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">Rp
                                                    {{ number_format($item->fine, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($item->condition == 'good')
                                                <span class="text-green-600 font-medium flex items-center gap-1">
                                                    <i class="bi bi-check-circle-fill"></i> Baik
                                                </span>
                                            @elseif($item->condition == 'lost')
                                                <span class="text-red-600 font-medium flex items-center gap-1">
                                                    <i class="bi bi-x-circle-fill"></i> Hilang
                                                </span>
                                            @else
                                                <span class="text-orange-500 font-medium flex items-center gap-1">
                                                    <i class="bi bi-exclamation-triangle-fill"></i> Rusak
                                                </span>
                                            @endif

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if (in_array($item->book_id, $reviewedBookIds))
                                                <span
                                                    class="text-gray-400 text-xs font-medium flex items-center justify-center gap-1 bg-gray-100 px-2 py-1 rounded-lg select-none">
                                                    <i class="bi bi-check-all text-lg"></i> Selesai
                                                </span>
                                            @else
                                                <button
                                                    @click="openReviewModal('{{ $item->book->title }}', '{{ $item->book_id }}')"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-all active:scale-95 flex items-center justify-center gap-1 mx-auto shadow-sm">
                                                    <i class="bi bi-star-fill"></i> Ulas
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="bi bi-clock-history text-3xl text-gray-300 mb-2"></i>
                                                <p class="text-gray-500">Belum ada riwayat pengembalian.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-cloak x-show="returnModal" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div x-show="returnModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div x-show="returnModal" @click.outside="returnModal = false"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex gap-3 items-center">
                            <div class="bg-green-100 text-green-600 rounded-full px-3 py-2"><i
                                    class="bi bi-box-arrow-in-down-left text-xl"></i></div>
                            <h3 class="text-base font-bold text-gray-900">Konfirmasi Pengembalian</h3>
                        </div>
                        <div class="px-6 py-5">
                            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin mengajukan pengembalian untuk
                                buku ini?</p>
                            <div class="bg-green-50 border border-green-100 rounded-xl p-4 flex flex-col gap-2">
                                <div class="flex justify-between items-start">
                                    <span class="text-xs text-green-600 font-bold uppercase tracking-wide">Judul
                                        Buku</span>
                                    <i class="bi bi-book text-green-300"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-800 line-clamp-1" x-text="bookTitle"></span>
                                <div class="grid grid-cols-2 gap-2 mt-1 pt-2 border-t border-green-100/50">
                                    <div>
                                        <p class="text-[10px] text-gray-500">Tanggal Pinjam</p>
                                        <p class="text-xs font-medium text-gray-700" x-text="loanDate"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500">Jatuh Tempo</p>
                                        <p class="text-xs font-bold text-rose-500" x-text="lateDate"></p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-4 text-center italic">*Pastikan Anda sudah membawa
                                buku fisik ke perpustakaan.</p>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 border-t border-gray-100">
                            <form :action="'/transactions/' + selectedTransactionId + '/return/user'" method="POST"
                                class="w-full sm:w-auto">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl bg-green-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-green-500/20 hover:bg-green-700 transition-all active:scale-95">Ya,
                                    Kembalikan</button>
                            </form>
                            <button type="button" @click="returnModal = false"
                                class="mt-2 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-cloak x-show="reviewModal" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div x-show="reviewModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div x-show="reviewModal" @click.outside="closeReviewModal()"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-gray-100">

                        <form action="{{ route('transactions.review') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" x-model="selectedBookId">
                            <input type="hidden" name="rating" x-model="rating">

                            <div
                                class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <div>
                                    <h3 class="text-base font-bold text-gray-900">Berikan Ulasan</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Buku: <span
                                            class="font-semibold text-blue-600" x-text="bookTitle"></span></p>
                                </div>
                                <button type="button" @click="closeReviewModal()"
                                    class="text-gray-400 hover:text-gray-600 transition-colors"><i
                                        class="bi bi-x-lg text-lg"></i></button>
                            </div>

                            <div class="px-6 py-6">
                                <div class="flex flex-col items-center mb-6">
                                    <span class="text-sm font-medium text-gray-600 mb-2">Beri Rating</span>
                                    <div class="flex gap-2">
                                        <template x-for="i in 5">
                                            <button type="button" @click="rating = i" @mouseenter="hoverRating = i"
                                                @mouseleave="hoverRating = 0"
                                                class="text-3xl transition-transform duration-200 star-hover focus:outline-none"
                                                :class="(hoverRating >= i || rating >= i) ? 'text-yellow-400' : 'text-gray-200'">
                                                <i class="bi bi-star-fill"></i>
                                            </button>
                                        </template>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2 h-4"
                                        x-text="rating > 0 ? rating + ' dari 5 Bintang' : 'Klik bintang untuk menilai'">
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar Anda</label>
                                    <textarea name="comment" rows="4"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all placeholder-gray-400 resize-none"
                                        placeholder="Tuliskan pengalaman membaca buku ini..."></textarea>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 border-t border-gray-100">
                                <button type="submit" :disabled="rating === 0"
                                    :class="rating === 0 ? 'opacity-50 cursor-not-allowed bg-gray-300' :
                                        'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20'"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-white text-sm font-bold transition-all active:scale-95">Kirim
                                    Ulasan</button>
                                <button type="button" @click="closeReviewModal()"
                                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-white border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition-colors">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function alpineInit() {
            return {
                viewOptions: localStorage.getItem('transaction_tab') || 'dipinjam',
                reviewModal: false,
                rating: 0,
                hoverRating: 0,
                returnModal: false,
                bookTitle: '',
                selectedBookId: '',
                loanDate: '',
                lateDate: '',

                init() {
                    this.$watch('viewOptions', value => {
                        localStorage.setItem('transaction_tab', value)
                    })
                },

                openReviewModal(title, bookId) {
                    this.bookTitle = title;
                    this.selectedBookId = bookId;
                    this.rating = 0;
                    this.reviewModal = true;
                },

                openReturnModal(title, id) {
                    this.bookTitle = title;
                    this.selectedTransactionId = id;
                    this.returnModal = true;
                },

                closeReviewModal() {
                    this.reviewModal = false;
                    this.rating = 0;
                    this.hoverRating = 0;
                }
            }
        }
    </script>
</body>

</html>
