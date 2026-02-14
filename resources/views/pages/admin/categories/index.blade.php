@extends('layout.admin')
@section('title', 'Kategori Pena Pusaka')
@section('content')

    <div x-data="alpineInit()">
        <x-header title="Kelola Kategori" icon="bi-collection" link="/categories/create" createLink="Tambah Kategori"
            caption="Kelola semua kategori buku anda disini." countData="{{ $countData }}" />

        <div class="flex flex-col md:flex-row items-center justify-end gap-4 mb-6">
            <form action="{{ route('categories') }}" method="GET"
                class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                        placeholder="Cari nama kategori...">
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-all duration-300 active:scale-95">
                        Filter <i class="bi bi-filter"></i>
                    </button>

                    @if (request()->hasAny(['search']))
                        <a href="{{ route('categories') }}"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 px-4 py-2 bg-rose-100 text-rose-600 text-sm font-medium rounded-xl hover:bg-rose-200 transition-all duration-300 active:scale-95 border border-rose-200">
                            Reset <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-xl shadow-gray-200/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-nowrap w-16">
                                No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-nowrap">Nama
                                Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-nowrap">
                                Jumlah Buku</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-nowrap text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($data as $item)
                            <tr class="hover:bg-blue-50/30 transition duration-150 group">
                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-700 whitespace-nowrap">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if ($item->books()->count() > 0)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                                            <i class="bi bi-book mr-1.5"></i> {{ $item->books()->count() }} Buku
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                            <i class="bi bi-journal-x mr-1.5"></i> Kosong
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('categories.edit', $item->id) }}"
                                            class="primary-button px-2 py-1.5 flex items-center" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button @click="openDataCategory(@js($item))"
                                            class="danger-button px-2 py-1.5 flex items-center" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-inbox text-5xl text-gray-400 mb-1"></i>
                                        <p class="text-sm font-medium text-gray-600">Tidak ada data kategori ditemukan atau kosong.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="h-10"></div>

        <div x-show="deleteModal === true" x-cloak class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div x-show="deleteModal === true" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity">
            </div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="deleteModal === true" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        @click.outside="deleteModal = false"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">

                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="pt-2 text-lg font-semibold leading-6 text-gray-900" id="modal-title">Hapus
                                        Kategori</h3>
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-500">
                                            Apakah anda yakin ingin menghapus kategori <span class="font-bold text-gray-900"
                                                x-text="dataCategory.name"></span>?
                                        </p>
                                        <p
                                            class="text-xs text-rose-500 mt-2 bg-rose-50 px-2 py-1 rounded border border-rose-100">
                                            <i class="bi bi-info-circle mr-1"></i> Tindakan ini tidak dapat dibatalkan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <form :action="dataCategory.action" method="POST" class="w-full sm:w-auto sm:ml-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto transition-colors">
                                    Hapus
                                </button>
                            </form>
                            <button type="button" @click="deleteModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function alpineInit() {
            return {
                deleteModal: false,
                dataCategory: {
                    id: '',
                    name: '',
                    action: ''
                },
                openDataCategory(data) {
                    this.dataCategory.id = data.id;
                    this.dataCategory.name = data.name;
                    this.dataCategory.action = `/categories/${data.id}/delete`;
                    this.deleteModal = true;
                },
            }
        }
    </script>
@endsection
