@extends('layout.admin')
@section('title', 'Kelola Anggota')
@section('content')

    <x-header title="Kelola Anggota" icon="bi-people" link="/users/create" createLink="Tambah Anggota"
        caption="Kelola daftar anggota pena pustaka disini." countData="{{ $countData }}" />

    <div x-data="alpineInit()">
        <form action="{{ route('users') }}" method="GET"
            class="mb-6 flex flex-col md:flex-row items-center justify-end gap-3">
            <div class="flex flex-col md:flex-row items-center justify-end gap-4">
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request()->search }}"
                        class="w-full bg-white rounded-xl border border-gray-300 outline-none pl-10 px-4 py-1.5 focus:ring-1 focus:ring-blue-500"
                        placeholder="Cari nama, NISN, telepon...">
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-all duration-300 active:scale-95">
                        Filter <i class="bi bi-filter"></i>
                    </button>

                    @if (request()->hasAny(['search']))
                        <a href="{{ route('users') }}"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center gap-2 px-4 py-2 bg-rose-100 text-rose-600 text-sm font-medium rounded-xl hover:bg-rose-200 transition-all duration-300 active:scale-95 border border-rose-200">
                            Reset <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="bg-white rounded-lg border border-gray-200 mt-5 overflow-x-auto shadow-sm">
            <table class="w-full text-gray-700 text-left">
                <thead class="uppercase font-medium text-xs bg-gray-100 text-gray-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-nowrap">No</th>
                        <th class="px-4 py-3 font-semibold text-nowrap">Nama Anggota</th>
                        <th class="px-4 py-3 font-semibold text-nowrap">NISN</th>
                        <th class="px-4 py-3 font-semibold text-nowrap">Kelas</th>
                        <th class="px-4 py-3 font-semibold text-nowrap">Telepon</th>
                        <th class="px-4 py-3 font-semibold text-nowrap">Username</th>
                        <th class="px-4 py-3 font-semibold text-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 border-t border-gray-200">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50 duration-150">
                            <td class="px-4 py-3 font-medium text-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-700 text-nowrap">{{ $item->full_name }}</td>
                            <td class="px-4 py-3 font-medium text-gray-600 text-nowrap font-mono">{{ $item->nisn }}</td>
                            <td class="px-4 py-3 font-medium text-nowrap">
                                <span
                                    class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-semibold border border-gray-200">
                                    {{ $item->class }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-600 text-nowrap">{{ $item->phone }}</td>
                            <td class="px-4 py-3 font-medium text-blue-600 text-nowrap">{{ $item->username }}</td>
                            <td class="px-4 py-3 font-medium text-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('users.show', $item->id) }}"
                                        class="view-button px-2 py-1.5 flex items-center rounded-lg shadow-sm"
                                        title="Detail">
                                        <i class="bi bi-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $item->id) }}" class="primary-button px-2 py-1.5 flex items-center rounded-lg shadow-sm" title="Edit"
                                        class="primary-button px-2 py-1.5 flex items-center rounded-lg shadow-sm"
                                        title="Edit">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                    <button @click="openDataUser(@js($item))"
                                        class="danger-button px-2 py-1.5 flex items-center rounded-lg shadow-sm"
                                        title="Hapus">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-gray-50">
                            <td colspan="7" class="px-4 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="bi bi-inbox text-5xl text-gray-400 mb-1"></i>
                                        <p class="text-sm font-medium text-gray-600">Tidak ada data anggota ditemukan atau
                                            kosong.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                                        Anggota</h3>
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-500">
                                            Apakah anda yakin ingin menghapus data anggota <span
                                                class="font-bold text-gray-900" x-text="dataUser.full_name"></span>?
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
                            <form :action="dataUser.action" method="POST" class="w-full sm:w-auto sm:ml-3">
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
                dataUser: {
                    id: '',
                    full_name: '',
                    action: ''
                },
                openDataUser(data) {
                    this.dataUser.id = data.id;
                    this.dataUser.full_name = data.full_name;
                    this.dataUser.action = `/users/${data.id}/delete`;
                    this.deleteModal = true;
                },
            }
        }
    </script>
@endsection
