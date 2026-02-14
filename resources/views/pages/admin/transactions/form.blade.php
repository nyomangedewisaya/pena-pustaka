@extends('layout.form')
@section('title', 'Form Transaksi')
@section('content')

    <div class="bg-white rounded-xl shadow-xl shadow-gray-200/50 w-full max-w-xl border border-gray-100 overflow-hidden">
        
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="bg-blue-600/10 px-4 py-3 rounded-full text-blue-600 flex items-center justify-center">
                    <i class="bi bi-arrow-left-right text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">Tambah Transaksi</h2>
                    <p class="text-sm text-gray-500">Buat peminjaman buku baru</p>
                </div>
            </div>
            <a href="{{ route('transactions') }}" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Anggota</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400 text-lg"></i>
                        </div>
                        <select name="user_id" 
                            class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white appearance-none cursor-pointer
                            focus:outline-none  focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('user_id') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                            <option value="">-- Cari Nama Anggota --</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->full_name }} ({{ $item->class }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('user_id')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Buku</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-book text-gray-400 text-lg"></i>
                        </div>
                        <select name="book_id" 
                            class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white appearance-none cursor-pointer
                            focus:outline-none  focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('book_id') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                            <option value="">-- Cari Judul Buku --</option>
                            @foreach ($books as $item)
                                <option value="{{ $item->id }}" {{ old('book_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->title }} - {{ $item->author }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('book_id')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 flex gap-3 items-start">
                    <i class="bi bi-info-circle text-blue-600"></i>
                    <div class="text-xs text-blue-800">
                        <p class="font-bold">Ketentuan Peminjaman:</p>
                        <ul class="list-disc ml-4 mt-1 space-y-0.5">
                            <li>Durasi peminjaman maksimal 7 hari.</li>
                            <li>Denda keterlambatan Rp 10.000 / hari.</li>
                        </ul>
                    </div>
                </div>

                <div class="flex gap-3 items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('transactions') }}" 
                       class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 shadow-lg shadow-blue-500/30 transition-all hover:scale-[1.02] active:scale-95 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection